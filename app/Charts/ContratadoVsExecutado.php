<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class ContratadoVsExecutado
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($filtros)
    {
        $dataCvE = DB::table('execucao_financeira')
            ->select(DB::raw('SUM(contratado_inicial) as t_contratado'),DB::raw('SUM(executado) as t_executado'))
            ->leftJoin("contratos",'contrato_id','=','contratos.id')
            ->leftJoin("departamentos",'contratos.departamento_id','=','departamentos.id')
            ->when($filtros['departamento'], function ($query, $val) {
                return $query->where('contratos.departamento_id','=',$val);
            })
            ->where('ano','=',$filtros['ano_pesquisa'])->first();

        $dataCvE->t_contratado = $dataCvE->t_contratado ? $dataCvE->t_contratado : 0;
        $dataCvE->t_executado = $dataCvE->t_executado ? $dataCvE->t_executado : 0;

        $grafico = ['dados' => [$dataCvE->t_contratado,$dataCvE->t_executado,($dataCvE->t_contratado - $dataCvE->t_executado)]];

        return $this->chart->pieChart()
            ->setTitle('Contratado x Executado - '.$filtros['ano_pesquisa'])
            ->setSubtitle('Valores em R$')
            ->addData($grafico['dados'])
            ->setLabels(['Contratado', 'Executado', 'Restante'])
            ->setHeight(380);
    }
}
