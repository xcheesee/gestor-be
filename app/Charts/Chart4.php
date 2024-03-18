<?php

namespace App\Charts;

use Illuminate\Support\Facades\DB;

class Chart4
{

    public static function build($filtros)
    {
        $eixos = $dados = array();

        $data = DB::table('servico_locais')
            ->select(DB::raw("REPLACE(REPLACE(unidade, ' ',''),'Parque','Parque ') AS local_servico"),DB::raw('SUM(valor_contrato) as t_valor_contrato'))
            ->leftJoin("contratos",'contrato_id','=','contratos.id')
            ->leftJoin("departamentos",'contratos.departamento_id','=','departamentos.id')
            ->when($filtros['departamento'], function ($query, $val) {
                return $query->where('contratos.departamento_id','=',$val);
            })
            ->when($filtros['ano_pesquisa'], function ($query, $val) {
                $query->where(function($query) use ($val){
                    $query->where(DB::raw('YEAR(minuta_edital)'),'=',$val)
                          ->orWhere(DB::raw('YEAR(data_inicio_vigencia)'),'=',$val);
                });
            })
            ->groupBy(DB::raw('local_servico'))
            ->orderBy(DB::raw('local_servico'))
            ->get();

        foreach($data as $reg){
            $eixos []= $reg->local_servico;
            //$dados []= number_format((float)($reg->t_valor_contrato ? $reg->t_valor_contrato : 0), 2, '.', '');
            $dados []= $reg->t_valor_contrato ? $reg->t_valor_contrato : 0;
        }
        // dd($dados);

        // return $this->chart->areaChart()
        //     ->setTitle('Contratos por Local - '.$filtros['ano_pesquisa'])
        //     ->setSubtitle('Valores em R$')
        //     ->setXAxis($eixos)
        //     ->addData('valores',$dados)
        //     ->setToolbar(true)
        //     ->setHeight(380)
        //     ;


        $grafico = [
            'title' => ['text' => 'Contratos por Local', 'left' => 'center'],
            'toolbox'=> [
              'show'=> true,
              'feature'=> (object)[
                'mark'=> [ 'show'=> true ],
                'dataView'=> [ 'show'=> true, 'readOnly'=> true ],
                'saveAsImage'=> [ 'show'=> true ]
              ]
            ],
            'legend'=> (object)['data'=> $eixos],
            'yAxis'=> (object)[],
            'xAxis'=> (object)['data'=> $eixos],
            'series'=> [
                (object)[
                    'name'=> 'Contratos',
                    'type'=> 'line',
                    'data'=> $dados,
                    'areaStyle'=> []
                ]
            ]
        ];

        return $grafico;
    }
}
