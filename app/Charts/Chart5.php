<?php

namespace App\Charts;

use App\Models\Contrato;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

//Empresas contratadas
class Chart5
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
            'valores'=>array(
                'aquisição' => array(),
                'obra' => array(),
                'projeto' => array(),
                'serviço' => array()
            )
        );
        $dados = Contrato::query()
            ->select(
                DB::raw('departamentos.nome as depto'),DB::raw('empresas.nome as empresa'),
                DB::raw('COUNT(*) as q_contratos'),DB::raw('SUM(valor_contrato) as t_contratado')
              )
            ->leftJoin("departamentos",'contratos.departamento_id','=','departamentos.id')
            ->leftJoin("empresas",'contratos.empresa_id','=','empresas.id')
            ->when($filtros['departamento'], function ($query, $val) {
                return $query->where('contratos.departamento_id','=',$val);
            })
            ->where(function($query) use ($filtros){
                $query->where(DB::raw('YEAR(minuta_edital)'),'=',$filtros['ano_pesquisa'])
                      ->orWhere(DB::raw('YEAR(data_inicio_vigencia)'),'=',$filtros['ano_pesquisa']);
            })
            ->whereNotNull('contratos.empresa_id')
            ->groupBy('departamentos.nome','empresas.nome')
            ->get();

        foreach($dados as $dado){
            $dataset['empresas'][] = $dado->empresa;
            $dataset['qtd'][] = $dado->q_contratos;
            $dataset['valor'][] = $dado->t_contratado;
        }
        //dd($dataset['valores']['aquisição']);

        $grafico = $this->chart->areaChart()
            ->setTitle('Contratos por Empresa.')
            ->setSubtitle('Ano de referência: '.$filtros['ano_pesquisa'])
            ->addData('Qtd', $dataset['qtd'])
            ->addData('Valor', $dataset['valor'])
            ->setXAxis($dataset['empresas'])
            ->setHeight(380);

        $grafico->altY1 = ['series'=>'Qtd','title'=>'Quantidade de Contratos'];
        $grafico->altY2 = ['series'=>'Valor','title'=>'Total Contratado'];

        return $grafico;
    }
}
