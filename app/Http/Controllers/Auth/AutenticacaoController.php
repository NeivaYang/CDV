<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Auth;
use DB;
use Session;
use Illuminate\Validation\Rule;
use App\Classes\Constantes\Notificacao;
use App\Classes\Configuracao\Cdc;


class AutenticacaoController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('sistema.usuarios.login');
    }

    public function entrar(Request $req)
    {
        $dados = $req->all();
        if (isset($dados['rememberPassword'])) {
            $remeber = true;
        } else {
            $remeber = false;
        }
        if (User::verificarUserAtivo($dados['email']) && Auth::attempt([ 'email' => $dados['email'], 'password' => $dados['password'] ],  $remeber)) {
            Session::put('name', Auth::user()->all());

            if (!Auth::user()->admin) {
                $dados_cdc = User::select('cdcs.nome','cdcs.cdc','empresas.nome as empresa','funcoes.nome as funcao','users.codigo')
                                   ->join('user_funcao_cdc','user_funcao_cdc.id_user','=','users.id')
                                   ->join('funcoes','funcoes.id','=','user_funcao_cdc.id_funcao')
                                   ->join('cdcs','cdcs.id','=','user_funcao_cdc.id_cdc')
                                   ->join('empresas','empresas.id','=','cdcs.id_empresa')
                                   ->where('users.id',Auth::user()->id)
                                   ->get();
                foreach($dados_cdc as $item){
                    Session::put('cdc',$item->cdc);
                    Session::put('empresa',$item->empresa);
                    Session::put('funcao',$item->funcao);
                    Session::put('codigo',$item->codigo);
                }

                $cdc_user = Session::get('cdc');
                $cdcFilhos = Cdc::buscaCdcFilhos($cdc_user);
                Session::put('cdcFilhos', $cdcFilhos);

                $user_funcao_cdc = User::select('user_funcao_cdc.id_funcao')
                ->join('user_funcao_cdc','user_funcao_cdc.id_user','=','users.id')
                ->where('users.id',Auth::user()->id)
                ->first();

                Session::put('id_funcao', $user_funcao_cdc['id_funcao']);
            }
            //Alterando o idioma da página
            $idiomas =  User::getListaDeIdiomas();
            $index = Auth::user()->codigo_idioma;
            Session::put('locale',  $idiomas[$index]['valor']);
            //Adicionando a lista de idiomas a sessão
            Session::put('idiomas', $idiomas);

            return redirect()->route('dashboard');
        } else {
            //Notificacao::gerarModal("notificacao.erro", "auth.failed", "danger");
            redirect()->back()->with('error', __('login.dados_invalidos'), 'danger');
            return redirect()->route('login');
        }
    }

    public function sair()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('login');
    }

}
