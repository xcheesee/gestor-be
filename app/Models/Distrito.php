<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
    protected $fillable = [
        'subprefeitura_id',
        'nome',
    ];

    public function subprefeitura()
    {
        return $this->belongsTo(Surprefeitura::class);
    }
}
