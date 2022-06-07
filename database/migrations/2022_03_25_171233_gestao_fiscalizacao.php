<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestaoFiscalizacao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * verificar com o cliente depois esta estrutura, pode ser que atenda melhor definir várias pessoas e suas funções
         * se for o caso, ter a seguinte estrutura abaixo e recriar a migration de gestao_contratos:
         *
         * $table->string('nome_participante')->nullable();
         * $table->enum('funcao',['gestor','fiscal','suplente'])->nullable();
         */
        Schema::create('gestao_fiscalizacao', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contrato_id')->constrained();
            $table->string('nome_gestor')->nullable();
            $table->string('nome_fiscal')->nullable();
            $table->string('nome_suplente')->nullable();
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
        Schema::dropIfExists('gestao_fiscalizacao');
    }
}
