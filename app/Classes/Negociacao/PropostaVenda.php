<?php

namespace App\Classes\Negociacao;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropostaVenda extends Model 
{
    protected $table = 'proposta_venda';

    protected $fillable = [
        'id', 'id_oportunidade', 'data_proposta'
    ];

    protected $dates = ['created_at', 'updated_at'];
}

?>
