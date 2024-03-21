<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NovasColunasContratoTermoRecebimento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contratos', function (Blueprint $table) {
            $table->date('termo_recebimento_provisorio')->nullable()->after('data_recebimento_provisorio');
            $table->date('termo_recebimento_definitivo')->nullable()->after('data_recebimento_provisorio');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contratos', function(Blueprint $table){
            $table->dropColumn('termo_recebimento_provisorio');
            $table->dropColumn('termo_recebimento_definitivo');
        });
    }
}
