<?php

namespace App\Http\Controllers;

use App\Charts\ContratadoVsExecutado;
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
    public function dashboard(Request $request, ContratadoVsExecutado $chartCvE)
    {
        $mensagem = $request->session()->get('mensagem');
        $contratado = DB::table('contratos')
            ->select(DB::raw('SUM(valor_contrato) as total_contratado'))
            ->where(DB::raw('YEAR(data_inicio_vigencia)'),'=',idate("Y"))->get();
        $dataCvE = DB::table('execucao_financeira')
            ->select(DB::raw('SUM(contratado_inicial) as t_contratado'),DB::raw('SUM(executado) as t_executado'))
            ->where('ano','=',idate("Y"))->first();
        //dd($execucoes);

        $grafico = ['dados' => [$dataCvE->t_contratado,$dataCvE->t_executado,($dataCvE->t_contratado - $dataCvE->t_executado)]];

        return view('dashboard.index', [
            'mensagem'=>$mensagem,
            'chartCvE'=>$chartCvE->build($grafico)
        ]);
    }
}
