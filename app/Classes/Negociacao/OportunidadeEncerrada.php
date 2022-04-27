<?php

namespace App\Classes\Negociacao;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OportunidadeEncerrada extends Model
{
    protected $table = 'oportunidades_encerradas';

    protected $fillable = [
        'id', 'id_oportunidade', 'id_motivo', 'tipo', 'id_concorrente', 'data_ocorrido','observacao'
    ];

    protected $dates = ['deleted_at'];
}
