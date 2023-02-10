<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdicionarPercentualReajuste extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reajustes', function (Blueprint $table) {
            $table->float('percentual',5,2)->nullable()->after('valor_reajuste');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reajustes', function (Blueprint $table) {
            $table->dropColumn('percentual');
        });
    }
}
