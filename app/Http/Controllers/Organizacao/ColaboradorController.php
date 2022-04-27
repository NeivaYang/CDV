<?php

namespace App\Http\Controllers\Organizacao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\User_Cargo;
use Auth;
use DB;
use Session;
use App\Classes\Constantes\Notificacao;
use App\Classes\Configuracao\Cargo;
use App\Classes\Configuracao\Cdc;


class ColaboradorController extends Controller
{
    public function inserirColaborador(Request $req)
    {
        $dados = $req->all();

        $validacao = Colaborador::where('email', $dados['email'])->count();
        if ($validacao > 0) {
            Notificacao::gerarAlert("notificacao.erro", "notificacao.falhaEmail", "danger");
            return redirect()->back();
        }
        
        $dados['password'] = bcrypt($dados['password']);
        $dados['email_verified_at'] = date('Y-m-d H:i:s');
        $id_user = Colaborador::create($dados);

        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.cadastroSucesso", "success");
        return redirect()->back();       
    }

    public function listarColaboradores(Request $req)
    {
        $filtro = $req->all();
        $usar_filtro = False;
        if(isset($filtro['filtro'])){
            $usar_filtro = True;
        }

        $listaColaboradores = [];
        $idiomas = Colaborador::getListaDeIdiomas();
        if (Auth::User()->tipo_usuario != 0) {
            if($usar_filtro) {
                //$listaColaboradores = Colaborador::select('colaboradores.id','colaboradores.nome', 'colaboradores.celular', 'colaboradores.email', 'colaboradores.situacao', 'cargos.nome as cargo', 'concat(cdcs.cdc," ",cdcs.nome) as cdc')
                $listaColaboradores = Colaborador::select('colaboradores.id','colaboradores.nome', 'colaboradores.celular', 'colaboradores.email', 'colaboradores.situacao', 'cargos.nome as cargo', 'cdcs.cdc')
                ->join('cargos', 'cargos.id', '=', 'colaboradores.id_cargo')
                ->join('cdcs', 'cdcs.id', '=', 'colaboradores.id_cdc')
                ->orderBy('colaboradores.created_at')
                ->where(function ($query) use ($filtro) {
                    //Busca pelo nome
                    if(!empty($filtro['nome'])) {
                        $query->where('colaboradores.nome', 'like', '%'.$filtro['nome'].'%');
                    }
                    //Busca apenas ativos
                    if (!empty($filtro['ativo']) && empty($filtro['inativo'])) {
                        $query->where('colaboradores.ativo', 1);
                    }
                    //Busca apenas inativos
                    if (empty($filtro['ativo']) && !empty($filtro['inativo'])) {
                        $query->where('colaboradores.ativo',  0);
                    }
                })
                ->paginate(25);

            } else {
                $listaColaboradores = Colaborador::select('colaboradores.id','colaboradores.nome', 'colaboradores.celular', 'colaboradores.email', 'colaboradores.situacao', 'cargos.nome as cargo', 'cdcs.cdc')
                ->join('cargos', 'cargos.id', '=', 'colaboradores.id_cargo')
                ->join('cdcs', 'cdcs.id', '=', 'colaboradores.id_cdc')
                ->orderBy('colaboradores.created_at')->paginate(25);
            }
        } else {
            if ($usar_filtro) {
                $listaColaboradores = Colaborador::select('colaboradores.id','colaboradores.nome', 'colaboradores.celular', 'colaboradores.email', 'colaboradores.situacao', 'cargos.nome as cargo', 'cdcs.cdc')
                ->join('cargos', 'cargos.id', '=', 'colaboradores.id_cargo')
                ->join('cdcs', 'cdcs.id', '=', 'colaboradores.id_cdc')
                ->orderBy('colaboradores.created_at')
                ->where(function ($query) use ($filtro){
                    //Busca pelo nome
                    if(!empty($filtro['nome'])){
                        $query->where('colaboradores.nome', 'like', '%'.$filtro['nome'].'%');
                    }
                    //Busca apenas ativos
                    if(!empty($filtro['ativo']) && empty($filtro['inativo'])){
                        $query->where('colaboradores.ativo', 1);
                    }
                    //Busca apenas inativos
                    if(empty($filtro['ativo']) && !empty($filtro['inativo'])){
                        $query->where('colaboradores.ativo',  0);
                    }
                })
                ->paginate(25);
            } else {
                $listaColaboradores = Colaborador::select('colaboradores.id','colaboradores.nome', 'colaboradores.celular', 'colaboradores.email', 'colaboradores.situacao', 'cargos.nome as cargo', 'cdcs.cdc')
                ->join('cargos', 'cargos.id', '=', 'colaboradores.id_cargo')
                ->join('cdcs', 'cdcs.id', '=', 'colaboradores.id_cdc')
                ->orderBy('colaboradores.created_at')
                ->paginate(25);
            }
        }

        foreach($listaColaboradores as $colaborador){
            $colaborador['situacao'] = (($colaborador['situacao']) ? __('colaborador.ativo') : __('colaborador.inativo'));
        }

        $cargos = Cargo::select('id','nome')->get();
        $cdcs = Cdc::select('id','nome','cdc')->get();

        return view('organizacao.colaborador.gerenciar', compact('listaColaboradores','idiomas','cargos','cdcs'));     
    }

    public function getColaborador($id)
    {
        $colaborador = Colaborador::find($id);

        return $colaborador;
    }

    public function editaColaborador(Request $req)
    {
        $dados = $req->all();

        if(Colaborador::validaEmail($dados['email'], $dados['id'])){
            if( !isset($dados['password']) || empty($dados['password']) ){
                unset($dados['password']);
            }else{
                $dados['password'] = bcrypt($dados['password']);
            }

            Colaborador::find($dados['id'])->update($dados);

            Notificacao::gerarAlert("notificacao.sucesso", "notificacao.edicaoSucesso", "success");
            return redirect()->back();
        }else{
            Notificacao::gerarAlert("notificacao.erro", "notificacao.falhaEmail", "danger");
            return redirect()->back();
        }
    }

    public function removerColaborador($id)
    {       
        Colaborador::find($id)->delete();
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.remocaoSucesso", "success");

        return redirect()->back();
    }

    public function validarEmailColaborador($id_colaborador)
    {
        $usuario = Colaborador::find($id_colaborador);
        if(!empty($usuario)){
            DB::table('colaboradores')
                ->where('id', $id_colaborador)
                ->update(['email_verified_at' => DB::raw('now()'), 'updated_at' => DB::raw('now()')]);
        }
        return redirect()->route('colaborador.listar');
    }
    
    /**
     * métodos usuário_cdc
     */
    public function inserirNovoUsuario(Request $req)
    {
        $dados_user = $req->all();
        $dados_user_cargo = $req->all();
        
        $validacao = User::where('email', $dados_user['email'])->count();
        if($validacao > 0){
            Notificacao::gerarAlert("notificacao.erro", "notificacao.falhaEmail", "danger");
            return redirect()->back();
        }

        /**
         * Prepara matriz e grava o usuário
         */
        unset($dados_user['id_cargo']);
        unset($dados_user['id_cdc']);
        $dados_user['password'] = bcrypt($dados_user['password']);
        
        $user_new = User::create($dados_user);
        $id_user = $user_new['id'];

        /**
         * Prepara matriz e grava o usuário por cargo
         */
        unset($dados_user_cargo['nome']);
        unset($dados_user_cargo['celular']);
        unset($dados_user_cargo['codigo_idioma']);
        unset($dados_user_cargo['email']);
        unset($dados_user_cargo['password']);
        unset($dados_user_cargo['confirmpassword']);
        $dados_user_cargo += ['id_user' => $id_user];
        
        $id_user_cargo = User_Cargo::create($dados_user_cargo);

        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.cadastroSucesso", "success");
        return redirect()->back();
    }

    /**
     * método usuário_cargo
     */
    public function listarUsuarios(Request $req)
    {
        $filtro = $req->all();
        $usar_filtro = (isset($filtro['filtro'])) ? True : False;

        $listaUsuarios = [];
        $idiomas = User::getListaDeIdiomas();
        if ($usar_filtro) {
            $listaUsuarios = User::select('users.id','users.nome', 'users.celular', 'users.email', 'users.situacao', 'cargos.nome as cargo', 'cdcs.cdc')
            ->join('user__cargos', 'user__cargos.id_user', '=', 'users.id')
            ->join('cargos', 'cargos.id', '=', 'user__cargos.id_cargo')
            ->join('cdcs', 'cdcs.id', '=', 'user__cargos.id_cdc')
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
            })
            ->paginate(25);
        } else {
            $listaUsuarios = User::select('users.id','users.nome', 'users.celular', 'users.email', 'users.situacao', 'cargos.nome as cargo', 'cdcs.cdc')
            ->join('user__cargos', 'user__cargos.id_user', '=', 'users.id')
            ->join('cargos', 'cargos.id', '=', 'user__cargos.id_cargo')
            ->join('cdcs', 'cdcs.id', '=', 'user__cargos.id_cdc')
            ->orderBy('users.created_at')
            ->paginate(25);
        }

        foreach($listaUsuarios as $usuario){
            $usuario['situacao'] = (($usuario['situacao']) ? __('colaborador.ativo') : __('colaborador.inativo'));
        }

        $cargos = Cargo::select('id','nome')->get();
        $cdcs = Cdc::select('id','nome','cdc')->get();

        return view('organizacao.colaborador.gerenciar', compact('listaUsuarios','idiomas','cargos','cdcs'));     
    }

    /**
     * método usuário_cargo
     */
    public function getUsuario($id)
    {
        $usuario = User::select('users.*','user__cargos.id_cargo', 'user__cargos.id_cdc')
                        ->join('user__cargos', 'user__cargos.id_user', '=', 'users.id')
                        ->where('users.id', $id)
                        ->first();

        return $usuario;
    }

    /**
     * método usuário_cargo
     */
    public function editaUsuario(Request $req)
    {
        $dados_user = $req->all();
        $dados_user_cargo = $req->all();

        if(User::validaEmail($dados_user['email'], $dados_user['id'])){
            if( !isset($dados_user['password']) || empty($dados_user['password']) ){
                unset($dados_user['password']);
            }else{
                $dados_user['password'] = bcrypt($dados_user['password']);
            }

            /**
             * Prepara matriz e grava o usuário
             */
            unset($dados_user['id_cargo']);
            unset($dados_user['id_cdc']);
            User::find($dados_user['id'])->update($dados_user);

            /**
             * Prepara matriz e grava o usuário por cargo
             */
            unset($dados_user_cargo['nome']);
            unset($dados_user_cargo['celular']);
            unset($dados_user_cargo['codigo_idioma']);
            unset($dados_user_cargo['email']);
            unset($dados_user_cargo['password']);
            unset($dados_user_cargo['confirmpassword']);
            User::where('id_user', '=', $dados_user['id'])->update($dados_user_cargo);

            Notificacao::gerarAlert("notificacao.sucesso", "notificacao.edicaoSucesso", "success");
            return redirect()->back();
        }else{
            Notificacao::gerarAlert("notificacao.erro", "notificacao.falhaEmail", "danger");
            return redirect()->back();
        }
    }

    /**
     * método usuário_cargo
     */
    public function removerUsuario($id)
    {       
        User_Cargo::where('id_user', '=', $id)->delete();
        User::find($id)->delete();

        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.remocaoSucesso", "success");

        return redirect()->back();
    }

}
