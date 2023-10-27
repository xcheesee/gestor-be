<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuxServicosLocais extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicos_locais_subprefeituras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('servico_local_id');
            $table->unsignedBigInteger('subprefeitura_id');
            $table->timestamps();

            $table->foreign('servico_local_id')->references('id')->on('servico_locais');
            $table->foreign('subprefeitura_id')->references('id')->on('subprefeituras');
        });

        Schema::table('servico_locais', function (Blueprint $table) {
            $table->dropForeign(['subprefeitura_id']);
            $table->dropColumn('subprefeitura_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicos_locais_subprefeituras');
    }
}
