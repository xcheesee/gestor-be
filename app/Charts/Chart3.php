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
            ->select('contratos.id',DB::raw('DATEDIFF(data_vencimento, NOW()) AS dias_vencimento'))
            ->leftJoin("departamentos",'contratos.departamento_id','=','departamentos.id')
            ->when($filtros['departamento'], function ($query, $val) {
                return $query->where('departamento_id','=',$val);
            })
            ->whereRaw('data_vencimento IS NOT NULL')
            ->where(function($query) use ($filtros){
                $query->where(DB::raw('YEAR(minuta_edital)'),'=',$filtros['ano_pesquisa'])
                      ->orWhere(DB::raw('YEAR(data_inicio_vigencia)'),'=',$filtros['ano_pesquisa']);
            })
            ->get();

        $dataset = array(
            '90 dias' => 0,
            '60 dias' => 0,
            '30 dias' => 0,
            'vencido' => 0,
        );

        $grafico = $this->chart->barChart()
            ->setTitle('Contratos a vencer')
            ->setSubtitle('Ano de referência: '.$filtros['ano_pesquisa'])
            ->setXAxis(['90 dias','60 dias','30 dias','vencido'])
            ->setToolbar(true)
            ->setHeight(380);

        $i = 0;
        foreach($dados as $dado){
            if ($dado->dias_vencimento <= 90 && $dado->dias_vencimento > 60){
                $dataset['90 dias'] += 1;
            }elseif ($dado->dias_vencimento <= 60 && $dado->dias_vencimento > 30){
                $dataset['60 dias'] += 1;
            }elseif ($dado->dias_vencimento <= 30 && $dado->dias_vencimento > 0){
                $dataset['30 dias'] += 1;
            }elseif ($dado->dias_vencimento <= 0){
                $dataset['vencido'] += 1;
            }
        }
        // dd($dados);

        $grafico->addData("modalidades", [$dataset['90 dias'], $dataset['60 dias'], $dataset['30 dias'], $dataset['vencido']]);

        //$grafico->setXAxis($dataset['labels']);
        // $grafico->stacked = true;
        return $grafico;
    }
}
