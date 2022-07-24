<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropostaVendaItensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposta_venda_itens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_proposta_venda');
            $table->unsignedBigInteger('id_item_venda');
            $table->enum('sistema_irrigacao', ['aspersor', 'autopropelido', 'gotejador', 'linear', 'microaspersor', 'pivocentral', 'none']);
            $table->integer('quantidade_equipamento')->default(null)->nullable();
            $table->string('unidade', 10);
            $table->double('quantidade', 12, 4);
            $table->double('valor_unitario', 12, 2);
            $table->double('desconto_concedido', 5, 2)->nullable();            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_proposta_venda')->references('id')->on('proposta_venda');
            $table->foreign('id_item_venda')->references('id')->on('itens_venda');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proposta_venda_itens');
    }
}
