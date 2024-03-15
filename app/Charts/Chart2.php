<?php

namespace App\Charts;

use App\Models\Contrato;
use App\Models\ExecucaoFinanceira;
use Illuminate\Support\Facades\DB;

//média do tempo gasto para avançar o contrato
//TODO: podemos criar stacked bar para este caso, usando as categorias como eixo X e os modelos de licitação como serie
class Chart2
{
    public static function build($filtros)
    {
        $dados = Contrato::query()
            ->select('licitacao_modelo_id','licitacao_modelos.nome as label',
                      DB::raw('ROUND(AVG(DATEDIFF(data_inicio_vigencia,envio_material_tecnico)),0) AS dias'))
            ->leftJoin("departamentos",'contratos.departamento_id','=','departamentos.id')
            ->leftJoin("licitacao_modelos",'contratos.licitacao_modelo_id','=','licitacao_modelos.id')
            ->when($filtros['departamento'], function ($query, $val) {
                return $query->where('departamento_id','=',$val);
            })
            ->whereRaw('licitacao_modelo_id IS NOT NULL')
            ->when($filtros['ano_pesquisa'], function ($query, $val) {
                $query->where(DB::raw('YEAR(minuta_edital)'),'=',$val)
                    ->orWhere(DB::raw('YEAR(data_inicio_vigencia)'),'=',$val);
            })
            ->where('contratos.ativo','=','1')
            ->groupBy('licitacao_modelo_id','licitacao_modelos.nome')
            ->get();

        $dataset = array(
            'labels' => array(),
            'valores' => array(),
        );
        foreach($dados as $dado){
            if (!in_array($dado->label,$dataset['labels'])) $dataset['labels'][]=$dado->label;
            $dataset['valores'][] = $dado->dias;
        }
        // dd($dataset);

        $grafico = [
            'title' => ['text' => 'Média de dias gastos na contratação', 'left' => 'center'],
            'tooltip'=> (object)['trigger' => 'item'],
            'toolbox'=> [
              'show'=> true,
              'feature'=> (object)[
                'mark'=> [ 'show'=> true ],
                'dataView'=> [ 'show'=> true, 'readOnly'=> true ],
                'saveAsImage'=> [ 'show'=> true ]
              ]
            ],
            'legend'=> [
                'data'=> $dataset['labels']
            ],
            'xAxis'=> (object)[
                'data'=> $dataset['labels']
            ],
            'yAxis'=> (object)[],
            'series'=> [
                (object)[
                    'name'=> 'Dias',
                    'type'=> 'bar',
                    'data'=> $dataset['valores']
                ]
            ]
        ];

        // $grafico = $this->chart->horizontalBarChart()
        //     ->setTitle('Média de dias gastos na contratação')
        //     ->setSubtitle('Ano de referência: '.$filtros['ano_pesquisa'])
        //     ->setHeight(380)
        //     ->setToolbar(true,true);
        // foreach($dados as $dado){
        //     if (!in_array($dado->label,$dataset['labels'])) $dataset['labels'][]=$dado->label;
        //     $dataset['valores'][$dado->label] = [$dado->dias];
        //     $grafico->addData($dado->label, $dataset['valores'][$dado->label]);
        // }
        // $grafico->setXAxis($dataset['labels']);


        return $grafico;
    }
}
