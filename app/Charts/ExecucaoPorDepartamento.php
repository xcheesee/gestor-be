<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class ExecucaoPorDepartamento
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($dataset)
    {
        $chart = $this->chart->horizontalBarChart()
            ->setTitle('Execução Financeira por Departamento - '.date('Y'))
            ->setSubtitle('Comparativo entre os valores de planejado, contratado, empenhado e executado')
            //->setColors(['#FFC107', '#D32F2F'])
            ->addData('Planejado', $dataset['planejado'])
            ->addData('Contratado', $dataset['contratado'])
            ->addData('Empenhado', $dataset['empenhado'])
            ->addData('Executado', $dataset['executado'])
            ->addData('Saldo', $dataset['saldo'])
            ->setXAxis($dataset['departamentos'])
            ->setHeight(400);

        return $chart;
    }
}
