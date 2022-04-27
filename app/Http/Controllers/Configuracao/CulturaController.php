<?php

namespace App\Http\Controllers\Configuracao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Configuracao\Cultura;
use App\Classes\Constantes\Notificacao;
use App\Classes\Organizacao\ClienteCdc;

class CulturaController extends Controller
{
    public function gerenciarCultura()
    {
        $culturas = Cultura::select('id','nome')->paginate(25);

        return view('configuracao.cultura.gerenciar', compact('culturas'));
    }

    public function cadastrarCultura(Request $req)
    {
        Cultura::create($req->all());
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.cadastroSucesso", "success");
        return redirect()->back();
    }
    
    public function editarCultura($id)
    {
        $cultura = Cultura::find($id);

        return $cultura;
    }

    public function editaCultura(Request $req)
    {
        $dados = $req->all();
        Cultura::find($dados['id'])->update($dados);
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.edicaoSucesso", "success");

        return redirect()->back();
    }

    public function removerCultura($id)
    {
        $cultura = Cultura::find($id);
        
        return $cultura;
    }
    
    public function excluiCultura(Request $req)
    {
        $dados = $req->all();


        Cultura::find($dados['id'])->delete();
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.remocaoSucesso", "success");
        
        return redirect()->back();
    }
}
