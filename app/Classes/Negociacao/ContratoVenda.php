<?php

namespace App\Classes\Negociacao;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContratoVenda extends Model
{
    use SoftDeletes;

    protected $table = 'contrato_venda';

    protected $fillable = [
        'id','numero','data_inicio','data_termino','observacao','tipo','aviso_expiracao','assinante_empresa','assinante_cliente','id_oportunidade','id_proposta'
    ];

    protected $dates = ['deleted_at'];

}
