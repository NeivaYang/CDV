<?php

namespace App\Http\Controllers\Negociacao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Negociacao\Proposta;
use App\Classes\Negociacao\Oportunidade;
use App\Classes\Constantes\Notificacao;


class PropostaController extends Controller
{
    public function gerenciarProposta($id_oportunidade)
    {
        $oportunidade = Oportunidade::find($id_oportunidade);
        
        if ($oportunidade['estagio'] == '2') {
            if ($oportunidade['tipo'] == "produto") {
                return redirect()->route('proposta.produto.gerenciar', $id_oportunidade);
            } elseif ($oportunidade['tipo'] == "servico") {
                return redirect()->route('proposta.servico.gerenciar', $id_oportunidade);
            }    
        } else {
            Notificacao::gerarAlert("notificacao.erro", "oportunidade.erro3", "danger");
            return redirect()->route('oportunidade.gerenciar');
        }        
    }
}
