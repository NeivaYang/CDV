<?php

namespace App\Classes\Configuracao;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estado extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'nome', 'id_pais'
    ];

    protected $dates = ['deleted_at'];
}
