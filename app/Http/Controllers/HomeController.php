<?php

namespace App\Http\Controllers;

use App\Charts\ContratadoVsExecutado;
use App\Charts\ExecucaoPorDepartamento;
use App\Charts\ValoresPorTipoObjetoChart;
use App\Models\Departamento;
use App\Models\ExecucaoFinanceira;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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
    public function dashboard(Request $request,
        ContratadoVsExecutado $chartCvE, ExecucaoPorDepartamento $chartEpD, ValoresPorTipoObjetoChart $chartVtO
    )
    {
        //dd($request);
        $filtros = array();
        $filtros['ano_pesquisa'] = $request->query('f-ano_pesquisa');
        $filtros['departamento'] = $request->query('f-departamento');
        if(!$filtros['ano_pesquisa']) $filtros['ano_pesquisa'] = idate("Y");
        $departamentos = Departamento::pluck('nome', 'id')->all();

        $mensagem = $request->session()->get('mensagem');
        //dd($execucoes);

        return view('dashboard.index', [
            'mensagem'=>$mensagem,
            'filtros' => $filtros,
            'departamentos' => $departamentos,
            'chartCvE'=>$chartCvE->build($filtros),
            'chartEpD'=>$chartEpD->build($filtros),
            'chartVtO'=>$chartVtO->build($filtros)
        ]);
    }
}
