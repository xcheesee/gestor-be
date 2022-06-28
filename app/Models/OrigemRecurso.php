<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrigemRecurso extends Model
{
    use HasFactory;

    protected $table = 'origem_recursos';

    protected $fillable = [
        "nome",
    ];
}
