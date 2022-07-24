<?php

namespace App\Http\Controllers\Negociacao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Negociacao\Proposta;
use App\Classes\Negociacao\Oportunidade;
use App\Classes\Constantes\Notificacao;
use App\Classes\Configuracao\ItensVenda;
use App\Classes\Negociacao\PropostaVenda;
use App\Classes\Negociacao\PropostaVendaItens;
use App\Classes\Organizacao\Cliente;
use App\Classes\Negociacao\ContratoVenda;

use DateTime;
use DateTimeZone;
Use DB;
use Carbon\Carbon;
use App\User;


class PropostaGeralController extends Controller
{

    public function gerenciarPropostaGeral($id_oportunidade)
    {
        $oportunidade = Oportunidade::find($id_oportunidade);
        
        if ($oportunidade['estagio'] == '2') {               
            $propostas_busca = PropostaVenda::select('proposta_venda.id as id_venda', 'proposta_venda.id_oportunidade', 'proposta_venda.data_proposta', 'proposta_venda_itens.id as id_venda_itens', 'proposta_venda_itens.id_item_venda', 'proposta_venda_itens.id_proposta_venda', 'proposta_venda_itens.sistema_irrigacao', 'proposta_venda_itens.unidade',
                'proposta_venda_itens.quantidade', 'proposta_venda_itens.quantidade_equipamento', 'proposta_venda_itens.valor_unitario', 'proposta_venda_itens.desconto_concedido')
            ->join('proposta_venda_itens', 'proposta_venda_itens.id_proposta_venda', '=', 'proposta_venda.id')
            ->where('proposta_venda.id_oportunidade', $id_oportunidade)
            ->get();
            
            $propostas = [];
            
            foreach ($propostas_busca as $proposta){            
                // Data.
                $proposta['data_proposta'] = Carbon::createFromFormat('Y-m-d',$proposta['data_proposta'])->format('d/m/Y');

                $valor_total = $proposta["quantidade"] * $proposta["valor_unitario"];
                $valor_desconto = round(($valor_total * ($proposta["desconto_concedido"]/100)),2);
                $valor_final = $valor_total - $valor_desconto;

                $propostas[$proposta['id_proposta_venda']]['id_proposta_venda'] = $proposta['id_proposta_venda'];
                $propostas[$proposta['id_proposta_venda']]['data_proposta']     = $proposta['data_proposta'];
                $propostas[$proposta['id_proposta_venda']]['venda_itens'][$proposta['id_venda_itens']] = [
                    "id_item_venda" => $proposta['id_item_venda'],
                    "sistema_irrigacao" => $proposta["sistema_irrigacao"],
                    "quantidade_equipamento" => $proposta["quantidade_equipamento"],
                    "unidade" => $proposta["unidade"],
                    "quantidade" => $proposta["quantidade"],
                    "valor_unitario" => $proposta["valor_unitario"],
                    "valor_total" => $valor_total,
                    "desconto_concedido" => $proposta["desconto_concedido"],
                    "valor_final" => $valor_final 
                ];
            }

            // Itens de venda.
            $itens_venda = ItensVenda::get();
            
            /**
             * busca os dados da oportunidade desta proposta
             */
            $oportunidade = Oportunidade::buscaOportunidade($id_oportunidade);

            return view('negociacao.proposta_geral.gerenciar', compact('propostas', 'oportunidade', 'id_oportunidade', 'itens_venda'));
        } else {
            Notificacao::gerarAlert("notificacao.erro", "oportunidade.erro3", "danger");
            return redirect()->route('oportunidade.gerenciar');
        }    
    }

    public function cadastrarPropostaGeral($id_oportunidade)
    {
        /**
         * busca os dados da oportunidade desta proposta
         */
        $oportunidade = Oportunidade::buscaOportunidade($id_oportunidade);

        // Itens de venda.
        $itens_venda = ItensVenda::get();

        return view('negociacao.proposta_geral.cadastrar', compact('oportunidade', 'itens_venda'));
    }

    public function salvarPropostaGeral(Request $req)
    {
        $dados = $req->all();

        // Cadastro propostas de venda.
        $proposta_venda['id_oportunidade'] = $dados['id_oportunidade'];
        $proposta_venda['data_proposta'] = $dados['data_proposta'];       
        $id_proposta_venda = PropostaVenda::create($proposta_venda);

        // Cadastro dos itens de vendas.
        $proposta_venda_itens = [];        
        $proposta_venda_itens['id_proposta_venda'] = $id_proposta_venda['id'];

        for ($i=0; $i<count($dados['id_item_venda']); $i++){
            $quantidade_equipamento = null;
            if (!empty($dados['quantidade_equipamento'][$i]) && $dados['quantidade_equipamento'][$i] > 0) {
                $quantidade_equipamento = $dados['quantidade_equipamento'][$i];
            }
            
            $valor_unitario = 0;
            if (!empty($dados['valor_unitario'][$i]) && $dados['valor_unitario'][$i] > 0) {
                $valor_unitario = str_replace(",", ".", str_replace(".", "", $dados['valor_unitario'][$i]));;
            }

            $desconto_concedido = 0;
            if (!empty($dados['desconto_concedido'][$i]) && $dados['desconto_concedido'][$i] > 0) {
                $desconto_concedido = str_replace(",", ".", str_replace(".", "", $dados['desconto_concedido'][$i]));;
            }
            
            $proposta_venda_itens['id_item_venda']      = $dados['id_item_venda'][$i];            
            $proposta_venda_itens['sistema_irrigacao']  = $dados['sistema_irrigacao'][$i];
            $proposta_venda_itens['unidade']            = $dados['unidade'][$i];
            $proposta_venda_itens['quantidade']         = $dados['quantidade'][$i];
            $proposta_venda_itens['quantidade_equipamento'] = $quantidade_equipamento;
            $proposta_venda_itens['valor_unitario']     = $valor_unitario;
            $proposta_venda_itens['desconto_concedido'] = $desconto_concedido;

            PropostaVendaItens::create($proposta_venda_itens);
        }

        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.cadastroSucesso", "success");

        return redirect()->route('proposta.geral.gerenciar', $dados['id_oportunidade']);
    }

    public function duplicarPropostaGeral($id)
    {
        /**
         * Busca os dados da proposta a duplicar 
         */
        $busca_propostas = PropostaVenda::select('proposta_venda.id as id_venda', 'proposta_venda.id_oportunidade', 'proposta_venda.data_proposta', 'proposta_venda_itens.id as id_venda_itens', 'proposta_venda_itens.id_item_venda', 'proposta_venda_itens.id_proposta_venda', 'proposta_venda_itens.sistema_irrigacao', 'proposta_venda_itens.unidade',
                'proposta_venda_itens.quantidade', 'proposta_venda_itens.quantidade_equipamento', 'proposta_venda_itens.valor_unitario', 'proposta_venda_itens.desconto_concedido')
            ->join('proposta_venda_itens', 'proposta_venda_itens.id_proposta_venda', '=', 'proposta_venda.id')
            ->where('proposta_venda.id', $id)
            ->get();
        
        $propostas_itens = [];

        foreach($busca_propostas as $proposta){
            $valor_total = $proposta["quantidade"] * $proposta["valor_unitario"];
            $valor_desconto = round(($valor_total * ($proposta["desconto_concedido"]/100)),2);
            $valor_final = $valor_total - $valor_desconto;

            $propostas_itens['id_venda'] = $proposta->id_venda;
            $propostas_itens['id_oportunidade'] = $proposta->id_oportunidade;
            $propostas_itens['data_proposta'] = $proposta->data_proposta;
            $propostas_itens['venda_itens'][$proposta->id_venda_itens] = [
                "id_item_venda" => $proposta['id_item_venda'],
                "sistema_irrigacao" => $proposta["sistema_irrigacao"],
                "unidade" => $proposta["unidade"],
                "quantidade" => $proposta["quantidade"],
                "quantidade_equipamento" => $proposta["quantidade_equipamento"],
                "valor_unitario" => str_replace(".", ",",$proposta["valor_unitario"]),
                "valor_total" => $valor_total,
                "desconto_concedido" => str_replace(".", ",",$proposta["desconto_concedido"]),
                "valor_final" => $valor_final
            ];            
        }

        /**
         * busca os dados da oportunidade desta proposta
         */
        $oportunidade = Oportunidade::buscaOportunidade($propostas_itens['id_oportunidade']);
        
        // Itens de venda.
        $itens_venda = ItensVenda::get();

        return view('negociacao.proposta_geral.duplicar', compact('propostas_itens', 'oportunidade', 'itens_venda'));
    }

    public function gerarContratoGeral($id)
    {
        /**
         * Busca os dados da proposta  
         */
        $busca_propostas = PropostaVenda::select('proposta_venda.id as id_venda', 'proposta_venda.id_oportunidade', 'proposta_venda.data_proposta', 'proposta_venda_itens.id as id_venda_itens', 'proposta_venda_itens.id_item_venda', 'proposta_venda_itens.id_proposta_venda', 'proposta_venda_itens.sistema_irrigacao', 'proposta_venda_itens.unidade',
                'proposta_venda_itens.quantidade', 'proposta_venda_itens.quantidade_equipamento', 'proposta_venda_itens.valor_unitario', 'proposta_venda_itens.desconto_concedido')
            ->join('proposta_venda_itens', 'proposta_venda_itens.id_proposta_venda', '=', 'proposta_venda.id')
            ->where('proposta_venda.id', $id)
            ->get();
        
        $propostas_itens = [];

        foreach($busca_propostas as $proposta){
            $valor_total = $proposta["quantidade"] * $proposta["valor_unitario"];
            $valor_desconto = round(($valor_total * ($proposta["desconto_concedido"]/100)),2);
            $valor_final = $valor_total - $valor_desconto;

            $propostas_itens['id_venda'] = $proposta->id_venda;
            $propostas_itens['id_oportunidade'] = $proposta->id_oportunidade;
            $propostas_itens['data_proposta'] = $proposta->data_proposta;
            $propostas_itens['venda_itens'][$proposta->id_venda_itens] = [
                "id_item_venda" => $proposta['id_item_venda'],
                "sistema_irrigacao" => $proposta["sistema_irrigacao"],
                "quantidade_equipamento" => $proposta["quantidade_equipamento"],
                "unidade" => $proposta["unidade"],
                "quantidade" => $proposta["quantidade"],
                "valor_unitario" => $proposta["valor_unitario"],
                "valor_total" => $valor_total,
                "desconto_concedido" => $proposta["desconto_concedido"],
                "valor_final" => $valor_final
            ];            
        }
        
        /**
         * busca os dados da oportunidade desta proposta
         */
        $oportunidade = Oportunidade::buscaOportunidade($propostas_itens['id_oportunidade']);
        
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
        //$sistemas_irrigacao = Proposta::getListaDeSistemaIrrigacao();
        
        // Sistemas de irrigação
        //$proposta['sistema_irrigacao'] = Proposta::buscaSistemaIrrigacao($id);
        // Itens de venda.
        $itens_venda = ItensVenda::get();
        
        //return view('negociacao.proposta_geral.gerar_contrato', compact('proposta','propostas_itens','oportunidade','sistemas_irrigacao','colaboradores','clientes', 'itens_venda'));
        return view('negociacao.proposta_geral.gerar_contrato', compact('proposta','propostas_itens','oportunidade','colaboradores','clientes', 'itens_venda'));
    }

    public function salvarContratoGeral(Request $req)
    {
        $dados = $req->all();

        /**
         * Registra na oportunidade que ela foi efetivada
         */
        $date = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
        $data_atual = $date->format('Y-m-d');  
        Oportunidade::where('id', $dados['id_oportunidade'])->update(['estagio' => 4, 'data_fechado_positivo' => $data_atual]);

        $dados['tipo'] = "geral";

        $contrato_servico_new = ContratoVenda::create($dados);

        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.contratoPositivo", "success");

        return redirect()->route('contrato.gerenciar');
    }


}
