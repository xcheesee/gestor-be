<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicitacaoModelo extends Model
{
    use HasFactory;

    //protected $table = 'tipo_contratacoes';

    protected $fillable = [
        'nome',
    ];
}
