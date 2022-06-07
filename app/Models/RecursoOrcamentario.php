<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecursoOrcamentario extends Model
{
    public $timestamps;

    protected $table = 'recurso_orcamentario';

    protected $fillable = [
        'contrato_id',
        'nota_empenho',
        'saldo_empenho',
        'dotacao_orcamentaria',
    ];

    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }
}
