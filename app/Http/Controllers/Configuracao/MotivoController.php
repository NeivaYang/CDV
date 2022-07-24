<?php

namespace App\Http\Controllers\Configuracao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Configuracao\Motivo;
use App\Classes\Constantes\Notificacao;
use App\Classes\Negociacao\ProspectoEncerrado;

class MotivoController extends Controller
{
    public function gerenciarMotivo()
    {
        $motivos = Motivo::select('id','descricao')->paginate(25);

        return view('configuracao.motivo.gerenciar', compact('motivos'));
    }

    public function cadastrarMotivo(Request $req)
    {
        Motivo::create($req->all());
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.cadastroSucesso", "success");

        return redirect()->back();
    }
    
    public function editarMotivo($id)
    {
        $motivo = Motivo::find($id);

        return $motivo;
    }

    public function editaMotivo(Request $req)
    {
        $dados = $req->all();
        Motivo::find($dados['id'])->update($dados);
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.edicaoSucesso", "success");

        return redirect()->back();
    }

    public function removerMotivo($id)
    {
        $validacao = ProspectoEncerrado::where('id_movito', $id)->count();
    
        if ($validacao > 0) {
            //Notifica
            Notificacao::gerarAlert("notificacao.erro", "movito.erro1", "danger");
        } else {        
            Motivo::find($id)->delete();
            Notificacao::gerarAlert("notificacao.sucesso", "notificacao.remocaoSucesso", "success");
        }
        
        return redirect()->back();
    }

}
