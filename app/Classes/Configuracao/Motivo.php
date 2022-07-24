<?php

namespace App\Classes\Configuracao;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Motivo extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'descricao'
    ];

    protected $dates = ['deleted_at'];
}
