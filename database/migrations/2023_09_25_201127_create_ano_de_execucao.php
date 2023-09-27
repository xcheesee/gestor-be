<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnoDeExecucao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ano_de_execucao', function (Blueprint $table) {
            $table->id();
            $table->integer('ano');
            $table->unsignedBigInteger('id_contrato');
            $table->string('mes_inicial');
            $table->float('planejado');
            $table->string('reservado');
            $table->string('contratado');
            $table->timestamps();

            $table->foreign('id_contrato')->references('id')->on('contratos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ano_de_execucao');
    }
}
