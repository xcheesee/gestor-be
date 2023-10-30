<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Subprefeitura extends Model
{
    use Sortable;

    public $sortable = ['id','regiao','nome'];
    protected $fillable = [
        'regiao',
        'nome',
    ];

    public function subprefeiturasLocais()
    {
        return $this->hasMany(ServicoLocalSubprefeitura::class);
    }
}
