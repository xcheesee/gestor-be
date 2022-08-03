<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class ContratadoVsExecutado
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($data)
    {
        return $this->chart->pieChart()
            ->setTitle('Contratado x Executado')
            ->setSubtitle('Valores em R$')
            ->addData($data['dados'])
            ->setLabels(['Contratado', 'Executado', 'Restante']);
    }
}
