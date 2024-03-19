<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NovasColunasContratoDatas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contratos', function(Blueprint $table){
            $table->date('data_recebimento_provisorio')->nullable()->after('ativo');
            $table->date('data_recebimento_definitivo')->nullable()->after('ativo');
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
            $table->dropColumn('data_recebimento_provisorio');
            $table->dropColumn('data_recebimento_definitivo');
        });
    }
}
