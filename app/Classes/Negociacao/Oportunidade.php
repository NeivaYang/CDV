<?php

namespace App\Classes\Negociacao;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Oportunidade extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'id_user','codigo','estagio','tipo','contrato','contrato_anterior','moeda','data_inicio','id_cliente','id_cdc',
        'montante','data_fechamento','data_entrega','margem_bruta','numero_equipamentos','data_prospecto','data_reuniao',
        'data_negociacao','data_abandono','data_fechado_positivo','data_fechado_negativo'
    ];

    protected $dates = ['deleted_at'];

    public static function getListaDeMoedas(){
        $moedas = [
            ['chave'=>'0','valor'=>'real'],
            ['chave'=>'1','valor'=>'dolar'],
        ];
        return $moedas;
    }

    public static function getListaDeEstagios(){
        $estagios = [
            ['chave'=>'0','valor'=>'prospecto'],
            ['chave'=>'1','valor'=>'reuniao'],
            ['chave'=>'2','valor'=>'negociacao'],
            ['chave'=>'3','valor'=>'abandono'],
            ['chave'=>'4','valor'=>'fechado_positivo'],
            ['chave'=>'5','valor'=>'fechado_negativo'],
        ];
        return $estagios;
    }

    public static function getGeraCodigoOportunidade($cdc, $codigoUser, $ano)
    {
        $sigla = $cdc.$codigoUser.$ano;
        $maior = '0';
        $oportunidade = Oportunidade::whereRaw('substr(codigo, 1, 10) = "'.$sigla.'"')->max('codigo');

        if ($oportunidade) {
            $maior = substr($oportunidade,10,3);
        }
        $codigo = $sigla.(str_pad(($maior+1),3,"0",STR_PAD_LEFT));

        return $codigo;
    }

    public static function buscaOportunidade($id_oportunidade)
    {
        $oportunidade = array();

        $busca = Oportunidade::select('oportunidades.id','users.nome as colaborador','oportunidades.id_cliente','clientes.nome as cliente','oportunidades.data_inicio', 
                                      'oportunidades.contrato','oportunidades.codigo','oportunidades.estagio',
                                      'oportunidades.moeda','oportunidades.tipo')
                             ->join('users', 'users.id', '=', 'oportunidades.id_user')
                             ->join('clientes', 'clientes.id', '=', 'oportunidades.id_cliente')
                             ->where('oportunidades.id',$id_oportunidade)->get();
        foreach($busca as $item){
            $oportunidade = array('id_oportunidade' => $item->id,
                                'colaborador' => $item->colaborador,
                                'id_cliente' => $item->id_cliente,
                                'cliente' => $item->cliente,
                                'data_oportunidade' => \Carbon\Carbon::parse($item->data_inicio)->format('d/m/Y'),
                                'contrato' => $item->contrato,
                                'codigo' => $item->codigo,
                                'estagio' => $item->estagio,
                                'tipo' => $item->tipo,
                                'moeda' => $item->moeda);
        }

        return $oportunidade;
    }
}
