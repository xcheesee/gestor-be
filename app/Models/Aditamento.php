<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aditamento extends Model
{
    protected $fillable = [
        'contrato_id',
        'tipo_aditamentos',
        'valor_aditamento',
        'data_fim_vigencia_atualizada',
        'indice_reajuste',
        'data_base_reajuste',
        'valor_reajustado',
    ];

    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }
}
