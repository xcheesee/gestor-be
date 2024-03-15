<?php

namespace App\Charts;

use App\Models\Contrato;
use Illuminate\Support\Facades\DB;

//média de dias entre as etapas de contratação (de envio de material até início da vigência)
class Chart1
{
    public static function build($filtros)
    {
        $dados = Contrato::query()
            ->select(DB::raw('ROUND(AVG(DATEDIFF(minuta_edital,envio_material_tecnico)),0) AS envio_minuta'),
                      DB::raw('ROUND(AVG(DATEDIFF(abertura_certame,minuta_edital)),0) AS minuta_abertura'),
                      DB::raw('ROUND(AVG(DATEDIFF(homologacao,abertura_certame)),0) AS abertura_homol'),
                      DB::raw('ROUND(AVG(DATEDIFF(data_inicio_vigencia,homologacao)),0) AS homol_inicio'))
            ->leftJoin("departamentos",'contratos.departamento_id','=','departamentos.id')
            ->when($filtros['departamento'], function ($query, $val) {
                return $query->where('departamento_id','=',$val);
            })
            ->when($filtros['ano_pesquisa'], function ($query, $val) {
                $query->where(DB::raw('YEAR(minuta_edital)'),'=',$val)
                    ->orWhere(DB::raw('YEAR(data_inicio_vigencia)'),'=',$val);
            })
            ->where('contratos.ativo','=','1')
            ->first();

        // dd($dados);

        $grafico = [
            'title' => ['text' => 'Média de dias entre as etapas do contrato', 'subtext' => 'Do envio de material até início da vigência', 'left' => 'center'],
            'tooltip'=> (object)['trigger' => 'item'],
            'toolbox'=> [
              'show'=> true,
              'feature'=> (object)[
                'mark'=> [ 'show'=> true ],
                'dataView'=> [ 'show'=> true, 'readOnly'=> true ],
                'saveAsImage'=> [ 'show'=> true ]
              ]
            ],
            'series'=> [
                (object)[
                    'name'=> 'Etapa do Contrato',
                    'type'=> 'pie',
                    'data'=> [
                        (object)['value'=>intval($dados->envio_minuta), 'name'=>'Envio à Minuta'],
                        (object)['value'=>intval($dados->minuta_abertura), 'name'=>'Minuta à Certame'],
                        (object)['value'=>intval($dados->abertura_homol), 'name'=>'Certame à Homologação'],
                        (object)['value'=>intval($dados->homol_inicio), 'name'=>'Homologação à Início']
                    ]
                ]
            ],
            'roseType'=>'area'
        ];

        return $grafico;
    }
}
