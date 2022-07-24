<?php

namespace App\Http\Controllers\Configuracao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Configuracao\Cdc;
use App\Classes\Constantes\Notificacao;
use App\Classes\Configuracao\Empresa;
use App\Classes\Configuracao\Cidade;

class CdcController extends Controller
{
    public function gerenciarCdc()
    {
        $cdcs = Cdc::select('cdcs.id', 'cdcs.nome', 'cdcs.cdc', 'empresas.nome as empresa', 'cdcs.cdc_pai', 'cdcs.situacao')
            ->join('empresas', 'empresas.id', '=', 'cdcs.id_empresa')
            ->orderBy('cdcs.id_empresa','asc')
            ->orderBy('cdcs.cdc','asc')
            ->paginate(25);

        foreach ($cdcs as $cdc) {
            $cdc['situacao'] = (($cdc['situacao']) ? __('cdc.ativo') : __('cdc.inativo'));
        }

        $empresas = Empresa::select('id','nome')->get();
        $cdcspai = Cdc::select('id','nome','cdc')->get();

        return view('configuracao.cdc.gerenciar', compact('cdcs','empresas','cdcspai'));
    }

    public function cadastrarCdc(Request $req)
    {
        Cdc::create($req->all());
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.cadastroSucesso", "success");
        return redirect()->back();
    }
    
    public function editarCdc($id)
    {
        $cdc = Cdc::find($id);

        return $cdc;
    }

    public function editaCdc(Request $req)
    {
        $dados = $req->all();
        Cdc::find($dados['id'])->update($dados);
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.edicaoSucesso", "success");

        return redirect()->back();
    }

    public function removerCdc($id)
    {
        $cdcpai = Cdc::find($id);
        $validacao1 = Cdc::where('cdc_pai', $cdcpai['cdc'])->count();
        $validacao2 = Cidade::where('id_cdc', $id)->count();
        
        if ($validacao1 > 0) {
            //Notifica
            Notificacao::gerarAlert("notificacao.erro", "cdc.erro1", "danger");
        } else if ($validacao2 > 0) {
            //Notifica
            Notificacao::gerarAlert("notificacao.erro", "cdc.erro2", "danger");
        } else {
            Cdc::find($id)->delete();
            Notificacao::gerarAlert("notificacao.sucesso", "notificacao.remocaoSucesso", "success");
        }

        return redirect()->back();
    }

    public function buscarCdc(Request $request){
        try{            
            $id = $request->id;
            $cdcspai = Cdc::select('id','nome','cdc')->where('id_empresa', $id)->get();
            return $cdcspai;
        }
        catch(\Exception $e){
            echo json_encode($e->getMessage());
        }
    }
}
