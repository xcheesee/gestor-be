<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planejada extends Model
{
    use HasFactory;

    protected $fillable = [
        'contrato_id',
        'mes',
        'ano',
        'tipo_lancamento',
        'modalidade',
        'data_emissao_planejado',
        'numero_planejado',
        'valor_planejado',
    ];

    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }
}
