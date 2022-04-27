<?php

namespace App\Classes\Configuracao;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Funcao extends Model
{
    use SoftDeletes;

    protected $table = 'funcoes';

    protected $fillable = [
        'id', 'nome', 'id_funcao_pai'
    ];

    protected $dates = ['deleted_at'];

    /**
     * Método que retorna os filhos de uma função separados por vírgula
     * 
     * @var array
     */
    public static function buscaFuncaoFilhos ($id) 
    {
        $filhos = array();
        $ultimos = array();
        //dd($cdc);
        do {
            $id = (count($ultimos) == 0) ? $id : implode(",",$ultimos); 
            $idFilhos = DB::table('funcoes')->select('id')->whereRaw("find_in_set( id_funcao_pai, '".$id."') > 0")->get();
            $ultimos = array();
            foreach ($idFilhos as $item) {
                $filhos[] = $item->id;
                $ultimos[] = $item->id;
            }            
        } while (count($ultimos) > 0);
        //dd(var_dump($filhos));
        return ((count($filhos) > 0) ? implode(',',$filhos) : 0);
    }

}
