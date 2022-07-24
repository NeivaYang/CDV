<?php

namespace App\Classes\Configuracao;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Cdc extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'cdc', 'nome', 'id_empresa', 'cdc_pai', 'situacao'
    ];

    protected $dates = ['deleted_at'];

    /**
     * Método que retorna os filhos de um cdc separados por vírgula
     * 
     * @var array
     */
    public static function buscaCdcFilhos ($cdc) 
    {
        $filhos = array();
        $ultimos = array();
        do {
            if (count($ultimos) == 0) {
                $cdcs = array($cdc);
            } else {
                $cdcs = $ultimos;
            $ultimos = array();
            }

            $cdcsFilhos = Cdc::select('cdc')->whereIn('cdc_pai', $cdcs)->get();
            foreach ($cdcsFilhos as $item) {
                array_push($filhos, $item['cdc']);
                array_push($ultimos, $item['cdc']);
            }            
        } while (count($ultimos) > 0);

        return ((count($filhos) > 0) ? implode(',',$filhos) : 0);
    }

    public static function searchCdcSon ($cdc) {
        $listCdc = array();
        $ultimos = array();
        do {
            if (count($ultimos) == 0) {
                $cdcs = array($cdc);
            } else {
                $cdcs = $ultimos;
                $ultimos = array();
            }

            $cdcsSon = Cdc::select('cdc')->whereIn('cdc_pai', $cdcs)->get();
            foreach ($cdcsSon as $item) {
                array_push($listCdc, $item['cdc']);
                array_push($ultimos, $item['cdc']);
            }
        } while (count($ultimos) > 0);

        return $listCdc;
    }
}
