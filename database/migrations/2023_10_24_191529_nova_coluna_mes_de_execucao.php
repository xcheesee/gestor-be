<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NovaColunaMesDeExecucao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("mes_de_execucao", function (Blueprint $table) {
            $table->float('empenhado')->nullable()->after('execucao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mes_de_execucao', function (Blueprint $table) {
            $table->dropColumn('empenhado');
        });
    }
}
