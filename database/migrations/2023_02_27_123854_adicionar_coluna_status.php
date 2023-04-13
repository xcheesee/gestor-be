<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdicionarColunaStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estados', function (Blueprint $table) {
            $table->id();
            $table->string('valor');
            $table->timestamps();
        });

        Schema::table('contratos', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('estado_id')->nullable()->after('licitacao_modelo_id');
            $table->foreign('estado_id')->references('id')->on('estados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contratos', function (Blueprint $table) {
            //
            $table->dropForeign('contratos_estado_id_foreign');
        });

        Schema::dropIfExists('estados');
    }
}
