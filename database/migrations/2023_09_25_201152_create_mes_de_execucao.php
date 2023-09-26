<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMesDeExecucao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mes_de_execucao', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_ano_execucao');
            $table->unsignedBigInteger('mes');
            $table->string('execucao');
            $table->timestamps();

            $table->foreign('id_ano_execucao')->references('id')->on('ano_de_execucao');    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mes_de_execucao');
    }
}
