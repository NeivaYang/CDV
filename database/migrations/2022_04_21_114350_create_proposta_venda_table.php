<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropostaVendaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposta_venda', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_oportunidade');
            $table->date('data_proposta');
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
        Schema::dropIfExists('proposta_venda');
    }
}
