<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterarCampoDotacaoTipoId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dotacoes', function (Blueprint $table) {
            $table->unsignedBigInteger('dotacao_tipo_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->unsignedBigInteger('dotacao_tipo_id')->nullable(false)->change();
    }
}
