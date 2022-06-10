<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aditamento extends Model
{
    protected $fillable = [
        'contrato_id',
        'tipo_aditamentos',
        'valor_aditamento',
        'dias_acrescimo',
        'indice_reajuste',
        'pct_reajuste',
    ];

    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }
}
