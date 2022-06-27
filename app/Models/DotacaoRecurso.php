<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DotacaoRecurso extends Model
{
    use HasFactory;

    protected $fillable = [
        'dotacao_id',
        'origem_recurso_id',
        'outros_descricao',
    ];

    public function dotacao()
    {
        return $this->belongsTo(Dotacao::class);
    }

    public function origem_recurso_id()
    {
        return $this->belongsTo(OrigemRecurso::class);
    }
}
