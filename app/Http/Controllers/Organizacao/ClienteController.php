<?php

namespace App\Http\Controllers\Organizacao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Organizacao\Cliente;
use App\Classes\Constantes\Notificacao;
use App\Classes\Configuracao\Pais;
use App\Classes\Configuracao\Cdc;
use App\Classes\Organizacao\ClienteCdc;
use App\Classes\Configuracao\Cultura;
use App\Classes\Configuracao\Cidade;
use App\Classes\Configuracao\Estado;
use App\Classes\Validacoes\Validates;
use Session;
use Auth;
use DB;

class ClienteController extends Controller
{
    public function gerenciarCliente()
    {
        //\DB::enableQueryLog(); // Enable query log

        $clientes = Cliente::select('clientes.id', 'clientes.nome', 'clientes.email', 'clientes.telefone', 'paises.nome as pais', 'clientes.tipo_pessoa', 'clientes.documento', 'clientes.situacao', 'clientes.corporacao')
            ->join('paises', 'paises.id', '=', 'clientes.id_pais')
            ->orderBy('clientes.nome')
            ->paginate(25);
        //$clientes = Cidade::select('cidades.id', 'cidades.nome')->orderBy('cidades.nome')->paginate(25);

        // Your Eloquent query executed by using get()
        //dd(\DB::getQueryLog()); // Show results of log

        //dump($clientes);
        // search the son cdcs
        $cdc_user = Session::get('cdc');
        $lista_cdc = Cdc::searchCdcSon($cdc_user);
        array_push($lista_cdc, $cdc_user);

        foreach ($clientes as $cliente) {
            $cliente['situacao'] = (($cliente['situacao']) ? __('cdc.ativo') : __('cdc.inativo'));
            $cliente['tipo_pessoa'] = (($cliente['tipo_pessoa'] == 'fisica') ? __('cliente.pessoa_fisica') : __('cliente.pessoa_juridica') );
            $cliente['corporacao'] = (($cliente['corporacao'] == 0) ? __('comum.nao') : __('comum.sim'));

            //dump($lista_cdc);
            //DB::enableQueryLog();
            if (Auth::user()->admin) {
                $cliente_cdc = ClienteCdc::select('cliente_cdcs.fazenda')
                    ->join('cdcs', 'cdcs.id', '=', 'cliente_cdcs.id_cdc')
                    ->where('cliente_cdcs.id_cliente',$cliente['id'])
                    ->get();                
            } else {
                $cliente_cdc = ClienteCdc::select('cliente_cdcs.fazenda')
                    ->join('cdcs', 'cdcs.id', '=', 'cliente_cdcs.id_cdc')
                    ->where('cliente_cdcs.id_cliente',$cliente['id'])
                    ->whereIn('cdcs.cdc', $lista_cdc)
                    ->get();                
            }           
            
            $fazenda = '';
            if (count($cliente_cdc) > 0) {
                foreach ($cliente_cdc as $item) {
                    $fazenda .= $item['fazenda'].', ';
                }
                $fazenda = substr($fazenda, 0, (strlen($fazenda)-2));
            } else {
                $fazenda = "-";
            }

            $cliente['cdc_regiao'] = $fazenda;
            //dump($fazenda);
        }
        //dd($clientes);
        /**
         * Seleciona os paises
         */
        $paises = Pais::select('id','nome')->get();

        return view('organizacao.cliente.gerenciar', compact('clientes','paises'));
    }

    public function cadastrarCliente()
    {
        /**
         * Seleciona os paises
         */
        $paises = Pais::select('id','nome')->get();

        /**
         * Seleciona os CDCs
         */
        $cdcs = "";
        if (Auth::user()->admin) {
            $cdcs = Cdc::select('id','nome','cdc')->get();    
        } else {
            $cdc_user = Session::get('cdc');
            $cdcFilhos = Session::get('cdcFilhos');
            $cdcFilhos = ($cdcFilhos == 0) ? $cdc_user : $cdcFilhos.','.$cdc_user;
    
            $cdcs = DB::table('cdcs')->select('id','nome','cdc')->whereRaw("find_in_set(cdc, '".$cdcFilhos."') > 0")->get();
        }

        // Selecção de culturas.
        $culturas = Cultura::get();

        return view('organizacao.cliente.cadastrar', compact('paises','cdcs', 'culturas'));
    }

    public function salvarCliente(Request $req) 
    {
        $dados = $req->all();
        $tipoPessoa = $dados['tipo_pessoa'];
        $validaDoc = false;
        $dados['area_total'] = (empty($dados['area_total'])) ? 0 : $dados['area_total'];
        $dados['area_irrigada'] = (empty($dados['area_irrigada'])) ? 0 : $dados['area_irrigada'];

        if ($tipoPessoa == 'juridica') {
            $validaDoc = Validates::validateCNPJ($dados['documento']);
        } else {
            $validaDoc = Validates::validateCPF($dados['documento']);
        }

        if ($validaDoc) {
            // Verificando se o e-mail já existe, caso esteja preenchido.
            if ((Cliente::where('email', $dados['email'])->count() <= 0) || $dados['email'] == ''){

                // Verificando se o CPF/CNPJ exite, caso esteja preenchido.
                if ((Cliente::where('documento', $dados['documento'])->count() <= 0)){

                    $dados['area_total'] = str_replace(',', '.', $dados['area_total']);
                    $dados['area_irrigada'] = str_replace(',', '.', $dados['area_irrigada']);

                    $cliente_cdc = array( 'id_cliente' => 0, 
                                        'id_cdc' => $dados['id_cdc'], 
                                        'area_total' => $dados['area_total'], 
                                        'area_irrigada' => $dados['area_irrigada'], 
                                        'fazenda'  => $dados['fazenda']);

                    $culturas = '';
                    $i = count($dados['cultura']) - 1;
                    foreach($dados['cultura'] as $key => $cultura){
                            if ($key < $i) {
                                $culturas = $culturas . $cultura . ",";
                            } else {
                                $culturas = $culturas . $cultura;
                            }
                    }

                    $cliente_new = Cliente::create($dados);

                    $cliente_cdc['cultura'] = $culturas;
                    $cliente_cdc['aspersor_qtd'] = $dados['aspersor_qtd'];
                    $cliente_cdc['microaspersor_qtd'] = $dados['microaspersor_qtd'];
                    $cliente_cdc['gotejador_qtd'] = $dados['gotejador_qtd'];
                    $cliente_cdc['pivo_central_qtd'] = $dados['pivo_central_qtd'];
                    $cliente_cdc['linear_qtd'] = $dados['linear_qtd'];
                    $cliente_cdc['autopropelido_qtd'] = $dados['autopropelido_qtd'];
                    $cliente_cdc['id_cliente'] = $cliente_new['id'];
                    $cliente_cdc['cidade'] = $dados['cidade'];
                    $cliente_cdc['estado'] = $dados['estado'];
                    $cliente_cdc['latitude'] = $dados['latitude'];
                    $cliente_cdc['longitude'] = $dados['longitude'];
                    $cliente_cdc['id_estado'] = $dados['estado'];
                    $cliente_cdc['id_cidade'] = $dados['cidade'];
                    ClienteCdc::create($cliente_cdc);

                    Notificacao::gerarAlert("notificacao.sucesso", "notificacao.cadastroSucesso", "success");
                
                    return redirect()->route('cliente.gerenciar');
                }else{
                    Notificacao::gerarAlert("notificacao.erro", "cliente.documento_existente", "danger");
                
                    $req->flash();
        
                    return redirect()->route('cliente.cadastrar');
                }
            }else{
                Notificacao::gerarAlert("notificacao.erro", "cliente.email_existente", "danger");
                
                $req->flash();

                return redirect()->route('cliente.cadastrar');
            }
        } else {
            Notificacao::gerarAlert("notificacao.erro", "notificacao.cpfCnpjInvalido", "danger");
            return redirect()->route('cliente.cadastrar');
        }
    }
    
    public function editarCliente($id)
    {
        $cliente = Cliente::find($id);
    
        /**
         * Seleciona os paises
         */
        $paises = Pais::select('id','nome')->get();

        return view('organizacao.cliente.editar', compact('cliente','paises'));
    }

    public function atualizarCliente(Request $req)
    {
        $dados = $req->all();

        $tipoPessoa = $dados['tipo_pessoa'];
        $validaDoc = false;

        if ($tipoPessoa == 'juridica') {
            $validaDoc = Validates::validateCNPJ($dados['documento']);
        } else {
            $validaDoc = Validates::validateCPF($dados['documento']);
        }

        if($validaDoc) {
            Cliente::find($dados['id'])->update($dados);
            Notificacao::gerarAlert("notificacao.sucesso", "notificacao.edicaoSucesso", "success");
        } else {
            Notificacao::gerarAlert("notificacao.erro", "notificacao.cpfCnpjInvalido", "danger");
            return redirect()->route('cliente.editar', $dados['id']);
        }

        return redirect()->route('cliente.gerenciar');
    }

    public function removerCliente($id)
    {
        $cliente = Cliente::find($id);

        return $cliente;
    }

    public function excluiCliente(Request $req)
    {
        $dados = $req->all();
        // Verifica se existe oportunidade ou CDC relacionado a esse cliente.
        if (Cliente::select('clientes.id')
        ->join('oportunidades', 'oportunidades.id_cliente', '=', 'clientes.id')
        ->join('cliente_cdcs', 'cliente_cdcs.id_cliente', '=', 'clientes.id')
        ->where('clientes.id', $dados['id'])
        ->count()){
            Notificacao::gerarAlert("notificacao.erro", "cliente.erro1", "danger");
        }else{
            Cliente::find($dados['id'])->delete();
            Notificacao::gerarAlert("notificacao.sucesso", "notificacao.remocaoSucesso", "success");
        }
        return redirect()->back();
    }
    
    public function gerenciarCdcCliente($id_cliente)
    {
        $cliente = Cliente::find($id_cliente);

        $cliente_cdcs = ClienteCdc::select('cliente_cdcs.id',DB::raw('concat(cdcs.cdc," - ",cdcs.nome) as cdc'),'cliente_cdcs.area_total','cliente_cdcs.area_irrigada','cliente_cdcs.fazenda', 'cliente_cdcs.id_cidade as cidade', 'cliente_cdcs.id_estado as estado', 'cliente_cdcs.latitude', 'cliente_cdcs.longitude', 'cliente_cdcs.cultura')
            ->join('cdcs', 'cdcs.id', '=', 'cliente_cdcs.id_cdc')
            ->where('cliente_cdcs.id_cliente',$id_cliente)            
            ->paginate(25);

        /**
         * Seleciona os CDCs
         */
        $cdcs = "";
        if (Auth::user()->admin) {
            $cdcs = Cdc::select('id','nome','cdc')->get();
            $cdcsLivres = Cdc::select('id','nome','cdc')->get();
        } else {
            $cdc_user = Session::get('cdc');
            $cdcFilhos = Session::get('cdcFilhos');
            $cdcFilhos = ($cdcFilhos == 0) ? $cdc_user : $cdcFilhos.','.$cdc_user;

            /**
             * Verificar se CDC já foi cadastro neste cliente
             */
            $mCdcs = explode(',',$cdcFilhos);
            
            $cdcsLivres = array();
            foreach ($cliente_cdcs as $item) {
                $itemCdc = explode(' - ', $item->cdc);
                
                if (in_array($itemCdc[0], $mCdcs)) {
                    $cdcsLivres[] = $itemCdc[0];
                }
            }
            $cdcFilhos2 = implode(',',$cdcsLivres);

            $cdcs = DB::table('cdcs')->select('id','nome','cdc')->whereRaw("find_in_set(cdc, '".$cdcFilhos."') > 0")->get();
            $cdcsLivres = DB::table('cdcs')->select('id','nome','cdc')->whereRaw("find_in_set(cdc, '".$cdcFilhos2."') > 0")->get();
        }

        foreach ($cliente_cdcs as $item) {
            // Culturas CDC.
            $culturas_cdc_busca = ClienteCdc::select('cliente_cdcs.id', 'cliente_cdcs.cultura')
            ->where('cliente_cdcs.id',$item['id'])
            ->first();
            $culturas_cdc[$item['id']] = explode(",", $culturas_cdc_busca['cultura']);

            // Atribuindo o id a esses campos.
            $item['id_estado'] = $item['estado'];
            $item['id_cidade'] = $item['cidade'];

            // Buscando o nome da cidade e estado.
            $estado = Estado::select('nome')->where('id', $item['id_estado'])->first();
            $cidade = Cidade::select('nome')->where('id', $item['id_cidade'])->first();

            // Mudando essa posição para os nomes.
            $item['estado'] = $estado['nome'];
            $item['cidade'] = $cidade['nome'];
            
            $item['key_not_show'] = ["cultura", "id_cidade", "id_estado"];
        }

        // Buscando o nome da cidade e estado.
        $lista_estados = Estado::get();
        $lista_cidades = Cidade::get();

        // Lista de culturas.
        $culturas = Cultura::get();
        
        return view('organizacao.cliente.gerenciar_cliente_cdc', compact('cliente','cdcs','cdcsLivres','cliente_cdcs', 'culturas', 'culturas_cdc', 'lista_estados', 'lista_cidades'));
    }

    public function cadastrarCdcCliente($id_cliente)
    {
        $cliente = Cliente::find($id_cliente);

        /**
         * Seleciona os CDCs
         */
        $cdcs = "";
        if (Auth::user()->admin) {
            $cdcs = Cdc::select('id','nome','cdc')->get();
        } else {
            $cdc_user = Session::get('cdc');
            $cdcFilhos = Session::get('cdcFilhos');
            $cdcFilhos = ($cdcFilhos == 0) ? $cdc_user : $cdcFilhos.','.$cdc_user;

            /**
             * Verificar se CDC já foi cadastro neste cliente
             */
            $mCdcs = explode(',',$cdcFilhos);
            
            $cdcs = DB::table('cdcs')->select('id','nome','cdc')->whereRaw("find_in_set(cdc, '".$cdcFilhos."') > 0")->get();
        }

        // Buscando o nome da cidade e estado.
        $lista_estados = Estado::get();
        $lista_cidades = Cidade::get();

        // Lista de culturas.
        $culturas = Cultura::get();
        
        return view('organizacao.cliente.cadastrar_cdc_cliente', compact('cliente','cdcs','lista_estados', 'lista_cidades', 'culturas'));
    }

    public function salvarCdcCliente(Request $req) 
    {
        $dados = $req->all();

        $i = count($dados['cultura']) - 1;
        $culturas = '';
        foreach($dados['cultura'] as $key => $cultura){
            if ($key < $i) $culturas = $culturas.$cultura.",";
            else $culturas = $culturas.$cultura;
        }
        $dados['cultura'] = $culturas;

        $dados['id_estado'] = $dados['estado'];
        $dados['id_cidade'] = $dados['cidade'];

        $dados['area_total'] = str_replace(',', '.', $dados['area_total']);
        $dados['area_irrigada'] = str_replace(',', '.', $dados['area_irrigada']);
        
        ClienteCdc::create($dados);

        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.cadastroSucesso", "success");
        
        return redirect()->route('cdc.cliente.gerenciar', $dados['id_cliente']);
    }

    public function editarCdcCliente($id) 
    {
        $clienteCdc = ClienteCdc::find($id);

        $cliente = Cliente::find($clienteCdc['id_cliente']);

        /**
         * Seleciona os CDCs
         */
        $cdcs = "";
        if (Auth::user()->admin) {
            $cdcs = Cdc::select('id','nome','cdc')->get();
        } else {
            $cdc_user = Session::get('cdc');
            $cdcFilhos = Session::get('cdcFilhos');
            $cdcFilhos = ($cdcFilhos == 0) ? $cdc_user : $cdcFilhos.','.$cdc_user;

            /**
             * Verificar se CDC já foi cadastro neste cliente
             */
            $mCdcs = explode(',',$cdcFilhos);
            
            $cdcs = DB::table('cdcs')->select('id','nome','cdc')->whereRaw("find_in_set(cdc, '".$cdcFilhos."') > 0")->get();
        }

        // Buscando o nome da cidade e estado.
        $lista_estados = Estado::get();
        $lista_cidades = Cidade::get();

        $culturas_cdc = explode(',', $clienteCdc['cultura']);

        // Lista de culturas.
        $culturas = Cultura::get();

        return view('organizacao.cliente.editar_cdc_cliente', compact('clienteCdc','cliente','cdcs','lista_estados', 'lista_cidades', 'culturas', 'culturas_cdc'));
    }

    public function atualizarCdcCliente(Request $req)
    {
        $dados = $req->all();

        $i = count($dados['cultura']) - 1;
        $culturas = '';
        foreach($dados['cultura'] as $key => $cultura){
            if ($key < $i) $culturas = $culturas.$cultura.",";
            else $culturas = $culturas.$cultura;
        }
        $dados['cultura'] = $culturas;

        $dados['id_estado'] = $dados['estado'];
        $dados['id_cidade'] = $dados['cidade'];

        $dados['area_total'] = str_replace(',', '.', $dados['area_total']);
        $dados['area_irrigada'] = str_replace(',', '.', $dados['area_irrigada']);

        //ClienteCdc::create($dados);
        ClienteCdc::find($dados['id'])->update($dados);

        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.cadastroSucesso", "success");
        
        return redirect()->route('cdc.cliente.gerenciar', $dados['id_cliente']);
    }

    public function editarClienteCdc($id)
    {
        $clienteCdcEdita = ClienteCdc::find($id);
        
        return $clienteCdcEdita;
    }

    /*
    public function salvarClienteCdc(Request $req)
    {
        $dados = $req->all();

        $i = count($dados['cultura']) - 1;
        $culturas = '';
        foreach($dados['cultura'] as $key => $cultura){
            if ($key < $i) $culturas = $culturas.$cultura.",";
            else $culturas = $culturas.$cultura;
        }
        $dados['cultura'] = $culturas;

        $dados['id_estado'] = $dados['estado'];
        $dados['id_cidade'] = $dados['cidade'];

        $dados['area_total'] = str_replace(',', '.', $dados['area_total']);
        $dados['area_irrigada'] = str_replace(',', '.', $dados['area_irrigada']);

        ClienteCdc::create($dados);
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.cadastroSucesso", "success");
        return redirect()->back();
    }
    */

    public function buscaSelects(Request $req)
    {
        $id = $req->id_cdc_regiao;
        $dados_cliente = ClienteCdc::find($id);
        
        $selects = [];

        if (explode(",", $dados_cliente['cultura'])){
            $selects['culturas'] = explode(",", $dados_cliente['cultura']);
        }
        
        $selects['cidade'] = $dados_cliente['cidade'];
        $selects['estado'] = $dados_cliente['estado'];

        return $selects;
    }

    /*
    public function editaClienteCdc(Request $req)
    {
        $dados = $req->all();

        $culturas = '';
        $i = count($dados['cultura']) - 1;
        foreach($dados['cultura'] as $key => $cultura){
            if ($key < $i) $culturas = $culturas.$cultura.",";
            else $culturas = $culturas.$cultura;
        }

        $dados['cultura'] = $culturas;
        $dados['id_estado'] = $dados['estado'];
        $dados['id_cidade'] = $dados['cidade'];

        ClienteCdc::find($dados['id'])->update($dados);
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.edicaoSucesso", "success");

        return redirect()->back();
    }
    */

    public function buscaCEP(Request $req){
        ////////////////////////////
        // 1 - Estados.
        // 2 - Cidades.
        ////////////////////////////
        
        $id_busca = $req->id_pais;
        $busca   = $req->busca;
        if ($busca == 1){
            // Seleciona os estados.
            $estados = Estado::select('id', 'nome')->where('id_pais', $id_busca)->orderBy('nome')->get();

            // Seleciona as cidades.
            $cidades = Cidade::select('id', 'nome')->where('id_pais', $id_busca)->orderBy('nome')->get();

            $CEP['cidades'] = $cidades;
            $CEP['estados'] = $estados;
        }else{
            // Seleciona as cidades.
            $cidades = Cidade::select('id', 'nome')->where('estado', $id_busca)->orderBy('nome')->get();

            $CEP['cidades'] = $cidades;
        }

        return $CEP;
        
    }
}
