<?php

namespace App\Http\Controllers\Negociacao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Negociacao\Proposta;
use App\Classes\Negociacao\PropostaServico;
use App\Classes\Negociacao\Oportunidade;
use App\Classes\Negociacao\ContratoVenda;
use App\User;
use App\Classes\Configuracao\Servico;
use App\Classes\Organizacao\Cliente;
use App\Classes\Constantes\Notificacao;
use DateTime;
use DateTimeZone;
use DB;
use PDF;


class PropostaServicoController extends Controller
{
    public function gerenciarPropostaServico($id_oportunidade)
    {        
        $propostas = Proposta::select('propostas.id','propostas.data_proposta',
            'propostas.quantidade_equipamento','propostas.area_abrangida','propostas.valor_area',
            'propostas.valor_total','propostas.desconto_concedido','propostas.valor_final','propostas.descricao','propostas.id_oportunidade as servicos',
            'propostas.sistema_aspersor', 'propostas.sistema_autopropelido', 'propostas.sistema_gotejador', 'propostas.sistema_linear', 'propostas.sistema_microaspersor', 'propostas.sistema_pivocentral')
            ->orderBy('propostas.data_proposta')
            ->where('propostas.id_oportunidade', $id_oportunidade)
            ->whereNull('propostas.deleted_at')
            ->get();

        /**
         * Seleciona os serviços
         */
        $servicos = Servico::select('id','nome')->get();

        foreach ($propostas as $proposta) {
            $conteudo = "";
            $pss = PropostaServico::select('servicos.nome')
                                            ->join('servicos', 'servicos.id', '=', 'proposta_servicos.id_servico')
                                            ->where('id_proposta',$proposta->id)->get();
            foreach ($pss as $item) {
                $conteudo .= $item->nome.", ";
            }
            $proposta->servicos = substr($conteudo,0,(strlen($conteudo)-2));
            $proposta->data_proposta = \Carbon\Carbon::parse($proposta->data_proposta)->format('d/m/Y');
            
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
        }
        
        /**
         * busca os dados da oportunidade desta proposta
         */
        $oportunidade = Oportunidade::buscaOportunidade($id_oportunidade);

        return view('negociacao.proposta_servico.gerenciar', compact('propostas','servicos','oportunidade','id_oportunidade'));
    }

    public function cadastrarPropostaServico($id_oportunidade)
    {
        /**
         * busca os dados da oportunidade desta proposta
         */
        $oportunidade = Oportunidade::buscaOportunidade($id_oportunidade);

        /**
         * Seleciona os serviços
         */
        $servicos = Servico::select('id','nome')->get();

        /**
         * Busca a lista de sistemas de irrigação
         */
        $sistemas_irrigacao = Proposta::getListaDeSistemaIrrigacao();

        return view('negociacao.proposta_servico.cadastrar', compact('oportunidade','servicos','sistemas_irrigacao'));
    }

    public function salvarPropostaServico(Request $req)
    {
        $dados = $req->all();
        foreach($dados['sistema_irrigacao'] as $sistema){
            if ($sistema == 'pivo central'){
                $dados['sistema_pivocentral'] = 1;
            }else{
                $dados['sistema_'.$sistema] = 1;
            }            
        }

        $dados['valor_area'] = str_replace(",",".",str_replace(".","",$dados['valor_area']));
        $dados['desconto_concedido'] = str_replace(",",".",str_replace(".","",$dados['desconto_concedido']));

        /**
         * Calculando o valor total e valor final, pois este não entraram na matriz
         * por estarem disabled.
         */
        $valor_total = 0;
        $valor_final = 0;
        if (($dados['area_abrangida'] > 0) && ($dados['valor_area'] > 0)) {
            $valor_total = $dados['area_abrangida'] * $dados['valor_area'];
        }
        if ($dados['desconto_concedido'] > 0) {
            $valor_final = ($valor_total > 0) ? (((100 - $dados['desconto_concedido'])/100) * $valor_total) : 0;
        } else {
            $dados['desconto_concedido'] = 0;
            $valor_final = $valor_total;
        }
        $dados += ['valor_total' => $valor_total];
        $dados += ['valor_final' => $valor_final];

        $id_oportunidade = $dados['id_oportunidade'];
        $servicos = $dados['id_servico'];

        unset($dados['id_servico']);

        $proposta_new = Proposta::create($dados);

        /**
         * Salva o relacionamento proposta serviço
         */
        foreach ($servicos as $id_servico) {
            $dados1 = array('id_proposta' => $proposta_new['id'], 'id_servico' => $id_servico);
            $proposta_servico_new = PropostaServico::create($dados1);
        }

        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.cadastroSucesso", "success");

        return redirect()->route('proposta.gerenciar', $id_oportunidade);
    }

    public function duplicarPropostaServico($id)
    {
        /**
         * Busca os dados da proposta a duplicar 
         */
        $proposta = Proposta::find($id);
        $proposta['valor_area'] = number_format($proposta['valor_area'],2,",","");
        $proposta['valor_total'] = number_format($proposta['valor_total'],2,",","");
        $proposta['desconto_concedido'] = number_format($proposta['desconto_concedido'],2,",","");
        $proposta['valor_final'] = number_format($proposta['valor_final'],2,",","");
        
        /**
         * Busca serviço(s) relacionado(s) a esta proposta
         */
        $proposta_servico = array();
        $pss = PropostaServico::select('id_servico')->where('id_proposta',$id)->get();
        foreach ($pss as $item) {
            $proposta_servico[] = $item['id_servico'];
        }
        
        /**
         * busca os dados da oportunidade desta proposta
         */
        $oportunidade = Oportunidade::buscaOportunidade($proposta['id_oportunidade']);

        /**
         * Seleciona os serviços
         */
        $servicos = Servico::select('id','nome')->get();

        /**
         * Busca a lista de sistemas de irrigação
         */
        $sistemas_irrigacao = Proposta::getListaDeSistemaIrrigacao();

        // Sistemas de irrigação
        $proposta['sistema_irrigacao'] = Proposta::buscaSistemaIrrigacao($id);
        
        return view('negociacao.proposta_servico.duplicar', compact('proposta','proposta_servico','oportunidade','servicos','sistemas_irrigacao'));
    }

    public function gerarContratoServico($id)
    {
        /**
         * busca os dados da proposta a duplicar 
         */
        $proposta = Proposta::find($id);
        $proposta['valor_area'] = number_format($proposta['valor_area'],2,",","");
        $proposta['valor_total'] = number_format($proposta['valor_total'],2,",","");
        $proposta['desconto_concedido'] = number_format($proposta['desconto_concedido'],2,",","");
        $proposta['valor_final'] = number_format($proposta['valor_final'],2,",","");

        /**
         * Busca serviço(s) relacionado(s) a esta proposta
         */
        $proposta_servico = array();
        $pss = PropostaServico::select('id_servico')->where('id_proposta',$id)->get();
        foreach ($pss as $item) {
            $proposta_servico[] = $item['id_servico'];
        }

        /**
         * busca os dados da oportunidade desta proposta
         */
        $oportunidade = Oportunidade::buscaOportunidade($proposta['id_oportunidade']);

        /**
         * Seleciona os serviços
         */
        $servicos = Servico::select('id','nome')->get();

        /**
         * Seleciona os colaboradores
         */
        $colaboradores = User::select('users.id','users.nome','funcoes.nome as funcao')
                                ->join('user_funcao_cdc','user_funcao_cdc.id_user','=','users.id')
                                ->join('funcoes','funcoes.id','=','user_funcao_cdc.id_funcao')
                                ->where('users.admin','0')
                                ->orderBy('users.nome')
                                ->get();

        /**
         * Seleciona os cliente
         */
        $clientes = Cliente::select('id','nome')
                            ->orderBy('clientes.nome')
                            ->get();
        
        /**
         * Busca a lista de sistemas de irrigação
         */
        $sistemas_irrigacao = Proposta::getListaDeSistemaIrrigacao();

        // Sistemas de irrigação
        $proposta['sistema_irrigacao'] = Proposta::buscaSistemaIrrigacao($id);

        return view('negociacao.proposta_servico.gerar_contrato', compact('proposta','proposta_servico','oportunidade','servicos','sistemas_irrigacao','colaboradores','clientes'));
    }

    public function gerarPDFproposta($id_proposta) {
        $propostas = Proposta::select('propostas.id', 'propostas.id_oportunidade', 'propostas.data_proposta','propostas.sistema_irrigacao', 'propostas.area_manejada', 'propostas.quantidade_equipamento',
        'propostas.quantidade_lance', 'propostas.area_abrangida','propostas.valor_area', 'propostas.valor_total','propostas.desconto_concedido','propostas.valor_final',
        'propostas.descricao')
            ->where('propostas.id', $id_proposta)
            ->orderBy('propostas.data_proposta')
            ->get();

            $servicos = Servico::select('id','nome')->get();

            foreach ($propostas as $proposta) {
                $conteudo = "";
                $pss = PropostaServico::select('servicos.nome')
                                                ->join('servicos', 'servicos.id', '=', 'proposta_servicos.id_servico')
                                                ->where('id_proposta',$proposta->id)->get();
                foreach ($pss as $item) {
                    $conteudo .= $item->nome.", ";
                }
                $proposta->servicos = substr($conteudo,0,(strlen($conteudo)-2));
                $proposta->data_proposta = \Carbon\Carbon::parse($proposta->data_proposta)->format('d/m/Y');
            }

        $oportunidade = Oportunidade::buscaOportunidade($id_proposta);
        $servicos = Servico::select('id','nome')->get();
        $sistemas_irrigacao = Proposta::getListaDeSistemaIrrigacao();

        $pdf = PDF::loadView('negociacao.proposta_servico.gerarPDFoportunidade', compact('propostas','servicos','oportunidade','id_proposta', 'sistemas_irrigacao'));
        return $pdf->setPaper('A4')->setOptions(['defaultFont' => 'roboto', 'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->stream('propostaServico.pdf');
    }

    public function salvarContratoServico(Request $req)
    {
        $dados = $req->all();

        /**
         * Registra na oportunidade que ela foi efetivada
         */
        $date = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
        $data_atual = $date->format('Y-m-d');  
        Oportunidade::where('id', $dados['id_oportunidade'])->update(['estagio' => 4, 'data_fechado_positivo' => $data_atual]);

        $contrato_servico_new = ContratoVenda::create($dados);

        return redirect()->route('oportunidade.gerenciar');
    }
}
