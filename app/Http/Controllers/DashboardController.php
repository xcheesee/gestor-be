<?php

namespace App\Http\Controllers;

use App\Charts\Chart1;
use App\Charts\Chart2;
use App\Charts\Chart3;
use App\Charts\Chart4;
use App\Charts\Chart5;
use App\Helpers\ContratoHelper;
use App\Models\Departamento;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard_geral(Request $request)
    {
        //dd($request);
        $filtros = array();
        $filtros['ano_pesquisa'] = $request->query('f-ano_pesquisa');
        $filtros['departamento'] = $request->query('f-departamento');
        //if(!$filtros['ano_pesquisa']) $filtros['ano_pesquisa'] = idate("Y");
        $departamentos = Departamento::pluck('nome', 'id')->all();

        //contar totais de: contratos no sistema, contratos em homologação, contratos iniciados, e contratos vencidos
        $contratos['ativos'] = ContratoHelper::contador($filtros,'ativos');
        $contratos['venc90'] = ContratoHelper::contador($filtros,'venc90');
        $contratos['venc30'] = ContratoHelper::contador($filtros,'venc30');
        $contratos['vencidos'] = ContratoHelper::contador($filtros,'vencidos');
        $contratos['iniciados'] = ContratoHelper::contador($filtros,'iniciados');
        $contratos['recentes'] = ContratoHelper::contador($filtros,'recentes');
        $contratos['finalizados'] = ContratoHelper::contador($filtros,'finalizados');

        $mensagem = $request->session()->get('mensagem');

        return view('dashboard.geral', [
            'mensagem'=>$mensagem,
            'filtros' => $filtros,
            'contratos' => $contratos,
            'departamentos' => $departamentos,
            'chart1'=>Chart1::build($filtros),
            'chart2'=>Chart2::build($filtros),
            'chart3'=>Chart3::build($filtros),
            'chart4'=>Chart4::build($filtros),
            'chart5'=>Chart5::build($filtros)
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard_empresas(Request $request)
    {
        //dd($request);
        $filtros = array();
        $filtros['ano_pesquisa'] = $request->query('f-ano_pesquisa');
        $filtros['departamento'] = $request->query('f-departamento');
        //if(!$filtros['ano_pesquisa']) $filtros['ano_pesquisa'] = idate("Y");
        $departamentos = Departamento::pluck('nome', 'id')->all();

        //contar totais de: contratos no sistema, contratos em homologação, contratos iniciados, e contratos vencidos
        $contratos['empresas'] = ContratoHelper::contador($filtros,'ativos');

        $mensagem = $request->session()->get('mensagem');

        return view('dashboard.empresas', [
            'mensagem'=>$mensagem,
            'filtros' => $filtros,
            'contratos' => $contratos,
            'departamentos' => $departamentos,
            'chart5'=>Chart5::build($filtros)
        ]);
    }
}
