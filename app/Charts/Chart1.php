<?php

namespace App\Charts;

use App\Models\Contrato;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

//média de dias entre as etapas de contratação (de envio de material até início da vigência)
class Chart1
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($filtros): \ArielMejiaDev\LarapexCharts\PieChart
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
            ->where(function($query) use ($filtros){
                $query->where(DB::raw('YEAR(minuta_edital)'),'=',$filtros['ano_pesquisa'])
                      ->orWhere(DB::raw('YEAR(data_inicio_vigencia)'),'=',$filtros['ano_pesquisa']);
            })
            ->first();

        // dd($dados);

        $grafico = $this->chart->pieChart()
            ->setTitle('Média de dias entre as etapas do contrato')
            ->setSubtitle('Do envio de material até início da vigência - Ano de referência: '.$filtros['ano_pesquisa'])
            ->setLabels(['Envio à Minuta','Minuta à Certame','Certame à Homologação','Homologação à Início'])
            ->addData([intval($dados->envio_minuta),intval($dados->minuta_abertura),intval($dados->abertura_homol),intval($dados->homol_inicio)])
            ->setToolbar(true)
            ->setHeight(380);

        // foreach($dados as $dado){
        //     $grafico->addData([$dado->envio_minuta,$dado->minuta_abertura,$dado->abertura_homol,$dado->homol_inicio]);
        // }

        return $grafico;
    }
}

        // $dataset = array(
        //     'meses' => array('Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'),
        //     'homologacao' => array(0,0,0,0,0,0,0,0,0,0,0,0),
        //     'vigencia' => array(0,0,0,0,0,0,0,0,0,0,0,0),
        // );
        // foreach($dados as $dado){
        //     if($dado->y_homol == $filtros['ano_pesquisa']) $dataset['homologacao'][($dado->m_homol - 1)]++;
        //     if($dado->y_vigencia == $filtros['ano_pesquisa']) $dataset['vigencia'][($dado->m_vigencia - 1)]++;
        // }
        //dd($dataset);
