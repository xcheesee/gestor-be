<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriasTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nome',45);
            $table->timestamps();
        });

        Schema::create('subcategorias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('categoria_id');
            $table->string('nome',45);
            $table->timestamps();

            $table->foreign('categoria_id')->references('id')->on('categorias');
        });

        Schema::table('contratos', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('categoria_id')->nullable()->after('licitacao_modelo_id');
            $table->unsignedBigInteger('subcategoria_id')->nullable()->after('categoria_id');

            $table->foreign('categoria_id')->references('id')->on('categorias');
            $table->foreign('subcategoria_id')->references('id')->on('subcategorias');
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
            $table->dropForeign(['categoria_id']);
            $table->dropForeign(['subcategoria_id']);
        });

        Schema::dropIfExists('categorias');
        Schema::dropIfExists('subcategorias');
    }
}
