<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterarNulosGestaoFiscalizacao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gestao_fiscalizacao', function (Blueprint $table) {
            $table->string('email_fiscal')->nullable()->change();
            $table->string('email_suplente')->nullable()->change();
        });

        Schema::table('aditamentos', function (Blueprint $table) {
            $table->string('dias_reajuste')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gestao_fiscalizacao', function (Blueprint $table) {
            //
            $table->string('email_fiscal')->change();
            $table->string('email_suplente')->change();
        });

        Schema::table('aditamentos', function (Blueprint $table) {
            $table->string('dias_reajuste')->change();
        });
    }
}
