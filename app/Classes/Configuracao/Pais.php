<?php

namespace App\Classes\Configuracao;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pais extends Model
{
    use SoftDeletes;

    protected $table = 'paises';

    protected $fillable = [
        'id', 'nome', 'codigo_ddi', 'codigo_iso'
    ];

    protected $dates = ['deleted_at'];
}
