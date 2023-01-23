<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterarCamposReuniaoJan23 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::statement("ALTER TABLE empenho_notas MODIFY tipo_empenho ENUM('novo_empenho', 'complemento', 'cancelamento') NULL");

        Schema::table('dotacoes', function (Blueprint $table) {
            $table->dropColumn('valor_dotacao');
        });

        Schema::table('aditamentos_valor', function (Blueprint $table) {
            $table->dropColumn('indice_reajuste');
            $table->renameColumn('pct_reajuste', 'percentual');
        });

        Schema::create('reajustes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contrato_id')->constrained();
            $table->integer('indice_reajuste');
            $table->integer('valor_reajuste');
            $table->timestamps();
        });

        Schema::dropIfExists('usuario_departamentos');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::statement("ALTER TABLE empenho_notas MODIFY tipo_empenho ENUM('complemento', 'cancelamento') NOT NULL");

        Schema::table('dotacoes', function (Blueprint $table) {
            $table->float('valor_dotacao',16,2);
        });

        Schema::table('aditamentos_valor', function (Blueprint $table) {
            $table->string('indice_reajuste',10)->nullable();
            $table->renameColumn('percentual', 'pct_reajuste');
        });

        Schema::dropIfExists('reajustes');
    }
}
