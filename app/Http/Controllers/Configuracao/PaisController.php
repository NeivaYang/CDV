<?php

namespace App\Http\Controllers\Configuracao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Configuracao\Pais;
use App\Classes\Constantes\Notificacao;
use App\Classes\Configuracao\Cidade;

class PaisController extends Controller
{
    public function gerenciarPais()
    {
        $paises = Pais::select('id','nome','codigo_ddi','codigo_iso')->paginate(25);

        return view('configuracao.pais.gerenciar', compact('paises'));
    }

    public function cadastrarPais(Request $req)
    {
        Pais::create($req->all());
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.cadastroSucesso", "success");

        return redirect()->back();
    }
    
    public function editarPais($id)
    {
        $pais = Pais::find($id);

        return $pais;
    }

    public function editaPais(Request $req)
    {
        $dados = $req->all();
        Pais::find($dados['id'])->update($dados);
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.edicaoSucesso", "success");

        return redirect()->back();
    }

    public function removerPais($id)
    {
        $validacao1 = Cidade::where('id_pais', $id)->count();
        $validacao2 = Cliente::where('id_pais', $id)->count();
    
        if ($validacao1 > 0) {
            //Notifica
            Notificacao::gerarAlert("notificacao.erro", "pais.erro1", "danger");
        } else if ($validacao2 > 0) {
            //Notifica
            Notificacao::gerarAlert("notificacao.erro", "pais.erro2", "danger");
        } else {
            Pais::find($id)->delete();
            Notificacao::gerarAlert("notificacao.sucesso", "notificacao.remocaoSucesso", "success");
        }
        return redirect()->back();
    }

}
