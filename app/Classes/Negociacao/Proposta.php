<?php

namespace App\Classes\Negociacao;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proposta extends Model
{
    protected $fillable = [
        'id','id_oportunidade','tipo','data_proposta', 'area_manejada','quantidade_equipamento','quantidade_lance', 'area_abrangida','valor_area','valor_total', 'desconto_concedido', 'valor_final','descricao',
        'sistema_aspersor', 'sistema_autopropelido', 'sistema_gotejador', 'sistema_linear', 'sistema_microaspersor', 'sistema_pivocentral'
    ];

    protected $dates = ['deleted_at'];

    public static function getListaDeSistemaIrrigacao(){
        $sistemaIrrigacao = [
            ['chave'=>'0','valor'=>'aspersor'],
            ['chave'=>'1','valor'=>'autopropelido'],
            ['chave'=>'2','valor'=>'gotejador'],
            ['chave'=>'4','valor'=>'linear'],
            ['chave'=>'3','valor'=>'microaspersor'],
            ['chave'=>'5','valor'=>'pivo central'],
        ];
        return $sistemaIrrigacao;
    }

    // Busca os sistemas de irrigação cadastrados na proposta.
    public static function buscaSistemaIrrigacao($id_proposta)
    {   
        $proposta = Proposta::find($id_proposta);
        
        $sistema_irrigacao = array();

        if ($proposta['sistema_aspersor'] == 1){
            array_push($sistema_irrigacao, 'aspersor');
        }
        if ($proposta['sistema_autopropelido'] == 1){
            array_push($sistema_irrigacao, 'autopropelido');
        }
        if ($proposta['sistema_gotejador'] == 1){
            array_push($sistema_irrigacao, 'gotejador');
        }
        if ($proposta['sistema_linear'] == 1){
            array_push($sistema_irrigacao, 'linear');
        }
        if ($proposta['sistema_microaspersor'] == 1){
            array_push($sistema_irrigacao, 'microaspersor');
        }
        if ($proposta['sistema_pivocentral'] == 1){
            array_push($sistema_irrigacao, 'pivo central');
        }

        return $sistema_irrigacao;
    }

}
