<?php

namespace App\Charts;

use App\Models\ExecucaoFinanceira;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class ExecucaoPorDepartamento
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($filtros)
    {
        $dataset = array('departamentos'=>array(),'valores'=>array(
            'planejado' => array(),
            'contratado' => array(),
            'empenhado' => array(),
            'executado' => array(),
            'saldo' => array(),
        ));
        $execucoes = ExecucaoFinanceira::query()
            ->select('execucao_financeira.*')
            ->leftJoin("contratos",'contrato_id','=','contratos.id')
            ->leftJoin("departamentos",'contratos.departamento_id','=','departamentos.id')
            ->when($filtros['departamento'], function ($query, $val) {
                return $query->where('contratos.departamento_id','=',$val);
            })
            ->where('ano','=',$filtros['ano_pesquisa'])
            ->get();

        $i = 0;
        foreach($execucoes as $execucao){
            $k = array_search($execucao->contrato->departamento->nome,$dataset['departamentos']);
            if($k !== false){
                $dataset['valores']['planejado'][$k] += round($execucao->planejado_inicial);
                $dataset['valores']['contratado'][$k] += round($execucao->contratado_atualizado);
                $dataset['valores']['empenhado'][$k] += round($execucao->empenhado);
                $dataset['valores']['executado'][$k] += round($execucao->executado);
                $dataset['valores']['saldo'][$k] += round($execucao->saldo);
            }else{
                $dataset['departamentos'][$i] = $execucao->contrato->departamento->nome;
                $dataset['valores']['planejado'][$i] = round($execucao->planejado_inicial);
                $dataset['valores']['contratado'][$i] = round($execucao->contratado_atualizado);
                $dataset['valores']['empenhado'][$i] = round($execucao->empenhado);
                $dataset['valores']['executado'][$i] = round($execucao->executado);
                $dataset['valores']['saldo'][$i] = round($execucao->saldo);
                $i++;
            }
        }
        //dd($dataCvE->t_executado);

        $dataEpD = [
            'planejado' => $dataset['valores']['planejado'],
            'contratado' => $dataset['valores']['contratado'],
            'empenhado' => $dataset['valores']['empenhado'],
            'executado' => $dataset['valores']['executado'],
            'saldo' => $dataset['valores']['saldo'],
            'departamentos' => $dataset['departamentos'],
        ];

        $chart = $this->chart->horizontalBarChart()
            ->setTitle('Execução Financeira por Departamento - '.$filtros['ano_pesquisa'])
            ->setSubtitle('Comparativo entre os valores de planejado, contratado, empenhado e executado')
            //->setColors(['#FFC107', '#D32F2F'])
            ->addData('Planejado', $dataEpD['planejado'])
            ->addData('Contratado', $dataEpD['contratado'])
            ->addData('Empenhado', $dataEpD['empenhado'])
            ->addData('Executado', $dataEpD['executado'])
            ->addData('Saldo', $dataEpD['saldo'])
            ->setXAxis($dataEpD['departamentos'])
            ->setHeight(380);

        return $chart;
    }
}
