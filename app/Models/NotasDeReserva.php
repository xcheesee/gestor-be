<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotasDeReserva extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_nota_reserva',
        'data_emissao',
        'tipo_nota',
        'valor',
    ];
}
