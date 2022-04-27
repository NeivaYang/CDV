<?php

namespace App\Classes\Configuracao;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cidade extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'ibge', 'nome', 'estado', 'id_pais', 'id_cdc'
    ];

    protected $dates = ['deleted_at'];
}
