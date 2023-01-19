<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Empresa extends Model
{
    use HasFactory;
    use Sortable;

    public $sortable = ['id','nome','cnpj','telefone','email'];

    protected $fillable = [
        'nome',
        'cnpj',
        'telefone',
        'email',
    ];

    public function getCnpjFormatadoAttribute(){
        if ($this->cnpj){
            $cnpj = $this->cnpj;
            return substr($cnpj,0,2).'.'.substr($cnpj,2,3).'.'.substr($cnpj,5,3).'/'.substr($cnpj,8,4).'-'.substr($cnpj,12);
        }

        return null;
    }
}
