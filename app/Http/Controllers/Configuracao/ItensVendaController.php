<?php

namespace App\Http\Controllers\Configuracao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Constantes\Notificacao;
use App\Classes\Configuracao\ItensVenda;

class ItensVendaController extends Controller
{
    public function listarItensVenda(){
        $itensVenda = ItensVenda::select('id', 'nome', 'tipo', 'unidade')->orderBy('nome')->paginate(25);

        foreach ($itensVenda as $item) {
            $item['tipo'] = ($item['tipo'] == 'Produto') ? __('comum.produto') : __('comum.servico');
        }

        return view('configuracao.itensVenda.gerenciar', compact('itensVenda'));
    }

    public function cadastrarItensVenda(){
        return view('configuracao.itensVenda.cadastrar');
    }

    public function salvarItensVenda(Request $request) {
        $dados = $request->all();
        $nome = ucwords($dados['nome']);
        $tipoItem = $dados['tipo'];
        $unidade = $dados['unidade'];

        if(empty($nome || $tipoItem || $unidade)){
            Notificacao::gerarAlert("notificacao.erro", "notificacao.falhaCadastro", "danger");
            $request->flash();
            return redirect()->route('itensVenda.cadastra');;
        } else { 
            $itemVenda = new ItensVenda();
            $itemVenda->nome = $nome;
            $itemVenda->tipo = $tipoItem;
            $itemVenda->unidade = $unidade;
            $itemVenda->save();

            Notificacao::gerarAlert("notificacao.sucesso", "notificacao.cadastroSucesso", "success");
            return redirect()->route('itensVenda.gerenciar');
        }
    }

    public function editaItensVenda($id) {
        $getInfo = ItensVenda::find($id);
        
        return view('configuracao.itensVenda.editar', compact('getInfo'));
    }

    public function editarItensVenda(Request $request) {
        $dados = $request->all();
        $nome = $dados['nome'];
        $tipoItem = $dados['tipo'];
        $unidade = $dados['unidade'];

        if(empty($nome || $tipoItem || $unidade)){
            Notificacao::gerarAlert("notificacao.erro", "notificacao.falhaCadastro", "danger");
            $request->flash();
            return redirect()->route('itensVenda.cadastra');;
        } else { 
            $itemVenda = array(
                'nome' => $nome,
                'tipo' => $tipoItem,
                'unidade' => $unidade
            );
            ItensVenda::find($dados['id'])->update($itemVenda);
            unset($itemVenda);
            
            Notificacao::gerarAlert("notificacao.sucesso", "notificacao.edicaoSucesso", "success");
            return redirect()->route('itensVenda.gerenciar');
        }
    }

    public function modalExclusaoItemsVenda($id) {
        $getItemVenda = ItensVenda::find($id);
        
        $getItemVenda->tipo = ($getItemVenda->tipo == 'Produto') ? __('comum.produto') : __('comum.servico');

        return $getItemVenda;
    }

    public function excluirItensVenda(Request $request) { 
        $dados = $request->all();

        $itemVenda = ItensVenda::find($dados['id']);
        $itemVenda->delete();

        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.remocaoSucesso", "success");
        return redirect()->back();
    }
}
?>
