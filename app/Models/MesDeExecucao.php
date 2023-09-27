<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MesDeExecucao extends Model
{
    use HasFactory;

    protected $fillable = ['id_ano_execucao', 'data'];
    protected $table = 'mes_de_execucao';
}
