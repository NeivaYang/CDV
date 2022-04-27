<?php

namespace App\Http\Controllers\Configuracao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Configuracao\Servico;
use App\Classes\Constantes\Notificacao;

class ServicoController extends Controller
{
    public function gerenciarServico()
    {
        $servicos = Servico::select('id','nome')->paginate(25);

        return view('configuracao.servico.gerenciar', compact('servicos'));
    }

    public function cadastrarServico(Request $req)
    {
        Servico::create($req->all());
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.cadastroSucesso", "success");

        return redirect()->back();
    }
    
    public function editarServico($id)
    {
        $servico = Servico::find($id);

        return $servico;
    }

    public function editaServico(Request $req)
    {
        $dados = $req->all();
        Servico::find($dados['id'])->update($dados);
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.edicaoSucesso", "success");

        return redirect()->back();
    }

    public function removerServico($id)
    {
        Servico::find($id)->delete();
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.remocaoSucesso", "success");
        
        return redirect()->back();
    }

}
