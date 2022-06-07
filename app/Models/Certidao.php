<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certidao extends Model
{
    protected $table = 'certidoes';

    protected $fillable = [
        'contrato_id',
        'certidoes',
        'validade_certidoes',
    ];

    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }
}
