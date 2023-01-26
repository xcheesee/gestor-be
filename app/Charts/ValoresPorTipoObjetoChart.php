<?php

namespace App\Charts;

use App\Models\Contrato;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class ValoresPorTipoObjetoChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($filtros): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $dataset = array(
            'departamentos'=>array(),
            'valores'=>array(
                'aquisição' => array(),
                'obra' => array(),
                'projeto' => array(),
                'serviço' => array()
            )
        );
        $dados = Contrato::query()
            ->select('departamento_id','tipo_objeto',DB::raw('SUM(valor_contrato) as t_contratado'))
            ->leftJoin("departamentos",'contratos.departamento_id','=','departamentos.id')
            ->when($filtros['departamento'], function ($query, $val) {
                return $query->where('contratos.departamento_id','=',$val);
            })
            ->where(DB::raw('YEAR(data_inicio_vigencia)'),'=',$filtros['ano_pesquisa'])
            ->groupBy('departamento_id','tipo_objeto')
            ->get();

        $i = 0;
        foreach($dados as $dado){
            $k = array_search($dado->departamento->nome,$dataset['departamentos']);
            if($k !== false){
                $dataset['valores'][$dado->tipo_objeto][$k] += $dado->t_contratado;
            }else{
                $dataset['departamentos'][$i] = $dado->departamento->nome;
                foreach($dataset['valores'] as $k=>$valor){
                    $dataset['valores'][$k][$i] = 0;
                }
                $dataset['valores'][$dado->tipo_objeto][$i] += $dado->t_contratado;
                $i++;
            }
        }
        //dd($dataset['valores']['aquisição']);

        return $this->chart->barChart()
            ->setTitle('Valores Contratados por Tipo de Objeto.')
            ->setSubtitle('Ano de referência: '.$filtros['ano_pesquisa'])
            ->addData('Aquisição', $dataset['valores']['aquisição'])
            ->addData('Obra', $dataset['valores']['obra'])
            ->addData('Projeto', $dataset['valores']['projeto'])
            ->addData('Serviço', $dataset['valores']['serviço'])
            ->setXAxis($dataset['departamentos'])
            ->setHeight(380);
    }
}
