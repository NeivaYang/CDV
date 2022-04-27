<?php

namespace App\Http\Controllers\Configuracao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Constantes\Notificacao;
use App\Classes\ItensVenda\ItensVenda;

class ItensVendaController extends Controller
{
    public function listarItensVenda(){
        $itensVenda = ItensVenda::select('id', 'nome', 'tipo', 'unidade')->paginate(25);

        foreach ($itensVenda as $item) {__('sistemaIrrigacao.aspersor');
            $item['tipo'] = ($item['tipo'] == 'produto') ? __('comum.produto') : __('comum.servico');
        }

        return view('configuracao.itensVenda.gerenciar', compact('itensVenda'));
    }

    public function cadastraItemVenda(){
        return view('configuracao.itensVenda.cadastrar');
    }

    public function cadastrarItemVenda(Request $request) {
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

    public function getEditInfoItemVenda($id) {
        $getInfo = ItensVenda::find($id);

        return view('configuracao.itensVenda.editar', compact('getInfo'));
    }

    public function editarItemsVenda(Request $request) {
        $dados = $request->all();
        $nome = ucwords($dados['nome']);
        $tipoItem = ucwords($dados['tipo']);
        $unidade = ucwords($dados['unidade']);

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

        return $getItemVenda;
    }

    public function excluirItemsVenda(Request $request) { 
        $dados = $request->all();

        $itemVenda = ItensVenda::find($dados['id']);
        $itemVenda->delete();

        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.remocaoSucesso", "success");
        return redirect()->back();
    }
}
?>
