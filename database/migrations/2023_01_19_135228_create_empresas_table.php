<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cnpj',14)->nullable();
            $table->string('telefone',20)->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });

        Schema::table('contratos', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('empresa_id')->nullable()->after('departamento_id');
            $table->foreign('empresa_id')->references('id')->on('empresas');
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
            $table->dropForeign('empresas_empresa_id_foreign');
            $table->dropColumn('empresa_id');
        });

        Schema::dropIfExists('empresas');
    }
}
