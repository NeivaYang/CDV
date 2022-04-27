<?php

namespace App\Http\Controllers\Configuracao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
Use Auth;
Use Session;
Use DB;
use App\Classes\Negociacao\Oportunidade;
use App\Classes\Negociacao\PropostaProduto;
use App\Classes\Negociacao\PropostaServico;
use App\Classes\Negociacao\ContratoVenda;


class DashboardController extends Controller
{
    public function index()
    {
        $oportunidades_data = 0;
        $dashboard_data = 0;

        /*
        $proposta_produto = PropostaProduto::count();
        $proposta_servico = PropostaServico::count();
        $contratos = ContratoVenda::count();
        $negociacao = Negociacao::count();
        $negociacao_encerrado = Negociacao::where('negociacao.situacao','encerrado')->count();
        $negociacao_contratado = Negociacao::where('negociacao.situacao','contratado')->count();
        $negociacao_aberto = Negociacao::where('negociacao.situacao','aberto')->count();

        $totais = ContratoVenda::select(DB::raw('sum(cdv_db.proposta_servico.area_abrangida) as total_area'), 
                                        DB::raw('sum(cdv_db.proposta_servico.valor_final) as total_valor'))
                                    ->join('negociacao','negociacao.id','=','contrato_venda.id_negociacao')
                                    ->join('proposta_servico','proposta_servico.id','=','contrato_venda.id_proposta')
                                    ->where('negociacao.tipo','serviço')
                                    ->get();
        $total_area = 0;
        $total_valor = 0;
        foreach ($totais as $item) {
            $total_area = number_format($item->total_area,0,",","");
            $total_valor = number_format($item->total_valor,2,",",".");
        }

        $media_proposta_negociacao = (($proposta_produto+$proposta_servico) > 0 && $negociacao > 0) ? number_format((($proposta_produto+$proposta_servico)/$negociacao),2,",","") : 0;
        
        $dashboard_data = array ('total_proposta_produto' => $proposta_produto,
                                 'total_proposta_servico' => $proposta_servico,
                                 'total_contrato' => $contratos,
                                 'media_proposta_negociacao' => $media_proposta_negociacao,
                                 'total_area' => $total_area,
                                 'total_valor' => $total_valor);

        $chart_negociacoes[0] = ['Situação','Total'];
        $chart_negociacoes[1] = ['Negociação Aberta',$negociacao_aberto];
        $chart_negociacoes[2] = ['Negociação Contratada',$negociacao_contratado];
        $chart_negociacoes[3] = ['Negociação Encerrada',$negociacao_encerrado];
        $oportunidades_data = json_encode($chart_negociacoes);
        */
       return view('sistema.dashboard', compact('dashboard_data','oportunidades_data'));
    }

    

}
