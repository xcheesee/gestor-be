<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GestaoContrato extends Model
{
    protected $fillable = [
        'contrato_id',
        'gestao_fiscalizacao_id',
    ];

    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }

    public function gestaoFiscalizacao()
    {
        return $this->belongsTo(GestaoFiscalizacao::class);
    }
}