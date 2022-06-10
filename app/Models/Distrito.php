<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
    protected $fillable = [
        'nome',
        'subprefeitura_id',
    ];

    public function subprefeitura()
    {
        return $this->belongsTo(Surprefeitura::class);
    }
}
