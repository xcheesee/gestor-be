<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GestaoFiscalizacao extends Model
{
    protected $table = 'gestao_fiscalizacao';

    protected $fillable = [
        'contrato_id',
        'nome_gestor',
        'nome_fiscal',
        'nome_suplente',
    ];

    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }
}
