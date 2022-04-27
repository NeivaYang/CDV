<?php

namespace App\Classes\Configuracao;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'nome'
    ];

    protected $dates = ['deleted_at'];
}
