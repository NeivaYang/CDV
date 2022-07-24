<?php

namespace App\Http\Controllers\Configuracao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Configuracao\Estado;
use App\Classes\Constantes\Notificacao;
use App\Classes\Configuracao\Pais;

class EstadoController extends Controller
{
    public function gerenciarEstado()
    {
        $estados = Estado::select('estados.id', 'estados.nome', 'paises.nome as pais')
            ->join('paises', 'paises.id', '=', 'estados.id_pais')
            ->orderBy('estados.nome','asc')
            ->paginate(25);

            $paises = Pais::select('id','nome')->get();

        return view('configuracao.estado.gerenciar', compact('estados', 'paises'));
    }

    public function cadastrarEstado(Request $req)
    {
        Estado::create($req->all());
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.cadastroSucesso", "success");
    
        return redirect()->back();
    }
    
    public function editarEstado($id)
    {
        $estado = Estado::find($id);
    
        return $estado;
    }

    public function editaEstado(Request $req)
    {
        $dados = $req->all();
        Estado::find($dados['id'])->update($dados);
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.edicaoSucesso", "success");
    
        return redirect()->back();
    }
   
    public function removerEstado($id)
    {
        $estado = Estado::find($id);

        return $estado;
    }

    public function excluiEstado(Request $req)
    {
        $dados = $req->all();

        Estado::find($dados['id'])->delete();
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.remocaoSucesso", "success");
        
        return redirect()->back();
    }
}
