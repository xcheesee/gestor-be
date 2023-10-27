<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicoLocalSubprefeitura extends Model
{
    protected $table = 'servicos_locais_subprefeituras';

    protected $fillable = [
        'servico_local_id',
        'subprefeitura_id',
    ];

    public function subprefeitura()
    {
        return $this->belongsTo(Subprefeitura::class);
    }
}
