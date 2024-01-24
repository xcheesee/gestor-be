<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotasLiquidacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notas_liquidacao', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contrato_id');
            $table->integer('numero_nota_liquidacao')->nullable();
            $table->date('data_pagamento');
            $table->integer('mes_referencia');
            $table->integer('ano_referencia');
            $table->float('valor', 16, 2);
            $table->timestamps();

            $table->foreign('contrato_id')->references('id')->on('contratos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notas_liquidacao');
    }
}
