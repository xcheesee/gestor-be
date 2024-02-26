<?php

namespace App\Helpers;

use App\Models\AditamentoPrazo;
use App\Models\Contrato;
use Illuminate\Support\Facades\DB;

class ContratoHelper
{
    public static function contador($filtros, $modo = 'total'){
        $retorno = Contrato::query()
            ->when($modo == 'iniciados', function ($query, $val) {
                return $query->whereNotNull('data_inicio_vigencia');
            })
            ->when($modo == 'obra', function ($query) {
                return $query->where('tipo_objeto','=','obra');
            })
            ->when($modo == 'projeto', function ($query) {
                return $query->where('tipo_objeto','=','projeto');
            })
            ->when($modo == 'serviço', function ($query) {
                return $query->where('tipo_objeto','=','serviço');
            })
            ->when($modo == 'aquisição', function ($query) {
                return $query->where('tipo_objeto','=','aquisição');
            })
            ->when($modo == 'vencidos', function ($query) {
                return $query->whereNotNull('data_vencimento')->whereRaw('DATEDIFF(data_vencimento, NOW()) < 0');
            })
            ->when($filtros['departamento'], function ($query, $val) {
                return $query->where('departamento_id','=',$val);
            })
            ->where(function($query) use ($filtros){
                $query->where(DB::raw('YEAR(minuta_edital)'),'=',$filtros['ano_pesquisa'])
                      ->orWhere(DB::raw('YEAR(data_inicio_vigencia)'),'=',$filtros['ano_pesquisa']);
            })
            ->count();

        return $retorno;
    }

    public static function calculaDataVencimentoAditada($contrato){
        if ($contrato->data_vencimento){
            $dt_vencto = date_create_from_format('Y-m-d', $contrato->data_vencimento);
            $aditamentos_prazo = AditamentoPrazo::query()->where('contrato_id','=',$contrato->id)->get();
            foreach($aditamentos_prazo as $adt_prz){
                if($adt_prz->tipo_aditamento == 'Prorrogação de prazo')
                    date_add($dt_vencto,date_interval_create_from_date_string($adt_prz->dias_reajuste." days"));
                elseif($adt_prz->tipo_aditamento == 'Supressão de prazo')
                    date_sub($dt_vencto,date_interval_create_from_date_string($adt_prz->dias_reajuste." days"));
            }

            $adt_prazo_corrigido = $dt_vencto->format("Y-m-d");
            return $adt_prazo_corrigido;
        }
        return null;
    }
}
