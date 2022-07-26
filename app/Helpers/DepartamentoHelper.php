<?php

namespace App\Helpers;

use App\Models\Departamento;
use App\Models\DepartamentoUsuario;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DepartamentoHelper
{
    public static function dropDownList(){
        $departamentos = Departamento::query()->orderBy('nome')->get(); //->where('ativo','=',1)

        $arrSelect = array();
        foreach($departamentos as $k=>$v){
            $arrSelect[$v->id] = $v->nome;
        }

        return $arrSelect;
    }

    public static function deptosByUser(int $id, string $coluna){
        $departamentos = DepartamentoUsuario::query()->where('user_id','=',$id)->orderBy('departamento_id')->get(); //->where('ativo','=',1)
        $arrSelect = array();
        foreach($departamentos as $v){
            $arrSelect[$v->departamento->id] = $v->departamento[$coluna];
        }

        return $arrSelect;
    }
}
