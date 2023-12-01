<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class Chart4
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($filtros)
    {
        $eixos = $dados = array();

        $data = DB::table('servico_locais')
            ->select(DB::raw("REPLACE(REPLACE(unidade, ' ',''),'Parque','Parque ') AS local_servico"),DB::raw('SUM(valor_contrato) as t_valor_contrato'))
            ->leftJoin("contratos",'contrato_id','=','contratos.id')
            ->leftJoin("departamentos",'contratos.departamento_id','=','departamentos.id')
            ->when($filtros['departamento'], function ($query, $val) {
                return $query->where('contratos.departamento_id','=',$val);
            })
            ->where(function($query) use ($filtros){
                $query->where(DB::raw('YEAR(minuta_edital)'),'=',$filtros['ano_pesquisa'])
                      ->orWhere(DB::raw('YEAR(data_inicio_vigencia)'),'=',$filtros['ano_pesquisa']);
            })
            ->groupBy(DB::raw('local_servico'))
            ->orderBy(DB::raw('local_servico'))
            ->get();

        foreach($data as $reg){
            $eixos []= $reg->local_servico;
            $dados []= $reg->t_valor_contrato;
        }
        //dd($eixos);

        return $this->chart->areaChart()
            ->setTitle('Contratos por Local - '.$filtros['ano_pesquisa'])
            ->setSubtitle('Valores em R$')
            ->setXAxis($eixos)
            ->addData('valores',$dados)
            ->setToolbar(true)
            ->setHeight(380)
            ;
    }
}
