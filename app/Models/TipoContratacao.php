<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoContratacao extends Model
{
    use HasFactory;

    protected $table = 'tipo_contratacoes';

    protected $fillable = [
        'contrato_id',
        'nome',
    ];

    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }
}
