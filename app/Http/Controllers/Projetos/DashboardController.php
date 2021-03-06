<?php

namespace App\Http\Controllers\Projetos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use App\Classes\Constantes\Notificacao;
use App\Classes\Projetos\Afericao\PivoCentral\AfericaoPivoCentral;

class DashboardController extends Controller
{
    public function index(){
        $user = Auth::user()->nome;    
        $pendente = array();
        $pendente = AfericaoPivoCentral::verificarExistenciaAfericoesPendentes(Auth::user()->id);
        return view('sistema.dashboard', compact('user', 'pendente'));
    }

    public function irParaAfericao(Request $req){
        $dados = $req->all();
        $fazenda_sessao = [];
        $fazenda_sessao['nome'] = $dados['nome_fazenda'];
        $fazenda_sessao['id'] = $dados['id_fazenda'];
        session(['fazenda' => $fazenda_sessao]);
        return redirect()->route('status_afericao', $dados['id_afericao']);
    }
}
