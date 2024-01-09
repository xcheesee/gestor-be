<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AumentarLimitesFloat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ano_de_execucao', function (Blueprint $table) {
            //
            $table->float('planejado',16,2)->change();
            $table->float('reservado',16,2)->change();
            $table->float('contratado',16,2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ano_de_execucao', function (Blueprint $table) {
            //
        });
    }
}
