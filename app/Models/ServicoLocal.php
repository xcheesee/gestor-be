<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicoLocal extends Model
{
    protected $table = 'servico_locais';

    protected $fillable = [
        'contrato_id',
        'distrito_id',
        'subprefeitura_id',
        'unidade',
    ];

    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }

    public function distrito()
    {
        return $this->belongsTo(Distrito::class);
    }

    public function subprefeitura()
    {
        return $this->belongsTo(Subprefeitura::class);
    }
}
