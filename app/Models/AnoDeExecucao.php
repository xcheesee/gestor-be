<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnoDeExecucao extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'ano',
        'id_contrato',
        'mes_inicial',
        'planejado',
        'reservado',
        'contratado'
    ];

    protected $table = 'ano_de_execucao';
}
