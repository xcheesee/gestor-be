<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AditamentoValor extends Model
{
    protected $table = 'aditamentos_valor';

    protected $fillable = [
        'contrato_id',
        'tipo_aditamento',
        'valor_aditamento',
        'percentual',
    ];

    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }
}
