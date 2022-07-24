<?php

namespace App\Classes\Negociacao;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropostaProduto extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'id_proposta', 'id_produto'

    ];

    protected $dates = ['deleted_at'];

}
