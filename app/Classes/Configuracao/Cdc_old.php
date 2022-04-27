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
        //dd($cdc);
        do {
            $cdc = (count($ultimos) == 0) ? $cdc : implode(",",$ultimos); 
            $cdcsFilhos = DB::table('cdcs')->select('cdc')->whereRaw("find_in_set( cdc_pai, '".$cdc."') > 0")->get();
            $ultimos = array();
            foreach ($cdcsFilhos as $item) {
                $filhos[] = $item->cdc;
                $ultimos[] = $item->cdc;
            }            
        } while (count($ultimos) > 0);
        //dd(var_dump($filhos));
        return ((count($filhos) > 0) ? implode(',',$filhos) : 0);
    }
}
