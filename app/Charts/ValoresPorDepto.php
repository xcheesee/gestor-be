<?php

namespace App\Charts;

use App\Models\Contrato;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class ValoresPorDepto
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($filtros)
    {
        $dataset = array(
            'departamentos'=>array(),
            'valores'=>array()
        );
        $dados = Contrato::query()
            ->select('departamento_id',DB::raw('SUM(valor_contrato) as t_contratado'))
            ->leftJoin("departamentos",'contratos.departamento_id','=','departamentos.id')
            ->when($filtros['departamento'], function ($query, $val) {
                return $query->where('contratos.departamento_id','=',$val);
            })
            ->where(DB::raw('YEAR(data_inicio_vigencia)'),'=',$filtros['ano_pesquisa'])
            ->groupBy('departamento_id')
            ->get();

        $i = 0;
        foreach($dados as $dado){
            $k = array_search($dado->departamento->nome,$dataset['departamentos']);
            if($k !== false){
                $dataset['valores'][$k] = round($dado->t_contratado,2);
            }else{
                $dataset['departamentos'][$i] = $dado->departamento->nome;
                $dataset['valores'][$i] = round($dado->t_contratado,2);
                $i++;
            }
        }
        //dd($dataset);

        return $this->chart->areaChart()
            ->setTitle('Valores Contratados por Departamento.')
            ->setSubtitle('Ano de referência: '.$filtros['ano_pesquisa'])
            ->addData('Valor Contratado', $dataset['valores'])
            ->setLabels($dataset['departamentos'])
            ->setHeight(380);
    }
}
