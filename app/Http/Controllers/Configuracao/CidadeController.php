<?php

namespace App\Http\Controllers\Configuracao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Configuracao\Cidade;
use App\Classes\Constantes\Notificacao;
use App\Classes\Configuracao\Pais;
use App\Classes\Configuracao\Cdc;
use App\Classes\Mediadores\Fazenda;

class CidadeController extends Controller
{
    public function gerenciarCidade()
    {
        $cidades = Cidade::select('cidades.id', 'cidades.ibge', 'cidades.nome', 'cidades.estado', 'paises.nome as pais', 'cdcs.cdc')
            ->join('paises', 'paises.id', '=', 'cidades.id_pais')
            ->join('cdcs', 'cdcs.id', '=', 'cidades.id_cdc')
            ->orderBy('cidades.nome','asc')
            ->paginate(25);

        $paises = Pais::select('id','nome')->get();
        $cdcs = Cdc::select('id','nome','cdc')->get();

        return view('configuracao.cidade.gerenciar', compact('cidades','paises','cdcs'));
    }

    public function cadastrarCidade(Request $req)
    {
        Cidade::create($req->all());
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.cadastroSucesso", "success");
    
        return redirect()->back();
    }
    
    public function editarCidade($id)
    {
        $cidade = Cidade::find($id);
    
        return $cidade;
    }

    public function editaCidade(Request $req)
    {
        $dados = $req->all();
        Cidade::find($dados['id'])->update($dados);
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.edicaoSucesso", "success");
    
        return redirect()->back();
    }

    public function removerCidade($id)
    {
        Cidade::find($id)->delete();
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.remocaoSucesso", "success");

        return redirect()->back();
    }    
}
