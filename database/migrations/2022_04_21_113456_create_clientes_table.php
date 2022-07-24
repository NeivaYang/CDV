<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome',50);
            $table->string('email')->nullable();
            $table->string('telefone',15)->nullable();
            $table->string('tipo_pessoa',8);
            $table->string('documento',20)->nullable();
            $table->unsignedBigInteger('id_pais');
            $table->string('tipo_cliente',10)->default('novo');
            $table->integer('situacao')->default(1);
            $table->integer('corporacao');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_pais')->references('id')->on('paises');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
