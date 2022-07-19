<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdicionarRegraUnique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dotacao_tipos', function (Blueprint $table) {
            //
            $table->string('numero_dotacao')->unique()->change();
            //$table->string('tipo_despesa')->unique()->change();
        });

        Schema::table('contratos', function (Blueprint $table) {
            //
            $table->string('processo_sei')->unique()->change();
            $table->string('numero_contrato')->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dotacao_tipos', function (Blueprint $table) {
            //
            $table->string('numero_dotacao')->change();
            //$table->string('tipo_despesa')->change();
        });

        Schema::table('contratos', function (Blueprint $table) {
            //
            $table->string('processo_sei')->change();
            $table->string('numero_contrato')->change();
        });
    }
}
