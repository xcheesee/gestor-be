<?php

namespace App\Charts;

use App\Models\Contrato;
use App\Models\ExecucaoFinanceira;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

//média do tempo gasto para avançar o contrato
class Chart2
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($filtros)
    {
        $dados = Contrato::query()
            ->select('departamento_id','departamentos.nome as depto',
                      DB::raw('ROUND(AVG(DATEDIFF(data_inicio_vigencia,envio_material_tecnico)),0) AS dias'))
            ->leftJoin("departamentos",'contratos.departamento_id','=','departamentos.id')
            ->when($filtros['departamento'], function ($query, $val) {
                return $query->where('departamento_id','=',$val);
            })
            ->where(function($query) use ($filtros){
                $query->where(DB::raw('YEAR(minuta_edital)'),'=',$filtros['ano_pesquisa'])
                      ->orWhere(DB::raw('YEAR(data_inicio_vigencia)'),'=',$filtros['ano_pesquisa']);
            })
            ->groupBy('departamento_id','departamentos.nome')
            ->get();

        $dataset = array(
            'deptos' => array(),
            'valores' => array(),
        );

        $grafico = $this->chart->horizontalBarChart()
            ->setTitle('Média de dias gastos até o início do contrato')
            ->setSubtitle('Ano de referência: '.$filtros['ano_pesquisa'])
            ->setHeight(380)
            ->setToolbar(true,true);

        foreach($dados as $dado){
            if (!in_array($dado->depto,$dataset['deptos'])) $dataset['deptos'][]=$dado->depto;
            $dataset['valores'][$dado->depto] = [$dado->dias];
            $grafico->addData($dado->depto, $dataset['valores'][$dado->depto]);
        }

        $grafico->setXAxis($dataset['deptos']);
        return $grafico;

        // $chart = $this->chart->horizontalBarChart()
        //     ->setTitle('Execução Financeira por Departamento - '.$filtros['ano_pesquisa'])
        //     ->setSubtitle('Comparativo entre os valores de planejado, contratado, empenhado e executado')
        //     //->setColors(['#FFC107', '#D32F2F'])
        //     ->addData('Planejado', $dataEpD['planejado'])
        //     ->addData('Contratado', $dataEpD['contratado'])
        //     ->addData('Empenhado', $dataEpD['empenhado'])
        //     ->addData('Executado', $dataEpD['executado'])
        //     ->addData('Saldo', $dataEpD['saldo'])
        //     ->setXAxis($dataEpD['departamentos'])
        //     ->setHeight(380);

        // return $chart;
    }
}
