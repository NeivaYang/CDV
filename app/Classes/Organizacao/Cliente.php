<?php

namespace App\Classes\Organizacao;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'nome', 'email', 'telefone', 'tipo_pessoa', 'documento', 'id_pais', 'tipo_cliente', 'situacao', 'corporacao'
    ];

    protected $dates = ['deleted_at'];
}
