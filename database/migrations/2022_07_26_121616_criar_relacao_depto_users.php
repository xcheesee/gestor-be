<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriarRelacaoDeptoUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departamento_usuarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('departamento_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropForeign('users_departamento_id_foreign');
            $table->dropColumn('departamento_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departamento_usuarios');
    }
}
