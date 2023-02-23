<?php

namespace App\Charts;

use App\Models\Contrato;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

//Contratos a vencer por departamento
class Chart3
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($filtros)
    {
        $dados = Contrato::query()
            ->select('contratos.id','departamento_id','departamentos.nome as depto',DB::raw('DATEDIFF(data_vencimento, NOW()) AS dias_vencimento'))
            ->leftJoin("departamentos",'contratos.departamento_id','=','departamentos.id')
            ->when($filtros['departamento'], function ($query, $val) {
                return $query->where('departamento_id','=',$val);
            })
            ->whereRaw('data_vencimento IS NOT NULL')
            // ->where(function($query) use ($filtros){
            //     $query->where(DB::raw('YEAR(minuta_edital)'),'=',$filtros['ano_pesquisa'])
            //           ->orWhere(DB::raw('YEAR(data_inicio_vigencia)'),'=',$filtros['ano_pesquisa']);
            // })
            ->get();

        $dataset = array(
            'deptos' => array(),
        );

        $grafico = $this->chart->barChart()
            ->setTitle('Contratos a vencer por departamento')
            ->setSubtitle('Ano de referência: '.$filtros['ano_pesquisa'])
            ->setLabels($dataset['deptos'])
            ->setHeight(380);

        $i = 0;
        foreach($dados as $dado){
            $k = array_search($dado->depto,$dataset['deptos']);
            if($k === false){
                $dataset['deptos'][$i]=$dado->depto;
                $dataset['90 dias'][$i] = 0;
                $dataset['60 dias'][$i] = 0;
                $dataset['30 dias'][$i] = 0;
                $dataset['vencido'][$i] = 0;
                $k = $i;
                $i++;
            }

            if ($dado->dias_vencimento <= 90 && $dado->dias_vencimento > 60){
                $dataset['90 dias'][$k] += 1;
            }elseif ($dado->dias_vencimento <= 60 && $dado->dias_vencimento > 30){
                $dataset['60 dias'][$k] += 1;
            }elseif ($dado->dias_vencimento <= 30 && $dado->dias_vencimento > 0){
                $dataset['30 dias'][$k] += 1;
            }elseif ($dado->dias_vencimento <= 0){
                $dataset['vencido'][$k] += 1;
            }
        }
        // dd($dados);

        $grafico->addData("90 dias", $dataset['90 dias']);
        $grafico->addData("60 dias", $dataset['60 dias']);
        $grafico->addData("30 dias", $dataset['30 dias']);
        $grafico->addData("vencido", $dataset['vencido']);

        $grafico->setXAxis($dataset['deptos']);
        $grafico->stacked = true;
        return $grafico;
    }
}
