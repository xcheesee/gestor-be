<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dotacao extends Model
{
    use HasFactory;

    protected $table = 'certidoes';

    protected $fillable = [
        'tipo_dotacao_id',
        'contrato_id',
        'valor_dotacao',
    ];

    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }

    public function tipo_dotacao()
    {
        return $this->belongsTo(TipoDotacao::class);
    }
}
