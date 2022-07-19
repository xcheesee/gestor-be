<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Distrito extends Model
{
    use Sortable;

    public $sortable = ['id','nome'];
    protected $fillable = [
        'nome',
        'subprefeitura_id',
    ];

    public function subprefeitura()
    {
        return $this->belongsTo(Subprefeitura::class);
    }
}
