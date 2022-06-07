<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriarTabelasAuxiliaresContrato extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('servico_locais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contrato_id')->constrained();
            $table->foreignId('distrito_id')->constrained();
            $table->foreignId('subprefeitura_id')->constrained();
            $table->enum('regiao', ['N','S','L','CO']);
            $table->timestamps();
        });

        Schema::create('garantias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contrato_id')->constrained();
            $table->string('instituicao_financeira')->nullable();
            $table->string('numero_documento')->nullable();
            $table->float('valor_garantia', 16, 2)->nullable();
            $table->date('data_validade_garantia')->nullable();
            $table->timestamps();
        });

        Schema::create('certidoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contrato_id')->constrained();
            $table->string('certidoes')->nullable();
            $table->date('validade_certidoes')->nullable();
            $table->timestamps();
        });

        Schema::create('aditamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contrato_id')->constrained();
            $table->enum('tipo_aditamentos', [
                'Acréscimo de valor','Redução de valor','Prorrogação de prazo','Supressão de prazo','Suspensão','Rescisão'
            ])->nullable();
            $table->float('valor_aditamento', 16, 2)->nullable();
            $table->date('data_fim_vigencia_atualizada')->nullable();
            $table->float('indice_reajuste', 5, 2)->nullable(); //taxa reajuste
            $table->date('data_base_reajuste')->nullable();
            $table->float('valor_reajustado', 16,2)->nullable();
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
        //
        Schema::dropIfExists('aditamentos');
        Schema::dropIfExists('certidoes');
        Schema::dropIfExists('garantias');
        Schema::dropIfExists('servico_locais');
    }
}
