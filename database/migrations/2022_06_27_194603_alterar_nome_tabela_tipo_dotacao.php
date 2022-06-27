<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterarNomeTabelaTipoDotacao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dotacoes', function (Blueprint $table) {
            $table->dropForeign('dotacoes_tipo_dotacao_id_foreign');
            $table->dropColumn('tipo_dotacao_id');
        });

        Schema::rename('tipo_dotacoes', 'dotacao_tipos');

        Schema::table('dotacoes', function (Blueprint $table) {
            $table->foreignId('dotacao_tipo_id')->constrained('dotacao_tipos')->after('id');
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
