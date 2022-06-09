<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriarNovasTabelasReuniaoInicial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('aditamentos', function (Blueprint $table) {
            //
            $table->renameColumn('idx_reajuste', 'indice_reajuste');
        });

        Schema::create('tipo_contratacoes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->timestamps();
        });

        Schema::table('contratos', function (Blueprint $table) {
            $table->foreignId('tipo_contratacao_id')->nullable()->after('id')->constrained('tipo_contratacoes');
            $table->renameColumn('data_fim_vigencia', 'data_vencimento');
        });

        Schema::create('devolucoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contrato_id')->constrained();
            $table->date('data_devolucao');
            $table->integer('numero_devolucao')->nullable();
            $table->float('valor_devolucao',16,2);
            $table->timestamps();
        });

        Schema::create('planejadas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contrato_id')->constrained();
            $table->integer('mes');
            $table->integer('ano');
            $table->enum('tipo_lancamento', ['reserva','empenho']);
            $table->enum('modalidade', ['normal', 'complementar', 'reajuste']);
            $table->date('data_emissao_planejado')->nullable();
            $table->date('numero_planejado')->nullable();
            $table->float('valor_planejado',16,2);
            $table->timestamps();
        });

        Schema::create('executadas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contrato_id')->constrained();
            $table->integer('mes');
            $table->integer('ano');
            $table->date('data_emissao_executado')->nullable();
            $table->date('numero_executado')->nullable();
            $table->float('valor_executado',16,2);
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
    }
}
