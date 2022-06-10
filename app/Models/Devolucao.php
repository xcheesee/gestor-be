<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devolucao extends Model
{
    use HasFactory;
    protected $table = 'devolucoes';

    protected $fillable = [
        'contrato_id',
        'data_devolucao',
        'numero_devolucao',
        'valor_devolucao',
    ];

    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }
}
