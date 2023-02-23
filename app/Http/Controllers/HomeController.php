<?php

namespace App\Http\Controllers;

use App\Charts\Chart1;
use App\Charts\Chart2;
use App\Charts\Chart3;
use App\Charts\Chart4;
use App\Charts\Chart5;
use App\Models\Departamento;
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
        Chart1 $chart1, Chart2 $chart2, Chart3 $chart3,
        Chart4 $chart4, Chart5 $chart5
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

        $dataset_chart6 = "{
            name: 'PRODUCT A',
            data: [44, 55, 41, 67, 22, 43]
          }, {
            name: 'PRODUCT B',
            data: [13, 23, 20, 8, 13, 27]
          }, {
            name: 'PRODUCT C',
            data: [11, 17, 15, 15, 21, 14]
          }, {
            name: 'PRODUCT D',
            data: [21, 7, 25, 13, 22, 8]
          }
        ";

        return view('dashboard.index', [
            'mensagem'=>$mensagem,
            'filtros' => $filtros,
            'departamentos' => $departamentos,
            'chart1'=>$chart1->build($filtros),
            'chart2'=>$chart2->build($filtros),
            'chart3'=>$chart3->build($filtros),
            'chart4'=>$chart4->build($filtros),
            'chart5'=>$chart5->build($filtros),
            'dataset_chart6'=>$dataset_chart6
        ]);
    }
}
