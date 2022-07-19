<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class DotacaoTipo extends Model
{
    use HasFactory;
    use Sortable;

    protected $table = 'dotacao_tipos';
    public $sortable = ['id','numero_dotacao','descricao','tipo_despesa'];

    protected $fillable = [
        "numero_dotacao",
        "descricao",
        "tipo_despesa",
    ];
}
