<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClienteCdcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cliente_cdcs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_cliente');
            $table->unsignedBigInteger('id_cdc');
            $table->decimal('area_total',9,2)->nullable();
            $table->decimal('area_irrigada',9,2)->nullable();
            $table->string('fazenda',100)->nullable();
            $table->string('cidade', 50)->nullable();
            $table->string('estado', 5)->nullable();
            $table->integer('id_cidade')->foreign('id_cidade')->references('id')->on('cidades');
            $table->integer('id_estado')->foreign('id_estado')->references('id')->on('estados')->nullable();
            $table->float('latitude', 12,8)->nullable();
            $table->float('longitude', 12,8)->nullable();
            $table->string('cultura')->nullable();
            $table->integer('aspersor_qtd')->nullable();
            $table->integer('microaspersor_qtd')->nullable();
            $table->integer('gotejador_qtd')->nullable();
            $table->integer('pivo_central_qtd')->nullable();
            $table->integer('linear_qtd')->nullable();
            $table->integer('autopropelido_qtd')->nullable();            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_cliente')->references('id')->on('clientes');
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
        Schema::dropIfExists('cliente_cdcs');
    }
}
