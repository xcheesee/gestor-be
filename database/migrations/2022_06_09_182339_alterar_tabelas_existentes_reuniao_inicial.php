<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterarTabelasExistentesReuniaoInicial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aditamentos', function (Blueprint $table) {
            //
            $table->dropColumn('data_fim_vigencia_atualizada');
            $table->float('pct_reajuste',5,2)->after('valor_aditamento')->nullable();
            $table->string('idx_reajuste',10)->after('valor_aditamento')->nullable();
            $table->integer('dias_reajuste')->after('valor_aditamento');
            $table->dropColumn('indice_reajuste'); //$table->renameColumn('from', 'to');
            $table->dropColumn('data_base_reajuste');
            $table->dropColumn('valor_reajustado');
        });

        Schema::table('contratos', function (Blueprint $table) {
            //
            //$table->foreignId('tipo_contratacao_id')->constrained('tipo_contratacoes')->after('id')->nullable();
            $table->string('dotacao_orcamentaria')->after('processo_sei');
            $table->enum('tipo_objeto',['obra', 'projeto', 'serviço', 'aquisição'])->after('cnpj_cpf')->nullable();
            $table->float('valor_mensal_estimativo',16,2)->after('valor_contrato')->nullable();
            $table->string('fonte_recurso')->after('outras_informacoes')->nullable();
            $table->date('homologacao')->after('outras_informacoes')->nullable();
            $table->date('abertura_certame')->after('outras_informacoes')->nullable();
            $table->date('minuta_edital')->after('outras_informacoes')->nullable();
            $table->date('envio_material_tecnico')->after('outras_informacoes')->nullable();
            $table->dropColumn('prazo_contrato_meses');
        });

        Schema::table('gestao_fiscalizacao', function (Blueprint $table) {
            //
            $table->string('email_gestor')->after('nome_gestor');
            $table->string('email_fiscal')->after('nome_fiscal');
            $table->string('email_suplente')->after('nome_suplente');
        });

        Schema::table('servico_locais', function (Blueprint $table) {
            //
            $table->string('unidade',100);
        });

        Schema::drop('recurso_orcamentario');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //nothing, we need this migration
    }
}
