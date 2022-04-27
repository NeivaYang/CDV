<?php

namespace App\Classes\ItensVenda;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItensVenda extends Model 
{
    use SoftDeletes;

    protected $table = 'itens_venda';

    protected $fillable = [
        'id', 'nome', 'tipo', 'unidade'
    ];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];
}

?>
