<?php

namespace App\Http\Controllers;

use App\Charts\ContratadoVsExecutado;
use App\Charts\ExecucaoPorDepartamento;
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
    public function dashboard(Request $request, ContratadoVsExecutado $chartCvE, ExecucaoPorDepartamento $chartEpD)
    {
        $mensagem = $request->session()->get('mensagem');
        $dataCvE = DB::table('execucao_financeira')
            ->select(DB::raw('SUM(contratado_inicial) as t_contratado'),DB::raw('SUM(executado) as t_executado'))
            ->where('ano','=',idate("Y"))->first();
        //dd($execucoes);
        $dataset = array('departamentos'=>array(),'valores'=>array(
            'planejado' => array(),
            'contratado' => array(),
            'empenhado' => array(),
            'executado' => array(),
            'saldo' => array(),
        ));
        $execucoes = ExecucaoFinanceira::query()->where('ano','=',idate("Y"))->get();
        $i = 0;
        foreach($execucoes as $execucao){
            $k = array_search($execucao->contrato->departamento->nome,$dataset['departamentos']);
            if($k !== false){
                $dataset['valores']['planejado'][$k] += $execucao->planejado_inicial;
                $dataset['valores']['contratado'][$k] += $execucao->contratado_atualizado;
                $dataset['valores']['empenhado'][$k] += $execucao->empenhado;
                $dataset['valores']['executado'][$k] += $execucao->executado;
                $dataset['valores']['saldo'][$k] += $execucao->saldo;
            }else{
                $dataset['departamentos'][$i] = $execucao->contrato->departamento->nome;
                $dataset['valores']['planejado'][$i] = $execucao->planejado_inicial;
                $dataset['valores']['contratado'][$i] = $execucao->contratado_atualizado;
                $dataset['valores']['empenhado'][$i] = $execucao->empenhado;
                $dataset['valores']['executado'][$i] = $execucao->executado;
                $dataset['valores']['saldo'][$i] = $execucao->saldo;
                $i++;
            }
        }
        //dd($dataset);

        $grafico = ['dados' => [$dataCvE->t_contratado,$dataCvE->t_executado,($dataCvE->t_contratado - $dataCvE->t_executado)]];

        $dataEpD = [
            'planejado' => $dataset['valores']['planejado'],
            'contratado' => $dataset['valores']['contratado'],
            'empenhado' => $dataset['valores']['empenhado'],
            'executado' => $dataset['valores']['executado'],
            'saldo' => $dataset['valores']['saldo'],
            'departamentos' => $dataset['departamentos'],
        ];

        return view('dashboard.index', [
            'mensagem'=>$mensagem,
            'chartCvE'=>$chartCvE->build($grafico),
            'chartEpD'=>$chartEpD->build($dataEpD)
        ]);
    }
}
