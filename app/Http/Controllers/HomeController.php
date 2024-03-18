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
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $mensagem = $request->session()->get('mensagem');
        return view('home', compact('mensagem'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function admin(Request $request)
    {
        $mensagem = $request->session()->get('mensagem');
        return view('admin', compact('mensagem'));
    }

    /**
     * Show cadaux index.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function cadaux(Request $request)
    {
        $mensagem = $request->session()->get('mensagem');
        return view('cadaux.index', compact('mensagem'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard(Request $request)
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

        return view('dashboard.index', [
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
}
