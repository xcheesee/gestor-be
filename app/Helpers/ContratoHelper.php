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
                //TODO: verificar se faz mais sentido usar o estado_id = 3 (Status "Em Execução")
                return $query->whereNotNull('data_inicio_vigencia')
                    ->whereRaw('DATEDIFF(data_inicio_vigencia, NOW()) <= 0')
                    ->whereNotIn('estado_id',[4,5]);
            })
            ->when($modo == 'obra', function ($query) {
                return $query->where('categoria_id','=','1');
            })
            ->when($modo == 'serviço', function ($query) {
                return $query->where('categoria_id','=','2');
            })
            ->when($modo == 'aquisição', function ($query) {
                return $query->where('categoria_id','=','3');
            })
            ->when($modo == 'vencidos', function ($query) {
                return $query->whereNotNull('data_vencimento')
                    ->whereRaw('DATEDIFF(data_vencimento_aditada, NOW()) < 0')
                    ->whereNotIn('estado_id',[4,5]); //removendo contratos finalizados e suspensos
            })
            ->when($modo == 'finalizados', function ($query) {
                return $query->where('estado_id','=',4);
            })
            ->when($filtros['departamento'], function ($query, $val) {
                return $query->where('departamento_id','=',$val);
            })
            ->when($filtros['ano_pesquisa'], function ($query, $val) {
                $query->where(function($query) use ($val){
                    $query->where(DB::raw('YEAR(minuta_edital)'),'=',$val)
                          ->orWhere(DB::raw('YEAR(data_inicio_vigencia)'),'=',$val);
                });
            })
            ->where('ativo','=','1')
            ->count();
            // ->dump();

        // dd($retorno);
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
