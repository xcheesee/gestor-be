<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reajuste extends Model
{
    use HasFactory;

    protected $fillable = [
        'contrato_id',
        'indice_reajuste',
        'valor_reajuste',
        'percentual',
    ];

    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }
}
