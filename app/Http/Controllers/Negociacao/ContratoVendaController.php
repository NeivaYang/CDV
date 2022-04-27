<?php

namespace App\Http\Controllers\Negociacao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Negociacao\Proposta;
use App\Classes\Negociacao\PropostaProduto;
use App\Classes\Negociacao\PropostaServico;
use App\Classes\Negociacao\Oportunidade;
use App\Classes\Negociacao\ContratoVenda;
use App\User;
use App\Classes\Configuracao\Produto;
use App\Classes\Configuracao\Servico;
use App\Classes\Organizacao\Cliente;
use App\Classes\Constantes\Notificacao;
use Session;
use Auth;


class ContratoVendaController extends Controller
{
    public function gerenciarContrato()
    {
        $contratos = "";

        if (Auth::user()->admin) {
            $contratos = ContratoVenda::select('contrato_venda.id','contrato_venda.numero','users.nome as colaborador','clientes.nome as cliente','contrato_venda.tipo','contrato_venda.data_inicio','contrato_venda.data_termino')
                            ->join('oportunidades', 'oportunidades.id', '=', 'contrato_venda.id_oportunidade')
                            ->join('users', 'users.id', '=', 'oportunidades.id_user')
                            ->join('clientes', 'clientes.id', '=', 'oportunidades.id_cliente')
                            ->orderBy('contrato_venda.data_inicio')
                                    ->paginate(25);
        } else {
            $cdc_user = Session::get('cdc');
            $cdcFilhos = Session::get('cdcFilhos');
            $cond_user = ($cdcFilhos == 0) ? 'users.id = '.Auth::user()->id : "find_in_set(cdcs.cdc, '".$cdcFilhos."') > 0";

            if ($cdcFilhos == 0) {
                $contratos = ContratoVenda::select('contrato_venda.id','contrato_venda.numero','users.nome as colaborador','clientes.nome as cliente','contrato_venda.tipo','contrato_venda.data_inicio','contrato_venda.data_termino')
                    ->join('oportunidades', 'oportunidades.id', '=', 'contrato_venda.id_oportunidade')
                    ->join('users', 'users.id', '=', 'oportunidades.id_user')
                    ->join('clientes', 'clientes.id', '=', 'oportunidades.id_cliente')
                    ->whereRaw('oportunidades.id_user = '.Auth::user()->id)
                    ->orderBy('contrato_venda.data_inicio')
                    ->paginate(25);
            } else {
                $contratos = ContratoVenda::select('contrato_venda.id','contrato_venda.numero','users.nome as colaborador','clientes.nome as cliente','contrato_venda.tipo','contrato_venda.data_inicio','contrato_venda.data_termino')
                    ->join('oportunidades', 'oportunidades.id', '=', 'contrato_venda.id_oportunidade')
                    ->join('users', 'users.id', '=', 'oportunidades.id_user')
                    ->join('clientes', 'clientes.id', '=', 'oportunidades.id_cliente')
                    ->join('user_funcao_cdc','user_funcao_cdc.id_user','=','users.id')
                    ->join('cdcs','cdcs.id','=','user_funcao_cdc.id_cdc')
                    ->whereRaw("find_in_set(cdcs.cdc, '".$cdcFilhos."') > 0")
                    ->orderBy('contrato_venda.data_inicio')
                    ->paginate(25);
            }            
        }

        foreach ($contratos as $item) {
            $tipo_contrato = ($item['tipo'] == 'produto') ? $item['tipo'] : 'servico'; 
            $item['tipo'] = __('contrato.'.$tipo_contrato);
            $item['data_inicio'] = substr($item['data_inicio'],8,2).'/'.substr($item['data_inicio'],5,2).'/'.substr($item['data_inicio'],0,4);
            $item['data_termino'] = substr($item['data_termino'],8,2).'/'.substr($item['data_termino'],5,2).'/'.substr($item['data_termino'],0,4);
        }
        
        return view('negociacao.contrato.gerenciar', compact('contratos'));
    }

    public function visualizarContrato($id)
    {
        $contrato_venda = ContratoVenda::find($id);

        $oportunidade = Oportunidade::buscaOportunidade($contrato_venda['id_oportunidade']);

        if ($oportunidade['tipo'] == 'servico') {
            $proposta = Proposta::find($contrato_venda['id_proposta']);
            
            $servicos = "";
            $pss = PropostaServico::select('servicos.nome')
                                  ->join('servicos', 'servicos.id', '=', 'proposta_servicos.id_servico')
                                  ->where('id_proposta',$contrato_venda['id_proposta'])->get();
            foreach ($pss as $item) {
                $servicos .= $item->nome.", ";
            }
            $servicos = substr($servicos,0,(strlen($servicos)-2));

            // Sistemas de irrigação
                if ($proposta['sistema_aspersor'] == 1){            
                    $proposta['sistema_irrigacao'] = __('sistemaIrrigacao.aspersor');
                }
                if ($proposta['sistema_autopropelido'] == 1){
                    if (empty($proposta['sistema_irrigacao'])){ $proposta['sistema_irrigacao'] = __('sistemaIrrigacao.autopropelido'); }else{ $proposta['sistema_irrigacao'] = $proposta['sistema_irrigacao'].", ".__('sistemaIrrigacao.autopropelido'); }
                }
                if ($proposta['sistema_gotejador'] == 1){
                    if (empty($proposta['sistema_irrigacao'])){ $proposta['sistema_irrigacao'] = __('sistemaIrrigacao.gotejador'); }else{ $proposta['sistema_irrigacao'] = $proposta['sistema_irrigacao'].", ".__('sistemaIrrigacao.gotejador'); }
                }
                if ($proposta['sistema_linear'] == 1){
                    if (empty($proposta['sistema_irrigacao'])){ $proposta['sistema_irrigacao'] = __('sistemaIrrigacao.linear'); }else{ $proposta['sistema_irrigacao'] = $proposta['sistema_irrigacao'].", ".__('sistemaIrrigacao.linear'); }
                }
                if ($proposta['sistema_microaspersor'] == 1){
                    if (empty($proposta['sistema_irrigacao'])){ $proposta['sistema_irrigacao'] = __('sistemaIrrigacao.microaspersor'); }else{ $proposta['sistema_irrigacao'] = $proposta['sistema_irrigacao'].", ".__('sistemaIrrigacao.microaspersor'); }
                }
                if ($proposta['sistema_pivocentral'] == 1){
                    if (empty($proposta['sistema_irrigacao'])){ $proposta['sistema_irrigacao'] = __('sistemaIrrigacao.pivocentral'); }else{ $proposta['sistema_irrigacao'] = $proposta['sistema_irrigacao'].", ".__('sistemaIrrigacao.pivocentral'); }
                }
            /////////////////////////////

            return view('negociacao.contrato.visualizar_proposta_servico', compact('contrato_venda','oportunidade','proposta','servicos'));
        } elseif ($oportunidade['tipo'] == 'produto') {
            $proposta = Proposta::find($contrato_venda['id_proposta']);

            $produtos = "";
            $pss = PropostaProduto::select('produtos.nome')
                                  ->join('produtos', 'produtos.id', '=', 'proposta_produtos.id_servico')
                                  ->where('id_proposta',$contrato_venda['id_proposta'])->get();
            foreach ($pss as $item) {
                $produtos .= $item->nome.", ";
            }
            $produtos = substr($produtos,0,(strlen($produtos)-2));

            // Sistemas de irrigação
                if ($proposta['sistema_aspersor'] == 1){            
                    $proposta['sistema_irrigacao'] = __('sistemaIrrigacao.aspersor');
                }
                if ($proposta['sistema_autopropelido'] == 1){
                    if (empty($proposta['sistema_irrigacao'])){ $proposta['sistema_irrigacao'] = __('sistemaIrrigacao.autopropelido'); }else{ $proposta['sistema_irrigacao'] = $proposta['sistema_irrigacao'].", ".__('sistemaIrrigacao.autopropelido'); }
                }
                if ($proposta['sistema_gotejador'] == 1){
                    if (empty($proposta['sistema_irrigacao'])){ $proposta['sistema_irrigacao'] = __('sistemaIrrigacao.gotejador'); }else{ $proposta['sistema_irrigacao'] = $proposta['sistema_irrigacao'].", ".__('sistemaIrrigacao.gotejador'); }
                }
                if ($proposta['sistema_linear'] == 1){
                    if (empty($proposta['sistema_irrigacao'])){ $proposta['sistema_irrigacao'] = __('sistemaIrrigacao.linear'); }else{ $proposta['sistema_irrigacao'] = $proposta['sistema_irrigacao'].", ".__('sistemaIrrigacao.linear'); }
                }
                if ($proposta['sistema_microaspersor'] == 1){
                    if (empty($proposta['sistema_irrigacao'])){ $proposta['sistema_irrigacao'] = __('sistemaIrrigacao.microaspersor'); }else{ $proposta['sistema_irrigacao'] = $proposta['sistema_irrigacao'].", ".__('sistemaIrrigacao.microaspersor'); }
                }
                if ($proposta['sistema_pivocentral'] == 1){
                    if (empty($proposta['sistema_irrigacao'])){ $proposta['sistema_irrigacao'] = __('sistemaIrrigacao.pivocentral'); }else{ $proposta['sistema_irrigacao'] = $proposta['sistema_irrigacao'].", ".__('sistemaIrrigacao.pivocentral'); }
                }
            /////////////////////////////

            return view('negociacao.contrato.visualizar_proposta_produto', compact('contrato_venda','oportunidade','proposta','produtos'));
        }
    }
}