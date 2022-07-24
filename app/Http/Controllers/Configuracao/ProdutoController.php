<?php

namespace App\Http\Controllers\Configuracao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Configuracao\Produto;
use App\Classes\Constantes\Notificacao;

class ProdutoController extends Controller
{
    public function gerenciarProduto()
    {
        $produtos = Produto::select('id','nome')->paginate(25);

        return view('configuracao.produto.gerenciar', compact('produtos'));
    }

    public function cadastrarProduto(Request $req)
    {
        Produto::create($req->all());
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.cadastroSucesso", "success");

        return redirect()->back();
    }
    
    public function editarProduto($id)
    {
        $produto = Produto::find($id);

        return $produto;
    }

    public function editaProduto(Request $req)
    {
        $dados = $req->all();
        Produto::find($dados['id'])->update($dados);
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.edicaoSucesso", "success");

        return redirect()->back();
    }

    public function removerProduto($id)
    {
        $produto = Produto::find($id);

        return $produto;
    }

    public function excluiProduto(Request $req)
    {
        $dados = $req->all();

        Produto::find($dados['id'])->delete();
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.remocaoSucesso", "success");
        
        return redirect()->back();
    }

}
