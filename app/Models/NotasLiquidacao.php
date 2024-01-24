<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotasLiquidacao extends Model
{
    protected $table = 'notas_liquidacao';

    use HasFactory;

    protected $fillable = [
        'contrato_id',
        'numero_nota_liquidacao',
        'data_pagamento',
        'mes_referencia',
        'ano_referencia',
        'valor',
    ];
}
