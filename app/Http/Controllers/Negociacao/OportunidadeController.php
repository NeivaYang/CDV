<?php

namespace App\Http\Controllers\Negociacao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Negociacao\Oportunidade;
use App\Classes\Negociacao\OportunidadeEncerrada;
use App\User;
use App\UserFuncaoCdc;
use App\Classes\Organizacao\Cliente;
use App\Classes\Organizacao\ClienteCdc;
use App\Classes\Configuracao\Cdc;
use App\Classes\Configuracao\Motivo;
use App\Classes\Configuracao\Concorrente;
use App\Classes\Constantes\Notificacao;
use Session;
use Auth;
use DateTime;
use DateTimeZone;

class OportunidadeController extends Controller
{
    public function gerenciarOportunidade() 
    {
        $oportunidades = "";

        if (Auth::user()->admin) {
            $oportunidades = Oportunidade::select('oportunidades.id','oportunidades.codigo','users.nome as colaborador','clientes.nome as cliente','oportunidades.data_inicio',
                                                'oportunidades.tipo','oportunidades.estagio')
                                        ->join('users', 'users.id', '=', 'oportunidades.id_user')
                                        ->join('clientes', 'clientes.id', '=', 'oportunidades.id_cliente')
                                        ->orderBy('oportunidades.data_inicio')
                                        ->paginate(25);
            $titulos_tabela = array (__('oportunidade.id'),__('oportunidade.codigo'),__('oportunidade.colaborador'),
                                     __('oportunidade.cliente'),__('oportunidade.data_inicio'),__('oportunidade.tipo'),
                                     __('oportunidade.estagio'));
        } else {
            $cdc_user = Session::get('cdc');
            $cdcFilhos = Session::get('cdcFilhos');
            $cond_user = ($cdcFilhos == 0) ? 'users.id = '.Auth::user()->id : "find_in_set(cdcs.cdc, '".$cdcFilhos."') > 0";

            if ($cdcFilhos == 0) {
                $oportunidades = Oportunidade::select('oportunidades.id','oportunidades.codigo','clientes.nome as cliente','oportunidades.data_inicio',
                                                    'oportunidades.tipo','oportunidades.estagio')
                                            ->join('users', 'users.id', '=', 'oportunidades.id_user')
                                            ->join('clientes', 'clientes.id', '=', 'oportunidades.id_cliente')
                                            ->whereRaw('oportunidades.id_user = '.Auth::user()->id)
                                            ->orderBy('oportunidades.data_inicio')
                                            ->paginate(25);
                $titulos_tabela = array (__('oportunidade.id'),__('oportunidade.codigo'),__('oportunidade.cliente'),
                                         __('oportunidade.data_inicio'),__('oportunidade.tipo'),__('oportunidade.estagio'));
            } else {
                $oportunidades = Oportunidade::select('oportunidades.id','oportunidades.codigo','users.nome as colaborador','clientes.nome as cliente','oportunidades.data_inicio',
                                                    'oportunidades.tipo','oportunidades.estagio')
                                            ->join('users', 'users.id', '=', 'oportunidades.id_user')
                                            ->join('clientes', 'clientes.id', '=', 'oportunidades.id_cliente')
                                            ->join('user_funcao_cdc','user_funcao_cdc.id_user','=','users.id')
                                            ->join('cdcs','cdcs.id','=','user_funcao_cdc.id_cdc')
                                            ->whereRaw("find_in_set(cdcs.cdc, '".$cdcFilhos."') > 0")
                                            ->orderBy('oportunidades.data_inicio')
                                            ->paginate(25);
                $titulos_tabela = array (__('oportunidade.id'),__('oportunidade.codigo'),__('oportunidade.colaborador'),
                                         __('oportunidade.cliente'),__('oportunidade.data_inicio'),__('oportunidade.tipo'),
                                         __('oportunidade.estagio'));
            }            
        }

        //<span class="badge badge-secondary">New</span>

        /**
         * busca lista de estagios
         */
        $estagios = Oportunidade::getListaDeEstagios();
        $badge_cor = array('badge-info','badge-info','badge-primary','badge-warning','badge-success','badge-danger');

        foreach ($oportunidades as $item) {
            $item['tipo'] = __('oportunidade.'.$item['tipo']);
            //$item['estagio'] = '<span class="badge '.$badge_cor[$item['estagio']].'">'.__('oportunidade.'.$estagios[$item['estagio']]['valor']).'</span>';
            $item['estagio'] = __('oportunidade.'.$estagios[$item['estagio']]['valor']);
            $item['data_inicio'] = substr($item['data_inicio'],8,2).'/'.substr($item['data_inicio'],5,2).'/'.substr($item['data_inicio'],0,4);
        }

        return view('negociacao.oportunidade.gerenciar', compact('oportunidades','titulos_tabela'));
    }

    public function CadastrarOportunidade()
    {
        $colaboradores = "";
        $clientes = "";
        $cdcs = "";

        /**
         * Busca lista de moedas
         */
        $moedas = Oportunidade::getListaDeMoedas();

        /**
         * Busca lista de estágio
         */
        $estagios = Oportunidade::getListaDeEstagios();

        if (Auth::user()->admin) {
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
             * Seleciona os CDCs
             */
            $cdcs = ClienteCdc::select('cliente_cdc.id_cliente','cliente_cdc.id_cdc','cdcs.cdc','cdcs.nome','cliente_cdc.area_total','cliente_cdc.area_irrigada')
                              ->join('cdcs', 'cdcs.id', '=', 'cliente_cdc.id_cdc')
                              ->orderBy('cdcs.nome')
                              ->get();
        } else {
            $cdc_user = Session::get('cdc');
            $cdcFilhos = Session::get('cdcFilhos');
            $id_user = ($cdcFilhos == 0) ? Auth::user()->id : 0;
            $cond_user = ($cdcFilhos == 0) ? 'users.id = '.Auth::user()->id : "find_in_set(cdcs.cdc, '".$cdcFilhos."') > 0";
            $cdcFilhos = ($cdcFilhos == 0) ? $cdc_user : $cdcFilhos.','.$cdc_user;

            /**
             * Seleciona os colaboradores que estão relacionados com o usuário que está logado
             */
            $colaboradores = User::select('users.id', 'users.nome','funcoes.nome as funcao')
                                 ->join('user_funcao_cdc','user_funcao_cdc.id_user','=','users.id')
                                 ->join('cdcs','cdcs.id','=','user_funcao_cdc.id_cdc')
                                 ->join('funcoes','funcoes.id','=','user_funcao_cdc.id_funcao')
                                 ->where('users.admin','0')
                                 ->whereRaw($cond_user)
                                 ->orderBy('users.nome')
                                 ->get();

            /**
             * Seleciona os clientes que estão relacionados com o usuário que está logado
             */
            $clientes = ClienteCdc::select('clientes.id','clientes.nome')
                                  ->join('cdcs', 'cdcs.id', '=', 'cliente_cdc.id_cdc')
                                  ->join('clientes','clientes.id','=','cliente_cdc.id_cliente')
                                  ->whereRaw("find_in_set(cdcs.cdc, '".$cdcFilhos."') > 0")
                                  ->distinct()
                                  ->orderBy('clientes.nome')
                                  ->get();

            /**
             * Seleciona os clientes que estão relacionados com o usuário que está logado
             */
            $cdcs = ClienteCdc::select('cliente_cdc.id_cliente','cliente_cdc.id_cdc','cdcs.cdc','cdcs.nome','cliente_cdc.area_total','cliente_cdc.area_irrigada')
                              ->join('cdcs', 'cdcs.id', '=', 'cliente_cdc.id_cdc')
                              ->whereRaw("find_in_set(cdcs.cdc, '".$cdcFilhos."') > 0")
                              ->orderBy('cdcs.nome')
                              ->get();
        }

        return view('negociacao.oportunidade.cadastrar', compact('colaboradores','clientes','cdcs','moedas','estagios'));
    }

    public function salvarOportunidade(Request $req)
    {
        $dados = $req->all();
        //$dados['montante'] = str_replace(",",".",str_replace(".","",$dados['montante']));

        $encontrado = Oportunidade::where('id_cliente', $dados['id_cliente'])
                                  ->where('id_user', $dados['id_user'])
                                  ->where('estagio', '<', '3')
                                  ->count();
        
        if ($encontrado > 0) {
            Notificacao::gerarAlert("notificacao.erro", "oportunidade.erro1", "danger");
            return redirect()->back();
        } else {
            $date = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
            $data_atual = $date->format('Y-m-d');  
            $ano = $date->format('y');;
            $codigo = Oportunidade::getGeraCodigoOportunidade(Session::get('cdc'), Session::get('codigo'), $ano);
            $dados += ['codigo' => $codigo];

            if ($dados['estagio'] <= 2) {
                $dados += ['data_prospecto' => $data_atual];
            }
            if ($dados['estagio'] > 0 && $dados['estagio'] <= 2) {
                $dados += ['data_reuniao' => $data_atual];
            }
            if ($dados['estagio'] == 2) {
                $dados += ['data_negociacao' => $data_atual];
            }
            
            Oportunidade::create($dados);
            Notificacao::gerarAlert("notificacao.sucesso", "notificacao.cadastroSucesso", "success");
    
            return redirect()->route('oportunidade.gerenciar');
        }
    }

    public function editarOportunidade($id)
    {
        $oportunidade = Oportunidade::find($id);

        if ($oportunidade['estagio'] < 2) {
            $colaboradores = "";
            $clientes = "";
            $cdcs = "";

            $oportunidade['montante'] = number_format($oportunidade['montante'],2,",","");

            /**
             * Calculando o período de cada estágio
             */
            $data_atual = new DateTime(now());
            $dias_estagio = [0, 0, 0, 0];
            if ($oportunidade['data_prospecto']) {
                $data_prospecto = new DateTime($oportunidade['data_prospecto']);
                $intervalo = $data_atual->diff($data_prospecto);
                $dias_estagio[0] =  $intervalo->format('%a '.__('oportunidade.dias'));
            }
            if ($oportunidade['data_reuniao']) {
                $data_reuniao = new DateTime($oportunidade['data_reuniao']);
                $intervalo = $data_atual->diff($data_reuniao);
                $dias_estagio[1] =  $intervalo->format('%a '.__('oportunidade.dias'));
            }
            if ($oportunidade['data_negociacao']) {
                $data_negociacao = new DateTime($oportunidade['data_negociacao']);
                $intervalo = $data_atual->diff($data_negociacao);
                $dias_estagio[2] =  $intervalo->format('%a '.__('oportunidade.dias'));
            }
            if ($oportunidade['data_abandono']) {
                $data_abandono = new DateTime($oportunidade['data_abandono']);
                $intervalo = $data_atual->diff($data_abandono);
                $dias_estagio[3] =  $intervalo->format('%a '.__('oportunidade.dias'));
            }

            /**
             * Busca lista de moedas
             */
            $moedas = Oportunidade::getListaDeMoedas();

            /**
             * Busca lista de estágio
             */
            $estagios = Oportunidade::getListaDeEstagios();

            /**
             * Seleciona os colaboradores
             */
            $colaboradores = User::select('users.id','users.nome','funcoes.nome as funcao')
                                ->join('user_funcao_cdc','user_funcao_cdc.id_user','=','users.id')
                                ->join('funcoes','funcoes.id','=','user_funcao_cdc.id_funcao')
                                ->where('users.id',$oportunidade['id_user'])
                                ->get();


            if (Auth::user()->admin) {
                /**
                 * Seleciona os cliente
                 */
                $clientes = Cliente::select('id','nome')
                                ->orderBy('clientes.nome')
                                ->get();

                /**
                 * Seleciona os CDCs
                 */
                $cdcs = ClienteCdc::select('cliente_cdc.id_cliente','cliente_cdc.id_cdc','cdcs.cdc','cdcs.nome','cliente_cdc.area_total','cliente_cdc.area_irrigada')
                                ->join('cdcs', 'cdcs.id', '=', 'cliente_cdc.id_cdc')
                                ->orderBy('cdcs.nome')
                                ->get();
            } else {
                $cdc_user = Session::get('cdc');
                $cdcFilhos = Session::get('cdcFilhos');
                $cdcFilhos = ($cdcFilhos == 0) ? $cdc_user : $cdcFilhos.','.$cdc_user;

                /**
                 * Seleciona os clientes que estão relacionados com o usuário que está logado
                 */
                $clientes = ClienteCdc::select('clientes.id','clientes.nome')
                                    ->join('cdcs', 'cdcs.id', '=', 'cliente_cdc.id_cdc')
                                    ->join('clientes','clientes.id','=','cliente_cdc.id_cliente')
                                    ->whereRaw("find_in_set(cdcs.cdc, '".$cdcFilhos."') > 0")
                                    ->distinct()
                                    ->orderBy('clientes.nome')
                                    ->get();

                /**
                 * Seleciona os clientes que estão relacionados com o usuário que está logado
                 */
                $cdcs = ClienteCdc::select('cliente_cdc.id_cliente','cliente_cdc.id_cdc','cdcs.cdc','cdcs.nome','cliente_cdc.area_total','cliente_cdc.area_irrigada')
                                ->join('cdcs', 'cdcs.id', '=', 'cliente_cdc.id_cdc')
                                ->whereRaw("find_in_set(cdcs.cdc, '".$cdcFilhos."') > 0")
                                ->orderBy('cdcs.nome')
                                ->get();
            }
            
            return view('negociacao.oportunidade.editar', compact('oportunidade','colaboradores','clientes','cdcs','moedas','estagios','dias_estagio'));
        } else {
            Notificacao::gerarAlert("", "oportunidade.erroEdicao", "warning");
            return redirect()->back();
        }
        
    }
 
    public function atualizarOportunidade(Request $req)
    {
        $dados = $req->all();

        if ($dados['estagio'] == 3) {
            /**
             * Realizar o encerramento desta oportunidade
             */

            return redirect()->route('oportunidade.encerrar',$dados['id']);
        } else {
            $dados['montante'] = str_replace(",",".",str_replace(".","",$dados['montante']));

            $oportunidade = Oportunidade::find($dados['id']);

            if ($dados['estagio'] <> $oportunidade['estagio']) {
                $date = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
                $data_atual = $date->format('Y-m-d');  
    
                
                if ($dados['estagio'] > 0 && $dados['estagio'] <= 2) {
                    $dados += ['data_reuniao' => $data_atual];
                } 
                if ($dados['estagio'] == 2) {
                    $dados += ['data_negociacao' => $data_atual];
                } 
            }
    
            Oportunidade::find($dados['id'])->update($dados);
            Notificacao::gerarAlert("notificacao.sucesso", "notificacao.edicaoSucesso", "success");
    
            return redirect()->route('oportunidade.gerenciar',$dados['id']);
        }
    }
    
    public function removerOportunidade($id)
    {
        $oportunidade = Oportunidade::find($id);
        
        if ($oportunidade['estagio'] < 2) {
            $colaboradores = "";
            $clientes = "";
            $cdcs = "";
            
            /**
             * Busca lista de moedas
             */
            $moedas = Oportunidade::getListaDeMoedas();

            /**
             * Busca lista de estágio
             */
            $estagios = Oportunidade::getListaDeEstagios();

            /**
             * Seleciona os colaboradores
             */
            $colaboradores = User::select('users.id','users.nome','funcoes.nome as funcao')
                                ->join('user_funcao_cdc','user_funcao_cdc.id_user','=','users.id')
                                ->join('funcoes','funcoes.id','=','user_funcao_cdc.id_funcao')
                                ->where('users.id',$oportunidade['id_user'])
                                ->get();


            if (Auth::user()->admin) {
                /**
                 * Seleciona os cliente
                 */
                $clientes = Cliente::select('id','nome')
                                ->orderBy('clientes.nome')
                                ->get();

                /**
                 * Seleciona os CDCs
                 */
                $cdcs = ClienteCdc::select('cliente_cdc.id_cliente','cliente_cdc.id_cdc','cdcs.cdc','cdcs.nome','cliente_cdc.area_total','cliente_cdc.area_irrigada')
                                ->join('cdcs', 'cdcs.id', '=', 'cliente_cdc.id_cdc')
                                ->orderBy('cdcs.nome')
                                ->get();
            } else {
                $cdc_user = Session::get('cdc');
                $cdcFilhos = Session::get('cdcFilhos');
                $cdcFilhos = ($cdcFilhos == 0) ? $cdc_user : $cdcFilhos.','.$cdc_user;

                /**
                 * Seleciona os clientes que estão relacionados com o usuário que está logado
                 */
                $clientes = ClienteCdc::select('clientes.id','clientes.nome')
                                    ->join('cdcs', 'cdcs.id', '=', 'cliente_cdc.id_cdc')
                                    ->join('clientes','clientes.id','=','cliente_cdc.id_cliente')
                                    ->whereRaw("find_in_set(cdcs.cdc, '".$cdcFilhos."') > 0")
                                    ->distinct()
                                    ->orderBy('clientes.nome')
                                    ->get();

                /**
                 * Seleciona os clientes que estão relacionados com o usuário que está logado
                 */
                $cdcs = ClienteCdc::select('cliente_cdc.id_cliente','cliente_cdc.id_cdc','cdcs.cdc','cdcs.nome','cliente_cdc.area_total','cliente_cdc.area_irrigada')
                                ->join('cdcs', 'cdcs.id', '=', 'cliente_cdc.id_cdc')
                                ->whereRaw("find_in_set(cdcs.cdc, '".$cdcFilhos."') > 0")
                                ->orderBy('cdcs.nome')
                                ->get();
            }
            
            return view('negociacao.oportunidade.excluir', compact('oportunidade','colaboradores','clientes','cdcs','moedas','estagios'));
        } else {
            Notificacao::gerarAlert("", "oportunidade.erroRemocao", "danger");
            return redirect()->back();
        }
        
    }
 
    public function excluiOportunidade(Request $req)
    {
        $dados = $req->all();

        Oportunidade::find($dados['id'])->delete();
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.remocaoSucesso", "success");
    
        return redirect()->route('oportunidade.gerenciar');
    }        

    public function encerrarOportunidade($id)
    {
        $oportunidade = Oportunidade::find($id);
        
        /**
         * Seleciona os motivos
         */
        $motivos = Motivo::select('id','descricao')->get();

        /**
         * Seleciona os concorrentes
         */
        $concorrentes = Concorrente::select('id','nome')->get();

        $tipo_encerramento = ($oportunidade['estagio'] = 3) ? 'abandono' : 'encerrado';

        return view('negociacao.oportunidade.encerrar', compact('oportunidade','tipo_encerramento','motivos','concorrentes'));
    }

    public function encerraOportunidade(Request $req)
    {
        $dados = $req->all();

        /**
         * Atualiza o estágio e a data do estágio desta oportunidade
         */
        $date = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
        $data_atual = $date->format('Y-m-d');  
        if ($dados['tipo'] == 'abandono') {
            Oportunidade::where('id', $dados['id_oportunidade'])->update(['estagio' => 3, 'data_abandono' => $data_atual]);    
        } else {
            Oportunidade::where('id', $dados['id_oportunidade'])->update(['estagio' => 5, 'data_fechado_negativo' => $data_atual]);    
        }
    
        OportunidadeEncerrada::create($req->all());
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.cadastroSucesso", "success");
        
        return redirect()->route('oportunidade.gerenciar');
    }    


    public function preencheSelecao(Request $req)
    {
        $dados = $req->all();

        $valor = $dados['valor'];
        $dependente = $dados['dependente'];
        $ret = "";

        if ($dependente == 'id_cliente') {
            /**
             * Seleciona os Clientes
             */
            $cdc_user = "";
            $user_cdcs = UserFuncaoCdc::select('cdcs.cdc')
                                    ->join('cdcs','cdcs.id','=','user_funcao_cdc.id_cdc')
                                    ->where('user_funcao_cdc.id_user',$valor)
                                    ->get();
            //$cdc_user = $user_cdcs->get('cdc');
            foreach($user_cdcs as $item){ 
                $cdc_user = $item->cdc;
            }

            $cdcFilhos = Cdc::buscaCdcFilhos($cdc_user);
            $cdcFilhos = ($cdcFilhos == 0) ? $cdc_user : $cdcFilhos.','.$cdc_user;
        
            $clientes = ClienteCdc::select('clientes.id','clientes.nome')
                                ->join('cdcs', 'cdcs.id', '=', 'cliente_cdc.id_cdc')
                                ->join('clientes','clientes.id','=','cliente_cdc.id_cliente')
                                ->whereRaw("find_in_set(cdcs.cdc, '".$cdcFilhos."') > 0 AND isnull(clientes.deleted_at)")
                                ->distinct()
                                ->get();

            $ret = '<option value="">'.__('comum.seleciona_item').'</option>';
            foreach ($clientes as $cliente) {
                $ret .= '<option value="'.$cliente->id.'">'.$cliente->nome.'</option>';
            }
        } else {
            /**
             * Seleciona os CDCs
             */
            $cdcs = "";
            if (Auth::user()->admin) {
                $cdcs = ClienteCdc::select('cliente_cdc.id_cliente','cliente_cdc.id_cdc','cdcs.cdc','cdcs.nome','cliente_cdc.area_total','cliente_cdc.area_irrigada')
                                    ->join('cdcs', 'cdcs.id', '=', 'cliente_cdc.id_cdc')
                                    ->where('cliente_cdc.id_cliente',$valor)
                                    ->get();
            } else {
                $cdc_user = Session::get('cdc');
                $cdcFilhos = Session::get('cdcFilhos');
                $cdcFilhos = ($cdcFilhos == 0) ? $cdc_user : $cdcFilhos.','.$cdc_user;
        
                $cdcs = ClienteCdc::select('cliente_cdc.id_cliente','cliente_cdc.id_cdc','cdcs.cdc','cdcs.nome','cliente_cdc.area_total','cliente_cdc.area_irrigada')
                                    ->join('cdcs', 'cdcs.id', '=', 'cliente_cdc.id_cdc')
                                    ->where('cliente_cdc.id_cliente',$valor)
                                    ->whereRaw("find_in_set(cdcs.cdc, '".$cdcFilhos."') > 0")
                                    ->get();
            }

            foreach ($cdcs as $cdc) {
                $ret .= '<option value="'.$cdc->id_cdc.'">'.$cdc->cdc.' - '.$cdc->nome.' ('.$cdc->area_total.'/'.$cdc->area_irrigada.' )</option>';
            }
        }
        
        echo $ret;
    }

}
