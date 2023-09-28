<?php

namespace App\Http\Controllers;

use App\Http\Resources\AnoDeExecResource;
use App\Models\AnoDeExecucao;
use App\Models\MesDeExecucao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExecFinanceiraController extends Controller
{
    public function indexAnoExec($id)
    {
        $anos = AnoDeExecucao::where('id_contrato', $id)->first();

        return new AnoDeExecResource($anos);
    }

    public function createAnoExec(Request $request)
    {
        $ano = new AnoDeExecucao;

        $ano->ano = $request->input('ano');
        $ano->id_contrato = $request->input('id_contrato');
        $ano->mes_inicial = $request->input('mes_inicial');
        $ano->planejado = number_format(str_replace(",",".",str_replace(".","",$request->planejado)), 2, '.', '');
        $ano->reservado = number_format(str_replace(",",".",str_replace(".","",$request->reservado)), 2, '.', '');
        $ano->contratado = number_format(str_replace(",",".",str_replace(".","",$request->contratado)), 2, '.', '');

        if($ano->save());{
            return response()->json([
                'mensagem' => 'Ano de Execução cadastrado com sucesso!', 
                'ano' => new AnoDeExecResource($ano)
            ], 202);
        }
    }

    public function indexMesExec($id) 
    {   
        $meses = MesDeExecucao::where('id_ano_exec', $id);
        
        return AnoDeExecResource::collection($meses);
    }

    //public function createMesExec(Request $request) 
    //{  
    //    $meses_execucao = $request->data[4];
    //    
    //    $meses_existentes = MesDeExecucao::where('id_ano_execucao', $request->id_ano_execucao)->get();
    //    $ultimos_mes = $meses_existentes->last();
//
    //    $contador = $ultimos_mes->mes ?? 0;
    //    foreach($meses_execucao as $valores) 
    //    {
    //        ++$contador;
    //        MesDeExecucao::where('id_ano_execucao', $request->id_ano_execucao)
    //            ->where('mes', $contador)
    //            ->update(['execucao' => $valores]);
    //        if($valores) {
    //            $mes = new MesDeExecucao;
    //
    //            $mes->id_ano_execucao = $request->id_ano_execucao;
    //            $mes->mes = $contador;
    //            $mes->execucao = $valores;
    //            $mes->save();
    //        }
    //    }
    //
    //    //$contador = $ultimos_mes->mes ?? 0;
    //    //foreach($meses_execucao as $valores) 
    //    //{
    //    //    if($valores) {
    //    //        ++$contador;
    //    //        $mes = new MesDeExecucao;
    ////
    //    //        $mes->id_ano_execucao = $request->id_ano_execucao;
    //    //        $mes->mes = $contador;
    //    //        $mes->execucao = $valores;
    //    //        $mes->save();
    //    //    }
    //    //}
    //}

    public function createMesExec(Request $request)
    {
        $meses_execucao = $request->data[4];
        
        $meses_existentes = MesDeExecucao::where('id_ano_execucao', $request->id_ano_execucao)->orderBy('mes')->get();

        $contador = 1;
        foreach ($meses_execucao as $valor) 
        {
            $mes = $meses_existentes->where('mes', $contador)->first();
            
            if ($mes) 
            {
                $mes->execucao = $valor;
                $mes->save();
            } else { 
                if ($valor != null){
                    $mes = new MesDeExecucao;
                    $mes->id_ano_execucao = $request->id_ano_execucao;
                    $mes->mes = $contador;
                    $mes->execucao = $valor;
                    $mes->save();
                }
            }   
            $contador++;
        }
    }
}
