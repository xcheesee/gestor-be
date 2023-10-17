<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdicionarDatasAuxiliares extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('aditamentos_valor', function (Blueprint $table) {
            $table->date('data_aditamento')->nullable()->after('percentual');
        });

        Schema::table('reajustes', function (Blueprint $table) {
            $table->date('data_reajuste')->nullable()->after('percentual');
        });

        Schema::table('servico_locais', function (Blueprint $table) {
            $table->enum('regiao', ['N','S','L','CO'])->after('contrato_id');
            $table->unsignedBigInteger('distrito_id')->nullable()->change();
            $table->unsignedBigInteger('subprefeitura_id')->nullable()->change();
            $table->string('unidade',100)->nullable()->change();
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
        Schema::table('aditamentos_valor', function (Blueprint $table) {
            $table->dropColumn('data_aditamento');
        });

        Schema::table('reajustes', function (Blueprint $table) {
            $table->dropColumn('data_reajuste');
        });
    }
}
