<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriarColunasParaAlertasDeContratos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contratos', function (Blueprint $table) {
            $table->tinyInteger('aviso_90')->nullable()->after('outras_informacoes')->default(0);
            $table->tinyInteger('aviso_60')->nullable()->after('outras_informacoes')->default(0);
            $table->tinyInteger('aviso_30')->nullable()->after('outras_informacoes')->default(0);
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
            $table->dropColumn('aviso_90');
            $table->dropColumn('aviso_60');
            $table->dropColumn('aviso_30');
        });
    }
}
