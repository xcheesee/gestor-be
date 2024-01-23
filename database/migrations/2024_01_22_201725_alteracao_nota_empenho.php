<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlteracaoNotaEmpenho extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empenho_notas', function (Blueprint $table) {
            $table->integer('mes_referencia')->after('valor_empenho');
            $table->integer('ano_referencia')->after('valor_empenho');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empenho_notas', function (Blueprint $table) {
            $table->dropColumn('mes_referencia');
            $table->dropColumn('ano_referencia');
        });
    }
}
