<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterarCamposContratos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contratos', function (Blueprint $table) {
            $table->string('credor')->nullable()->change();
            $table->string('cnpj_cpf')->nullable()->change();
            $table->string('objeto')->nullable()->change();
            $table->string('numero_contrato')->nullable()->change();
            $table->float('valor_contrato', 16, 2)->nullable()->change();
            $table->date('data_inicio_vigencia')->nullable()->change();
            $table->string('condicao_pagamento')->nullable()->change();
            $table->string('nome_empresa')->nullable()->change();
            $table->string('telefone_empresa')->nullable()->change();
            $table->string('email_empresa')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contratos', function (Blueprint $table) {
            $table->string('credor')->nullable(false)->change();
            $table->string('cnpj_cpf')->nullable(false)->change();
            $table->string('objeto')->nullable(false)->change();
            $table->string('numero_contrato')->nullable(false)->change();
            $table->float('valor_contrato', 16, 2)->nullable(false)->change();
            $table->date('data_inicio_vigencia')->nullable(false)->change();
            $table->string('condicao_pagamento')->nullable(false)->change();
            $table->string('nome_empresa')->nullable(false)->change();
            $table->string('telefone_empresa')->nullable(false)->change();
            $table->string('email_empresa')->nullable(false)->change();
        }); 
    }
}
