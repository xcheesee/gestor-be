<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpenhoNota extends Model
{
    use HasFactory;

    protected $table = 'empenho_notas';

    protected $fillable = [
        "contrato_id",
        "tipo_empenho",
        "data_emissao",
        "numero_nota",
        "valor_empenho",
    ];
}
