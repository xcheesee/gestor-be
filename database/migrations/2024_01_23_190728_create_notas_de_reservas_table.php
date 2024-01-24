<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotasDeReservasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notas_de_reservas', function (Blueprint $table) {
            $table->id();
            $table->integer('numero_nota_reserva');
            $table->date('data_emissao');
            $table->enum('tipo_nota', ['nova', 'correcao', 'cancelamento', 'renovacao']);
            $table->float('valor', 16, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notas_de_reservas');
    }
}
