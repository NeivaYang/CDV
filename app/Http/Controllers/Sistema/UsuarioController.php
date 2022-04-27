<?php

namespace App\Http\Controllers\Sistema;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\UserFuncaoCdc;
use Auth;
use DB;
use Session;
use App\Classes\Constantes\Notificacao;
use App\Classes\Configuracao\Funcao;
use App\Classes\Configuracao\Cdc;
use App\Classes\Negociacao\Oportunidade;
use Carbon\Carbon;

use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * This functions is deprecated
     * @deprecated
     */

    public function listarUsuarios(Request $req)
    {
        $filtro = $req->all();
        $usar_filtro = False;
        if (isset($filtro['filtro'])) {
            $usar_filtro = True;
        }

        $listaUsuarios = [];
        $idiomas = User::getListaDeIdiomas();
        if (Auth::User()->tipo_usuario != 0) {
            if($usar_filtro){
                $listaUsuarios = User::select('id','codigo','nome', 'celular', 'email', 'situacao')
                ->orderBy('created_at')
                ->where('admin','1')
                ->where(function ($query) use ($filtro) {
                    //Busca pelo nome
                    if(!empty($filtro['nome'])){
                        $query->where('nome', 'like', '%'.$filtro['nome'].'%');
                    }
                    //Busca apenas ativos
                    if(!empty($filtro['ativo']) && empty($filtro['inativo'])){
                        $query->where('situacao', 1);
                    }
                    //Busca apenas inativos
                    if(empty($filtro['ativo']) && !empty($filtro['inativo'])){
                        $query->where('situacao',  0);
                    }
                })
                ->paginate(25);

            } else {
                $listaUsuarios = User::select('id','codigo','nome', 'celular', 'email', 'situacao')
                ->orderBy('created_at')
                ->paginate(25);
            }
        } else {
            if ($usar_filtro) {
                $listaUsuarios = User::select('id','codigo','nome', 'celular', 'email', 'situacao')
                ->orderBy('created_at')
                ->where('admin','1')
                ->where(function ($query) use ($filtro){
                    //Busca pelo nome
                    if (!empty($filtro['nome'])) {
                        $query->where('nome', 'like', '%'.$filtro['nome'].'%');
                    }
                    //Busca apenas ativos
                    if (!empty($filtro['ativo']) && empty($filtro['inativo'])) {
                        $query->where('situacao', 1);
                    }
                    //Busca apenas inativos
                    if (empty($filtro['ativo']) && !empty($filtro['inativo'])) {
                        $query->where('situacao',  0);
                    }
                })
                ->paginate(25);
            } else {
                $listaUsuarios = User::select('id','codigo','nome', 'celular', 'email', 'situacao')
                ->where('admin','1')
                ->orderBy('created_at')
                ->paginate(25);
            }
        }

        //Alterando as chaves de idioma e papel para strings
        foreach ($listaUsuarios as $user) {
            if ($user->situacao == 0) {
                $user->situacao = __('usuarios.inativo');
            } else {
                $user->situacao = __('usuarios.ativo');
            }
        }
        
        return view('sistema.usuarios.gerenciarUsuarios', compact('listaUsuarios', 'idiomas'));     
    }

    public function getProfile($id) {
        $user = User::find($id);

        $userDatas = User::select('id', 'nome', 'email', 'celular', 'codigo_idioma')
        ->where('id', $user['id'])
        ->get();

        return view('sistema.usuarios.profileUsuario', compact('userDatas' , 'user'));
    }

    public function alteraInfoPerfil(Request $req) 
    {
        $dados = $req->all();
        $token = $dados['_token'];

        $updateItem = array(
            '_token' => $token,
            'nome' => $dados['nome'],
            'email' => $dados['email'],
            'celular' => $dados['celular'],
            'codigo_idioma' => $dados['codigo_idioma']
        );
        User::find($dados['id'])->update($updateItem);
        unset($updateItem);

        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.edicaoSucesso", "success");
        return redirect()->route('dashboard');
    }

    //FUNÇÃO AJAX PARA ALTERAÇÃO DE SENHA - RECEBE AS INFORMAÇÕES E RETORNA UM JSON
    public function alterarSenha(Request $req)
    {
        $dados = $req->all();
        $token = $dados['_token'];
        $senhaAtual = $dados['currentPassword'];
        $novaSenha = $dados['newPassword'];
        $confirmarNovaSenha = $dados['confirmNewPassword'];
        $verifyHashPw = Hash::check($senhaAtual, Auth::user()->password);

        if ((mb_strlen($dados['currentPassword']) >= 6) && ( $verifyHashPw == true) && ($novaSenha === $confirmarNovaSenha)) {
            $hashedpw = bcrypt($dados['newPassword']);
            $updateItem = array(
                '_token' => $token,
                'password' => $hashedpw
            );
            User::find($dados['id'])->update($updateItem);
            unset($updateItem);

            Notificacao::gerarAlert("notificacao.sucesso", "notificacao.edicaoSucesso", "success");
            return redirect()->route('dashboard');
        } else {
            Notificacao::gerarAlert("notificacao.erro", "danger");
            return redirect()->back();
        }

    }

    public function inserirUsuario(Request $req) {
        $dados = $req->all();

        /**
         * Concatena o nome completo e gera o código do usuário
         */
        $dados['nome'] = $dados['nome'].' '.trim($dados['sobrenome']);
        $codigo = User::gerarCodigoUser($dados['nome']);
        $dados += ["codigo" => $codigo];
        $dados += ["admin" => '1'];

        $verifica =  User::where('email', $dados['email'])->first();
        if (!empty($verifica)) {
            Notificacao::gerarAlert("notificacao.erro", "notificacao.falhaEmail", "danger");
            return redirect()->back();
        }
        
        $dados['password'] = bcrypt($dados['password']);
        $id_user = User::create($dados);

        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.cadastroSucesso", "success");

        return redirect()->back();       
    }

    public function getUsuario($id)
    {
        $user = User::find($id);

        return $user;
    }

    public function editaUsuario(Request $req)
    {    
        $dados = $req->all();

        if (User::validaEmail($dados['email'], $dados['id'])) {
            if ( !isset($dados['password']) || empty($dados['password']) ) {
                unset($dados['password']);
            } else {
                $dados['password'] = bcrypt($dados['password']);
            }

            User::find($dados['id'])->update($dados);

            Notificacao::gerarAlert("notificacao.sucesso", "notificacao.edicaoSucesso", "success");

            return redirect()->back();
        } else {
            Notificacao::gerarAlert("notificacao.erro", "notificacao.falhaEmail", "danger");

            return redirect()->back();
        }
    }

    public function removerUsuario($id)
    {
        $user = User::find($id);

        return $user;
    }

    public function excluiUsuario(Request $req)
    {
        $dados = $req->all();

        User::find($dados['id'])->delete();
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.remocaoSucesso", "success");

        return redirect()->back();
    }

    public function validarEmailUsuario($id_usuario)
    {
        $usuario = User::find($id_usuario);
        if (!empty($usuario)) {
            DB::table('users')
                ->where('id', $id_usuario)
                ->update(['email_verified_at' => DB::raw('now()'), 'updated_at' => DB::raw('now()')]);
        }

        return redirect()->route('usuarios.listar');
    }


    /** -----------------------------------
     * Métodos para tratar do colaboradores
     */
    public function listarColaboradores(Request $req)
    {
        //dd(Auth::user()->id);
        //dd(Auth::user()->admin);
        $filtro = $req->all();
        $usar_filtro = (isset($filtro['filtro'])) ? True : False;

        $listaUsuarios = [];
        $idiomas = User::getListaDeIdiomas();
        /**
         * Buscando o CDC do usuário, caso não seja administrador
         */
        $cdc_user = 0;
        $funcao_user = 0;        

        $buscaCDC = User::select('cdcs.cdc', 'user_funcao_cdc.id_funcao')
                        ->join('user_funcao_cdc', 'user_funcao_cdc.id_user', '=', 'users.id')
                        ->join('funcoes', 'funcoes.id', '=', 'user_funcao_cdc.id_funcao')
                        ->join('cdcs', 'cdcs.id', '=', 'user_funcao_cdc.id_cdc')
                        ->where('users.id', Auth::user()->id)->get();
        foreach($buscaCDC as $item){ 
            $cdc_user = $item->cdc;
            $funcao_user = $item->id_funcao;
        }

        if ($usar_filtro) {
            
            $listaUsuarios = User::select('users.id','users.codigo','users.nome', 'users.celular', 'users.email', 'users.situacao', 'funcoes.nome as funcao', 'cdcs.cdc')
            ->join('user_funcao_cdc', 'user_funcao_cdc.id_user', '=', 'users.id')
            ->join('funcoes', 'funcoes.id', '=', 'user_funcao_cdc.id_funcao')
            ->join('cdcs', 'cdcs.id', '=', 'user_funcao_cdc.id_cdc')
            ->orderBy('users.created_at')
            ->where(function ($query) use ($filtro){
                //Busca pelo nome
                if(!empty($filtro['nome'])){
                    $query->where('users.nome', 'like', '%'.$filtro['nome'].'%');
                }
                //Busca apenas ativos
                if(!empty($filtro['ativo']) && empty($filtro['inativo'])){
                    $query->where('users.ativo', 1);
                }
                //Busca apenas inativos
                if(empty($filtro['ativo']) && !empty($filtro['inativo'])){
                    $query->where('users.ativo',  0);
                }

                //Seleciona apenas usuários colaboradores "filhos" do colaborador logado
                if (!Auth::user()->admin) {
                    $cdcFilhos = Cdc::buscaCdcFilhos($cdc_user);
                    $query->where('users.id', '<>', Auth::user()->id)
                          ->whereRaw("find_in_set(cdc, '".$cdcFilhos."') > 0");
                }
            })
            ->paginate(25);
        } else {
            
            $listaUsuarios = User::select('users.id','users.codigo','users.nome', 'users.celular', 'users.email', 'users.situacao', 'funcoes.nome as funcao', 'cdcs.cdc')
            ->join('user_funcao_cdc', 'user_funcao_cdc.id_user', '=', 'users.id')
            ->join('funcoes', 'funcoes.id', '=', 'user_funcao_cdc.id_funcao')
            ->join('cdcs', 'cdcs.id', '=', 'user_funcao_cdc.id_cdc')
            ->orderBy('users.created_at')
            ->where(function ($query) use ($cdc_user) {
                //Seleciona apenas usuários colaboradores "filhos" do colaborador logado
                if (!Auth::user()->admin) {
                    $cdcFilhos = Cdc::buscaCdcFilhos($cdc_user);
                    $query->where('users.id', '<>', Auth::user()->id)
                          ->whereRaw("find_in_set(cdc, '".$cdcFilhos."') > 0");
                }else{
                    
                }
            })
            //->get();            
            ->paginate(25);
        }

        foreach ($listaUsuarios as $usuario) {
            $usuario['situacao'] = (($usuario['situacao']) ? __('colaborador.ativo') : __('colaborador.inativo'));
        }

        $funcoes = '';
        $cdcs = '';    
        if (Auth::user()->admin) {
            $funcoes = Funcao::select('id','nome')->get();
            $cdcs = Cdc::select('id','nome','cdc')->get();    
        } else {
            $cdcFilhos = Cdc::buscaCdcFilhos($cdc_user);
            $funcaoFilhos = Funcao::buscaFuncaoFilhos($funcao_user);
    
            $cdcs = DB::table('cdcs')->select('id','nome','cdc')->whereRaw("find_in_set(cdc, '".$cdcFilhos."') > 0")->get();
            $funcoes = DB::table('funcoes')->select('id','nome')->whereRaw("find_in_set( id, '".$funcaoFilhos."') > 0")->get();  
        }

        return view('organizacao.colaborador.gerenciar', compact('listaUsuarios','idiomas','funcoes','cdcs'));     
    }
    
    public function cadastrarColaborador()
    {
        $idiomas = User::getListaDeIdiomas();

        /**
         * Buscando o CDC do usuário, caso não seja administrador
         */
        $cdc_user = 0;
        $funcao_user = 0;
        //if (!Auth::user()->admin) {
            $buscaCDC = User::select('cdcs.cdc', 'user_funcao_cdc.id_funcao')
                            ->join('user_funcao_cdc', 'user_funcao_cdc.id_user', '=', 'users.id')
                            ->join('funcoes', 'funcoes.id', '=', 'user_funcao_cdc.id_funcao')
                            ->join('cdcs', 'cdcs.id', '=', 'user_funcao_cdc.id_cdc')
                            ->where('users.id', Auth::user()->id)->get();
            foreach($buscaCDC as $item){ 
                $cdc_user = $item->cdc;
                $funcao_user = $item->id_funcao;
            }
        //}

        /**
         * Seleciona as funções e cdcs
         */
        $funcoes = '';
        $cdcs = '';    
        if (Auth::user()->admin) {
            $funcoes = Funcao::select('id','nome')->get();
            $cdcs = Cdc::select('id','nome','cdc')->get();    
        } else {
            
            $cdcFilhos = Cdc::buscaCdcFilhos($cdc_user);
            $funcaoFilhos = Funcao::buscaFuncaoFilhos($funcao_user);            
            
            $cdcs = DB::table('cdcs')->select('id','nome','cdc')->whereRaw("find_in_set(cdc, '".$cdcFilhos."') > 0")->get();            
            $funcoes = DB::table('funcoes')->select('id','nome')->whereRaw("find_in_set( id, '".$funcaoFilhos."') > 0")->get(); 
        }

        /**
         * Seleciona os CDCs
         */
        /*
        $cdcs = "";
        if (Auth::user()->admin) {
            $cdcs = Cdc::select('id','nome','cdc')->get();    
        } else {
            $cdc_user = Session::get('cdc');
            $cdcFilhos = Session::get('cdcFilhos');
            $cdcFilhos = ($cdcFilhos == 0) ? $cdc_user : $cdcFilhos.','.$cdc_user;
    
            $cdcs = DB::table('cdcs')->select('id','nome','cdc')->whereRaw("find_in_set(cdc, '".$cdcFilhos."') > 0")->get();
        }
        */

        return view('organizacao.colaborador.cadastrar', compact('idiomas','cdcs', 'funcoes'));
    }

    public function salvarColaborador(Request $req)
    {
        $dados = $req->all();
        $id_funcao = $dados['id_funcao'];
        $id_cdc = $dados['id_cdc'];

        /**
         * Concatena o nome completo e gera o código do usuário
         */
        //$dados['nome'] = $dados['nome'].' '.trim($dados['sobrenome']);
        $codigo = User::gerarCodigoUser($dados['nome']);
        $dados += ["codigo" => $codigo];
        
        $validacao = User::where('email', $dados['email'])->count();
        if ($validacao > 0) {
            Notificacao::gerarAlert("notificacao.erro", "notificacao.falhaEmail", "danger");
        } else {
            /**
             * Prepara matriz e grava o usuário
             */
            unset($dados['id_funcao']);
            unset($dados['id_cdc']);
            $dados['password'] = bcrypt($dados['password']);
            
            // Atualiza o campo de verificação de e-mail.
            $dados['email_verified_at'] = Carbon::now()->toDateTimeString();

            $user_new = User::create($dados);
            $id_user = $user_new['id'];
        
            $dados2 = array('id_user' => $id_user, 'id_funcao' => $id_funcao, 'id_cdc' => $id_cdc);
            $id_user_funcao_cdc = UserFuncaoCdc::create($dados2);

            Notificacao::gerarAlert("notificacao.sucesso", "notificacao.cadastroSucesso", "success");            
        }

        return redirect()->route('colaborador.listar');
    }

    public function editarColaborador($id)
    {
        $colaborador = User::select('users.*','user_funcao_cdc.id_funcao', 'user_funcao_cdc.id_cdc')
                           ->join('user_funcao_cdc', 'user_funcao_cdc.id_user', '=', 'users.id')
                           ->where('users.id', $id)
                           ->first();

        $idiomas = User::getListaDeIdiomas();

        /**
         * Buscando o CDC do usuário, caso não seja administrador
         */
        $cdc_user = 0;
        $funcao_user = 0;
        if (!Auth::user()->admin) {
            $buscaCDC = User::select('cdcs.cdc', 'user_funcao_cdc.id_funcao')
                            ->join('user_funcao_cdc', 'user_funcao_cdc.id_user', '=', 'users.id')
                            ->join('funcoes', 'funcoes.id', '=', 'user_funcao_cdc.id_funcao')
                            ->join('cdcs', 'cdcs.id', '=', 'user_funcao_cdc.id_cdc')
                            ->where('users.id', Auth::user()->id)->get();
            foreach($buscaCDC as $item){ 
                $cdc_user = $item->cdc;
                $funcao_user = $item->id_funcao;
            }
        }

        /**
         * Seleciona as funções e cdcs
         */
        $funcoes = '';
        $cdcs = '';    
        if (Auth::user()->admin) {
            $funcoes = Funcao::select('id','nome')->get();
            $cdcs = Cdc::select('id','nome','cdc')->get();    
        } else {
            $cdcFilhos = Cdc::buscaCdcFilhos($cdc_user);
            $funcaoFilhos = Funcao::buscaFuncaoFilhos($funcao_user);
    
            $cdcs = DB::table('cdcs')->select('id','nome','cdc')->whereRaw("find_in_set(cdc, '".$cdcFilhos."') > 0")->get();
            $funcoes = DB::table('funcoes')->select('id','nome')->whereRaw("find_in_set( id, '".$funcaoFilhos."') > 0")->get();  
        }

        return view('organizacao.colaborador.editar', compact('colaborador','idiomas','cdcs', 'funcoes'));
    }

    public function atualizarColaborador(Request $req)
    {
        $dados = $req->all();
        $id_user = $dados['id'];
        $id_funcao = $dados['id_funcao'];
        $id_cdc = $dados['id_cdc'];

        if (User::validaEmail($dados['email'], $dados['id'])) {
            if ( !isset($dados['password']) || empty($dados['password']) ) {
                unset($dados['password']);
            } else {
                $dados['password'] = bcrypt($dados['password']);
            }

            /**
             * Prepara matriz e grava o usuário
             */
            unset($dados['id_funcao']);
            unset($dados['id_cdc']);
            User::find($dados['id'])->update($dados);

            $dados2 = array('id_user' => $id_user, 'id_funcao' => $id_funcao, 'id_cdc' => $id_cdc);
            $affected = UserFuncaoCdc::where('id_user', $id_user)->update($dados2);

            Notificacao::gerarAlert("notificacao.sucesso", "notificacao.edicaoSucesso", "success");
        } else {
            Notificacao::gerarAlert("notificacao.erro", "notificacao.falhaEmail", "danger");

        }

        return redirect()->route('colaborador.listar');
    }

    public function removerColaborador($id)
    {       
        $colaborador = User::select('users.*','user_funcao_cdc.id_funcao', 'user_funcao_cdc.id_cdc')
                           ->join('user_funcao_cdc', 'user_funcao_cdc.id_user', '=', 'users.id')
                           ->where('users.id', $id)
                           ->first();

        $validacao = Oportunidade::where('id_user',$id)->count();

        if ($validacao > 0) {
            Notificacao::gerarAlert("notificacao.erro", "colaborador.erro1", "danger");
            return redirect()->back();
        } else {
            $idiomas = User::getListaDeIdiomas();

            /**
             * Buscando o CDC do usuário, caso não seja administrador
             */
            $cdc_user = 0;
            $funcao_user = 0;
            if (!Auth::user()->admin) {
                $buscaCDC = User::select('cdcs.cdc', 'user_funcao_cdc.id_funcao')
                                ->join('user_funcao_cdc', 'user_funcao_cdc.id_user', '=', 'users.id')
                                ->join('funcoes', 'funcoes.id', '=', 'user_funcao_cdc.id_funcao')
                                ->join('cdcs', 'cdcs.id', '=', 'user_funcao_cdc.id_cdc')
                                ->where('users.id', Auth::user()->id)->get();
                foreach($buscaCDC as $item){ 
                    $cdc_user = $item->cdc;
                    $funcao_user = $item->id_funcao;
                }
            }
    
            /**
             * Seleciona as funções e cdcs
             */
            $funcoes = '';
            $cdcs = '';    
            if (Auth::user()->admin) {
                $funcoes = Funcao::select('id','nome')->get();
                $cdcs = Cdc::select('id','nome','cdc')->get();    
            } else {
                $cdcFilhos = Cdc::buscaCdcFilhos($cdc_user);
                $funcaoFilhos = Funcao::buscaFuncaoFilhos($funcao_user);
        
                $cdcs = DB::table('cdcs')->select('id','nome','cdc')->whereRaw("find_in_set(cdc, '".$cdcFilhos."') > 0")->get();
                $funcoes = DB::table('funcoes')->select('id','nome')->whereRaw("find_in_set( id, '".$funcaoFilhos."') > 0")->get();  
            }
    
            return view('organizacao.colaborador.deletar', compact('colaborador','idiomas','cdcs', 'funcoes'));                
        }
    }

    public function excluiColaborador(Request $req)
    {
        $dados = $req->all();
        $id = $dados['id'];

        $validacao = Oportunidade::where('id_user',$id)->count();

        if ($validacao > 0) {
            Notificacao::gerarAlert("notificacao.erro", "colaborador.erro1", "danger");
        } else {
            UserFuncaoCdc::where('id_user', $id)->delete();
            User::find($id)->delete();

            Notificacao::gerarAlert("notificacao.sucesso", "notificacao.remocaoSucesso", "success");
        }

        return redirect()->route('colaborador.listar');
    }
}
