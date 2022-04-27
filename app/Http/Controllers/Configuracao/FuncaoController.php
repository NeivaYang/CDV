<?php

namespace App\Http\Controllers\Configuracao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Configuracao\Funcao;
use App\Classes\Constantes\Notificacao;

class FuncaoController extends Controller
{
    public function gerenciarFuncao()
    {
        $funcoes = Funcao::select('funcoes.id','funcoes.nome','fp.nome as funcao_pai')
                           ->leftJoin('funcoes as fp', 'fp.id', '=', 'funcoes.id_funcao_pai')
                           ->paginate(25);

        $funcoespai = Funcao::select('id','nome')->get();

        return view('configuracao.funcao.gerenciar', compact('funcoes', 'funcoespai'));
    }

    public function cadastrarFuncao(Request $req)
    {
        Funcao::create($req->all());
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.cadastroSucesso", "success");

        return redirect()->back();
    }
    
    public function editarFuncao($id)
    {
        $funcao = Funcao::find($id);
        
        return $funcao;
    }

    public function editaFuncao(Request $req)
    {
        $dados = $req->all();
        Funcao::find($dados['id'])->update($dados);
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.edicaoSucesso", "success");
        
        return redirect()->back();
    }

    public function removerFuncao($id)
    {
        $funcaopai = Funcao::find($id);
        $validacao = Funcao::where('id_funcao_pai', $funcaopai['id'])->count();

        if ($validacao > 0) {
            //Notifica
            Notificacao::gerarAlert("notificacao.erro", "funcao.erro1", "danger");
        } else {
            Funcao::find($id)->delete();
            Notificacao::gerarAlert("notificacao.sucesso", "notificacao.remocaoSucesso", "success");
        }
        
        return redirect()->back();
    }
}
