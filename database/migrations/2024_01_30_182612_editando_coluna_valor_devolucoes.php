<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditandoColunaValorDevolucoes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('devolucoes', function (Blueprint $table) {
            $table->integer('numero_devolucao')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('devolucoes', function (Blueprint $table) {
            $table->float('numero_devolucao', 5, 3)->change();
        });
    }
}
