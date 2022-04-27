<?php

namespace App\Http\Controllers\Negociacao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Negociacao\Proposta;
use App\Classes\Negociacao\PropostaServico;
use App\Classes\Negociacao\Oportunidade;
use App\Classes\Negociacao\ContratoVenda;
use App\User;
use App\Classes\Configuracao\Produto;
use App\Classes\Organizacao\Cliente;
use App\Classes\Constantes\Notificacao;
use DateTime;
use DateTimeZone;

class PropostaProdutoController extends Controller
{
    public function gerenciarPropostaProduto($id_oportunidade)
    {
        // Seleciona as propostas.
        $propostas = Proposta::select('propostas.id','propostas.data_proposta','propostas.tipo','propostas.area_manejada',
            'propostas.quantidade_equipamento','propostas.quantidade_lance','propostas.area_abrangida',
            'propostas.valor_total','propostas.desconto_concedido','propostas.valor_final','propostas.id_oportunidade as produtos')
            ->orderBy('propostas.data_proposta')
            ->where('propostas.id_oportunidade', $id_oportunidade)
            ->paginate(25);

        /**
         * Seleciona os produtos
         */
        $produtos = Produto::select('id','nome')->get();

        $conteudo = "";
        foreach ($propostas as $proposta) {
            $pss = ProspostaProduto::select('produtos.nome')
                                            ->join('produtos', 'produtos.id', '=', 'proposta_produtos.id_servico')
                                            ->where('id_proposta',$proposta->id)->get();
            foreach ($pss as $item) {
                $conteudo .= $item->nome.", ";
            }
            $proposta->produtos = substr($conteudo,0,(strlen($conteudo)-2));
        }
        
        /**
         * busca os dados da oportunidade desta proposta
         */
        $oportunidade = Oportunidade::buscaOportunidade($id_oportunidade);

        foreach ($propostas as $proposta) {
            if ($proposta['tipo'] == 'padrao') {
                $proposta['tipo'] = __('proposta.padrao');
            } elseif ($proposta['tipo'] == 'manejo') {
                $proposta['tipo'] = __('proposta.manejo');
            } elseif ($proposta['tipo'] == 'leasing') {
                $proposta['tipo'] = __('proposta.leasing');
            }
        }

        return view('negociacao.proposta_produto.gerenciar', compact('propostas','produtos', 'oportunidade', 'id_oportunidade'));
    }

    public function cadastrarPropostaProduto($id_oportunidade)
    {
        /**
         * busca os dados da oportunidade desta proposta
         */
        $oportunidade = Oportunidade::buscaOportunidade($id_oportunidade);

        /**
         * Seleciona os produtos
         */
        $produtos = Produto::select('id','nome')->get();

        return view('negociacao.proposta_produto.cadastrar', compact('oportunidade','produtos'));
    }

    public function salvarPropostaProduto(Request $req)
    {
        $dados = $req->all();
        
        $id_oportunidade = $dados['id_oportunidade'];
        $produtos = $dados['id_produto'];

        unset($dados['id_produto']);
        
        $proposta_new = Proposta::create($dados);

        /**
         * Salva o relacionamento proposta produto
         */
        foreach ($produtos as $id_produto) {
            $dados1 = array('id_proposta' => $proposta_new['id'], 'id_produto' => $id_produto);
            $proposta_produto_new = ProspostaProduto::create($dados1);
        }
        
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.cadastroSucesso", "success");
    
        return redirect()->route('proposta.gerenciar', $id_oportunidade);
    }

    public function duplicarPropostaProduto($id)
    {
        /**
         * Busca os dados da proposta a duplicar 
         */
        $proposta = Proposta::find($id);

        /**
         * Busca produto(s) relacionado(s) a esta proposta
         */
        $proposta_produto = array();
        $pss = ProspostaProduto::select('id_produto')->where('id_proposta',$id)->get();
        foreach ($pss as $item) {
            $proposta_produto = array('id_produto' => $item['id_produto']);
        }

        /**
         * busca os dados da oportunidade desta proposta
         */
        $oportunidade = Oportunidade::buscaOportunidade($proposta['id_oportunidade']);

        /**
         * Seleciona os produtos
         */
        $produtos = Produto::select('id','nome')->get();

        return view('negociacao.proposta_produto.duplicar', compact('proposta','proposta_produto','oportunidade','produtos'));
    }

    public function gerarContratoProduto($id)
    {
        /**
         * busca os dados da proposta a duplicar 
         */
        $proposta = Prosposta::find($id);

        /**
         * Busca Produto(s) relacionado(s) a esta proposta
         */
        $proposta_produto = array();
        $pss = ProspostaProduto::select('id_produto')->where('id_proposta',$id)->get();
        foreach ($pss as $item) {
            $proposta_produto = array('id_produto' => $item['id_produto']);
        }

        /**
         * busca os dados da oportunidade desta proposta
         */
        $oportunidade = Oportunidade::buscaOportunidade($proposta['id_oportunidade']);

        /**
         * Seleciona os produtos
         */
        $produtos = Produto::select('id','nome')->get();

        return view('negociacao.proposta_produto.gerar_contrato', compact('proposta', 'proposta_produto', 'oportunidade', 'produtos'));
    }

    public function salvarContratoProduto(Request $req)
    {
        $dados = $req->all();

        /**
         * Registra na oportunidade que ela foi efetivada
         */
        Oportunidade::where('id', $dados['id_oportunidade'])->update(['estagio' => '4']);

        $contrato_servico_new = ContratoVenda::create($dados);

        return redirect()->route('oportunidade.gerenciar');
    }
}
