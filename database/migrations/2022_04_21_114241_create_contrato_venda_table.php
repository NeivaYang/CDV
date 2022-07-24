<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratoVendaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contrato_venda', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('numero',15);
            $table->date('data_inicio');
            $table->date('data_termino')->nullable();
            $table->text('observacao')->nullable();
            $table->string('tipo',7); // (produto/serviço)
            $table->integer('aviso_expiracao'); // ( 15 / 30 / 60 ) dias
            $table->string('assinante_empresa',50);
            $table->string('assinante_cliente',50);
            $table->unsignedBigInteger('id_oportunidade');
            $table->unsignedBigInteger('id_proposta');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_oportunidade')->references('id')->on('oportunidades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contrato_vendas');
    }
}
