<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Garantia extends Model
{
    protected $fillable = [
        'contrato_id',
        'instituicao_financeira',
        'numero_documento',
        'valor_garantia', 
        'data_validade_garantia',
    ];

    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }
}
