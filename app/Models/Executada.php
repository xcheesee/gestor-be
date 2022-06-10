<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Executada extends Model
{
    use HasFactory;

    protected $fillable = [
        'contrato_id',
        'mes',
        'ano',
        'data_emissao_executado',
        'numero_executado',
        'valor_executado',
    ];

    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }
}
