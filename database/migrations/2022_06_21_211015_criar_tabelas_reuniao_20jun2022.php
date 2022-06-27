<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriarTabelasReuniao20jun2022 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contratos', function (Blueprint $table) {
            $table->float('valor_reserva',16,2)->after('data_prazo_maximo')->nullable();
            $table->string('numero_nota_reserva')->after('data_prazo_maximo')->nullable();
        });

        Schema::dropIfExists('planejadas');
        Schema::dropIfExists('executadas');
        Schema::dropIfExists('devolucoes');
        Schema::dropIfExists('gestao_contratos');

        Schema::create('empenho_notas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contrato_id')->constrained();
            $table->enum('tipo_empenho', ['complemento','cancelamento'])->nullable();
            $table->date('data_emissao')->nullable();
            $table->integer('numero_nota')->nullable();
            $table->float('valor_empenho',16,2);
            $table->timestamps();
        });

        Schema::create('execucao_financeira', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contrato_id')->constrained();
            $table->integer('mes');
            $table->integer('ano');
            $table->float('planejado_inicial',16,2)->default(0)->nullable()->comment('fixo');
            $table->float('contratado_inicial',16,2)->default(0)->nullable()
                  ->comment('contratado + reajuste + aditivo - cancelamento = contratado_atualizado; contratado_atualizado - executado = saldo_contrato');
            $table->float('valor_reajuste',16,2)->default(0)->nullable()->comment('contratado + reajuste + aditivo - cancelamento = contratado_atualizado');
            $table->float('valor_aditivo',16,2)->default(0)->nullable()->comment('contratado + reajuste + aditivo - cancelamento = contratado_atualizado');
            $table->float('valor_cancelamento',16,2)->default(0)->nullable()->comment('contratado + reajuste + aditivo - cancelamento = contratado_atualizado');
            $table->float('empenhado',16,2)->default(0)->nullable()
                  ->comment('exibir total de notas de empenho para o usuário quando o mesmo for definir este campo; empenhado - executado = saldo_empenho');
            $table->float('executado',16,2)->default(0)->nullable()->comment('empenhado - executado = saldo_empenho; contratado_atualizado - executado = saldo_contrato');
            $table->timestamps();
        });

        Schema::create('dotacao_tipos', function (Blueprint $table) {
            $table->id();
            $table->string('numero_dotacao');
            $table->text('descricao');
            $table->text('tipo_despesa')->nullable();
            $table->timestamps();
        });

        Schema::create('origem_recursos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->timestamps();
        });

        Schema::create('dotacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_dotacao_id')->constrained('tipo_dotacoes');
            $table->foreignId('contrato_id')->constrained();
            $table->float('valor_dotacao',16,2);
            $table->timestamps();
        });

        Schema::create('dotacao_recursos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dotacao_id')->constrained('dotacoes');
            $table->foreignId('origem_recurso_id')->nullable()->constrained();
            $table->string('outros_descricao')->nullable();
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
