<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCdcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cdcs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cdc',10)->unique();
            $table->string('nome',50)->nullable();
            $table->unsignedBigInteger('id_empresa');
            $table->string('cdc_pai',10)->nullable();
            $table->integer('situacao')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_empresa')->references('id')->on('empresas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cdcs');
    }
}
