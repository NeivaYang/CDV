<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOportunidadeEncerradasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oportunidade_encerradas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_oportunidade');
            $table->unsignedBigInteger('id_motivo');
            $table->string('tipo',10); // abandono ou encerrado
            $table->unsignedBigInteger('id_concorrente')->nullable();
            $table->text('observacao')->nullable();
            $table->date('data_ocorrido');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_oportunidade')->references('id')->on('oportunidades');
            $table->foreign('id_motivo')->references('id')->on('motivos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oportunidade_encerradas');
    }
}
