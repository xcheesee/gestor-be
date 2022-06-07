<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestaoContratos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Esta tabela pode estar obsoleta. Será criada somente para fins de verificar
         * com o usuário final sobre a composição da gestão do contrato.
         *
         * Se for sempre em trios (gestor,fiscal,suplente), então não há necessidade de formar
         * uma tabela de times linkando os participantes e os contratos. Atualmente estamos linkando
         * o contrato com o trio gestor/fiscal/suplente
         */
        Schema::create('gestao_contratos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contrato_id')->constrained();
            $table->foreignId('gestao_fiscalizacao_id')->constrained('gestao_fiscalizacao');
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
        Schema::dropIfExists('gestao_contratos');
    }
}
