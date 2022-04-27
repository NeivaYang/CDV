<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropostaServicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposta_servicos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_proposta');
            $table->unsignedBigInteger('id_servico');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_proposta')->references('id')->on('propostas');
            $table->foreign('id_servico')->references('id')->on('servicos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proposta_servicos');
    }
}
