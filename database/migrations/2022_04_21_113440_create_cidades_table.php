<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cidades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ibge',10)->nullable();
            $table->string('nome',100)->nullable();
            $table->string('estado',100)->nullable();
            $table->unsignedBigInteger('id_pais');
            $table->unsignedBigInteger('id_cdc');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_pais')->references('id')->on('paises');
            $table->foreign('id_cdc')->references('id')->on('cdcs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cidades');
    }
}
