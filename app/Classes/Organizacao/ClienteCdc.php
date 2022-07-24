<?php

namespace App\Classes\Organizacao;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClienteCdc extends Model
{
    use SoftDeletes;

    protected $table = 'cliente_cdcs';

    protected $fillable = [
        'id', 'id_cliente', 'id_cdc', 'area_total', 'area_irrigada', 'fazenda', 'cultura', 'aspersor_qtd', 'microaspersor_qtd', 'gotejador_qtd', 'pivo_central_qtd', 'linear_qtd', 'autopropelido_qtd',
        'cidade', 'estado', 'latitude', 'longitude', 'id_estado', 'id_cidade'
    ];

    protected $dates = ['deleted_at'];
}
