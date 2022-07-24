<?php

namespace App\Classes\Negociacao;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropostaServico extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'id_proposta', 'id_servico'
    ];

    protected $dates = ['deleted_at'];
}
