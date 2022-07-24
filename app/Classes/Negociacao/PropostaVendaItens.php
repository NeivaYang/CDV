<?php

namespace App\Classes\Negociacao;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropostaVendaItens extends Model 
{
    protected $table = 'proposta_venda_itens';

    protected $fillable = [
        'id', 'id_item_venda', 'id_proposta_venda', 'sistema_irrigacao', 'unidade', 'quantidade_equipamento', 'quantidade', 'valor_unitario', 'desconto_concedido'
    ];

    protected $dates = ['created_at', 'updated_at'];
}

?>
