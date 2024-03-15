<?php

namespace App\Charts;

use App\Models\Contrato;
use Illuminate\Support\Facades\DB;

//Empresas contratadas
class Chart5
{
    public static function build($filtros)
    {
        $dataset = array(
            'empresas'=>array(),
            'qtd'=>array(),
            'valor'=>array()
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
            ->when($filtros['ano_pesquisa'], function ($query, $val) {
                $query->where(DB::raw('YEAR(minuta_edital)'),'=',$val)
                    ->orWhere(DB::raw('YEAR(data_inicio_vigencia)'),'=',$val);
            })
            ->whereNotNull('contratos.empresa_id')
            ->groupBy('departamentos.nome','empresas.nome')
            ->get();

        foreach($dados as $dado){
            $dataset['empresas'][] = substr($dado->empresa,0,15).'...'.substr($dado->empresa,-15);
            $dataset['qtd'][] = $dado->q_contratos ? $dado->q_contratos : 0;
            $dataset['valor'][] = $dado->t_contratado ? $dado->t_contratado : 0;
        }
        //dd($dataset['valores']['aquisição']);

        // $grafico = $this->chart->areaChart()
        //     ->setTitle('Contratos por Empresa.')
        //     ->setSubtitle('Ano de referência: '.$filtros['ano_pesquisa'])
        //     ->addData('Qtd', $dataset['qtd'])
        //     ->addData('Valor', $dataset['valor'])
        //     ->setXAxis($dataset['empresas'])
        //     ->setToolbar(true)
        //     ->setHeight(380);

        // $grafico->altY1 = ['series'=>'Qtd','title'=>'Quantidade de Contratos'];
        // $grafico->altY2 = ['series'=>'Valor','title'=>'Total Contratado'];

        $grafico = [
            'grid'=> ['bottom'=> 120],
            'title' => ['text' => 'Contratos por Empresa', 'left' => 'center'],
            'tooltip'=> (object)['trigger' => 'axis'],
            'toolbox'=> [
              'show'=> true,
              'feature'=> (object)[
                'mark'=> [ 'show'=> true ],
                'dataView'=> [ 'show'=> true, 'readOnly'=> true ],
                'saveAsImage'=> [ 'show'=> true ]
              ]
            ],
            'yAxis'=> [
                (object)[
                    'name'=> 'Valor',
                    'type'=> 'value',
                ],
                (object)[
                    'name'=> 'Qtd',
                    'type'=> 'value',
                ]
            ],
            'xAxis'=> (object)[
                'boundaryGap'=> false,
                'data'=> $dataset['empresas'],
                'axisLine'=> ['onZero'=> false],
                'axisLabel'=> [
                  'show'=> true,
                  'interval'=> 0,
                  'rotate'=> 45,
                  'fontSize'=> 8,
                ],
            ],
            'series'=> [
                (object)[
                    'name'=> 'Valor',
                    'type'=> 'line',
                    'data'=> $dataset['valor'],
                    'areaStyle'=> []
                ],
                (object)[
                    'name'=> 'Qtd',
                    'type'=> 'bar',
                    'data'=> $dataset['qtd'],
                    'yAxisIndex'=> 1,
                    'areaStyle'=> []
                ]
            ]
        ];

        return $grafico;
    }
}
