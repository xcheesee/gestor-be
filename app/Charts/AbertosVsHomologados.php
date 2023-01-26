<?php

namespace App\Charts;

use App\Models\Contrato;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class AbertosVsHomologados
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($filtros): \ArielMejiaDev\LarapexCharts\LineChart
    {
        $dados = Contrato::query()
            ->select('contratos.id',DB::raw('MONTH(homologacao) as m_homol'),DB::raw('MONTH(data_inicio_vigencia) as m_vigencia'),
                          DB::raw('YEAR(homologacao) as y_homol'),DB::raw('YEAR(data_inicio_vigencia) as y_vigencia'))
            ->leftJoin("departamentos",'contratos.departamento_id','=','departamentos.id')
            ->when($filtros['departamento'], function ($query, $val) {
                return $query->where('contratos.departamento_id','=',$val);
            })
            ->where(DB::raw('YEAR(homologacao)'),'=',$filtros['ano_pesquisa'])
            ->orWhere(DB::raw('YEAR(data_inicio_vigencia)'),'=',$filtros['ano_pesquisa'])
            ->get();

        $dataset = array(
            'meses' => array('Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'),
            'homologacao' => array(0,0,0,0,0,0,0,0,0,0,0,0),
            'vigencia' => array(0,0,0,0,0,0,0,0,0,0,0,0),
        );
        foreach($dados as $dado){
            if($dado->y_homol == $filtros['ano_pesquisa']) $dataset['homologacao'][($dado->m_homol - 1)]++;
            if($dado->y_vigencia == $filtros['ano_pesquisa']) $dataset['vigencia'][($dado->m_vigencia - 1)]++;
        }
        //dd($dataset);

        return $this->chart->lineChart()
            ->setTitle('Contratos homologados vs Contratos em vigência.')
            ->setSubtitle('Ano de referência: '.$filtros['ano_pesquisa'])
            ->addData('homologados', $dataset['homologacao'])
            ->addData('início vigência', $dataset['vigencia'])
            ->setXAxis($dataset['meses'])
            ->setHeight(380);
    }
}
