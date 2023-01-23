<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dotacao extends Model
{
    use HasFactory;

    protected $table = 'dotacoes';

    protected $fillable = [
        'dotacao_tipo_id',
        'contrato_id',
    ];

    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }

    public function dotacao_tipo()
    {
        return $this->belongsTo(DotacaoTipo::class);
    }

    public function dotacao_recursos(){
        return $this->hasMany(DotacaoRecurso::class);
    }
}
