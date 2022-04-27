<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropostasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propostas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_oportunidade');
            $table->string('tipo',7)->default('padrao'); // (padrão/leasing/manejo)
            $table->date('data_proposta');
            $table->decimal('area_manejada',11,2)->nullable();
            $table->integer('quantidade_equipamento');
            $table->integer('quantidade_lance')->nullable();
            $table->decimal('area_abrangida',11,2);
            $table->decimal('valor_area',11,2)->nullable();
            $table->decimal('valor_total',11,2);
            $table->decimal('desconto_concedido',11,2);
            $table->decimal('valor_final',11,2);
            $table->text('descricao')->nullable();
            $table->boolean('sistema_aspersor')->default(0);
            $table->boolean('sistema_autopropelido')->default(0);
            $table->boolean('sistema_gotejador')->default(0);
            $table->boolean('sistema_linear')->default(0);
            $table->boolean('sistema_microaspersor')->default(0);
            $table->boolean('sistema_pivocentral')->default(0);
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
        Schema::dropIfExists('propostas');
    }
}
