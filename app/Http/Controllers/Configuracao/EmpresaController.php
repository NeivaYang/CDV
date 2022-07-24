<?php

namespace App\Http\Controllers\Configuracao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Configuracao\Empresa;
use App\Classes\Constantes\Notificacao;

class EmpresaController extends Controller
{
    public function gerenciarEmpresa()
    {
        $empresas = Empresa::select('id','nome')->paginate(25);
        
        return view('configuracao.empresa.gerenciar', compact('empresas'));
    }

    public function cadastrarEmpresa(Request $req)
    {
        Empresa::create($req->all());
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.cadastroSucesso", "success");
        
        return redirect()->back();
    }
    
    public function editarEmpresa($id)
    {
        $empresa = Empresa::find($id);
        
        return $empresa;
    }

    public function editaEmpresa(Request $req)
    {
        $dados = $req->all();
        Empresa::find($dados['id'])->update($dados);
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.edicaoSucesso", "success");
        
        return redirect()->back();
    }

    public function removerEmpresa($id)
    {
        $validacao = Cdc::where('id_empresa', $id)->count();
        
        if ($validacao > 0) {
            //Notifica
            Notificacao::gerarAlert("notificacao.erro", "empresa.erro1", "danger");
        } else {
            Empresa::find($id)->delete();
            Notificacao::gerarAlert("notificacao.sucesso", "notificacao.remocaoSucesso", "success");
        }
        
        return redirect()->back();
    }
    
}
