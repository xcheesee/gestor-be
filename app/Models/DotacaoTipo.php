<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DotacaoTipo extends Model
{
    use HasFactory;

    protected $table = 'dotacao_tipos';

    protected $fillable = [
        "numero_dotacao",
        "descricao",
        "tipo_despesa",
    ];
}
