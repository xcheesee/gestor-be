<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Contratos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subprefeituras', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->timestamps();
        });

        Schema::create('distritos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subprefeitura_id')->constrained();
            $table->string('nome');
            $table->timestamps();
        });

        Schema::create('contratos', function (Blueprint $table) {
            $table->id();
            $table->string('processo_sei');
            $table->string('credor');
            $table->string('cnpj_cpf');
            $table->string('objeto');
            $table->string('numero_contrato');
            $table->date('data_assinatura')->nullable();
            $table->float('valor_contrato', 16, 2);
            $table->date('data_inicio_vigencia');
            $table->date('data_fim_vigencia')->nullable();
            $table->string('condicao_pagamento');
            $table->integer('prazo_contrato_meses');
            $table->string('prazo_a_partir_de')->nullable();
            $table->date('data_prazo_maximo')->nullable();
            $table->string('nome_empresa');
            $table->string('telefone_empresa');
            $table->string('email_empresa');
            $table->text('outras_informacoes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contratos');
        Schema::dropIfExists('distritos');
        Schema::dropIfExists('contratos');
    }
}
