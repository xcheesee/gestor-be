<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AditamentoPrazo extends Model
{
    protected $table = 'aditamentos_prazo';
    
    protected $fillable = [
        'contrato_id',
        'tipo_aditamentos',
        'dias_reajuste',
    ];

    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }
}
