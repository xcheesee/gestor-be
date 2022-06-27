<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlteracoesReuniao20jun2022 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('tipo_contratacoes', 'licitacao_modelos');

        Schema::table('contratos', function (Blueprint $table) {
            $table->dropForeign('contratos_tipo_contratacao_id_foreign');
            $table->dropColumn('tipo_contratacao_id');
            $table->foreignId('licitacao_modelo_id')->nullable()->constrained()->after('id');
            $table->dropColumn('dotacao_orcamentaria');
            $table->dropColumn('fonte_recurso');
        });

        Schema::table('aditamentos', function (Blueprint $table) {
            $table->dropColumn('dias_reajuste');
            $table->dropColumn('tipo_aditamentos');
            $table->enum('tipo_aditamento', ['Acréscimo de valor','Redução de valor'])->nullable()->after('contrato_id');
        });

        Schema::create('aditamentos_prazo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contrato_id')->constrained();
            $table->enum('tipo_aditamento', [
                'Prorrogação de prazo','Supressão de prazo','Suspensão','Rescisão'
            ])->nullable();
            $table->integer('dias_reajuste')->nullable();
            $table->timestamps();
        });

        Schema::rename('aditamentos', 'aditamentos_valor');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('licitacao_modelos', 'tipo_contratacoes');
    }
}
