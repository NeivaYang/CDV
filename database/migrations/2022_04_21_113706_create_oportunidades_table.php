<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOportunidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oportunidades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_user');
            $table->string('codigo',15);
            $table->integer('estagio')->default(0); //(0=Prospecto, 1=Reunião, 2=Negociacão, 3=Abandono, 4=Fechado Positivo, 5=Fechado Negativo)
            $table->string('tipo',7); // (produto/serviço)
            $table->string('contrato',10); // (novo/renovação)
            $table->string('contrato_anterior',20)->nullable();
            $table->string('moeda',20);
            $table->date('data_inicio');
            $table->unsignedBigInteger('id_cliente');
            $table->unsignedBigInteger('id_cdc');
            $table->decimal('montante',11,2)->nullable();
            $table->date('data_fechamento')->nullable();
            $table->date('data_entrega')->nullable();
            $table->decimal('margem_bruta',11,2)->default(0)->nullable();
            $table->integer('numero_equipamentos')->default(0)->nullable();
            $table->date('data_prospecto')->nullable();
            $table->date('data_reuniao')->nullable();
            $table->date('data_negociacao')->nullable();
            $table->date('data_abandono')->nullable();
            $table->date('data_fechado_positivo')->nullable();
            $table->date('data_fechado_negativo')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_user')->references('id')->on('users');
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
        Schema::dropIfExists('oportunidades');
    }
}
