<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GestaoFiscalizacao extends Model
{
    protected $table = 'gestao_fiscalizacao';

    protected $fillable = [
        'contrato_id',
        'nome_gestor',
        'email_gestor',
        'nome_fiscal',
        'email_fiscal',
        'nome_suplente',
        'email_suplente'
    ];

    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }
}
