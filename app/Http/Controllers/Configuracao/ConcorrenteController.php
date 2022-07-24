<?php

namespace App\Http\Controllers\Configuracao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Configuracao\Concorrente;
use App\Classes\Constantes\Notificacao;

class ConcorrenteController extends Controller
{
    public function gerenciarConcorrente()
    {
        $concorrentes = Concorrente::select('id','nome')->paginate(25);
        
        return view('configuracao.concorrente.gerenciar', compact('concorrentes'));
    }

    public function cadastrarConcorrente(Request $req)
    {
        Concorrente::create($req->all());
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.cadastroSucesso", "success");
        
        return redirect()->back();
    }
    
    public function editarConcorrente($id)
    {
        $concorrente = Concorrente::find($id);
        
        return $concorrente;
    }

    public function editaConcorrente(Request $req)
    {
        $dados = $req->all();
        Concorrente::find($dados['id'])->update($dados);
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.edicaoSucesso", "success");
        
        return redirect()->back();
    }

    public function removerConcorrente($id)
    {
        Concorrente::find($id)->delete();
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.remocaoSucesso", "success");
        
        return redirect()->back();
    }    
}
