<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TrocarColunaRegiao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subprefeituras', function (Blueprint $table) {
            //
            $table->enum('regiao', ['N','S','L','CO'])->after('id');
        });

        Schema::table('servico_locais', function (Blueprint $table) {
            //
            $table->dropColumn('regiao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subprefeituras', function (Blueprint $table) {
            //
            $table->dropColumn('regiao');
        });

        Schema::table('servico_locais', function (Blueprint $table) {
            //
            $table->enum('regiao', ['N','S','L','CO'])->after('subprefeitura_id');
        });
    }
}
