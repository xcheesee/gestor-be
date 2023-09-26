<?php

namespace App\Http\Controllers;

use App\Http\Resources\AnoDeExecResource;
use App\Models\AnoDeExecucao;
use Illuminate\Http\Request;

class ExecFinanceiraController extends Controller
{
    public function indexAnoExec()
    {
        $anos = AnoDeExecucao::all();
        return AnoDeExecResource::collection($anos);
    }

    public function createAnoExec(Request $request)
    {
        $ano = new AnoDeExecucao;

        $ano->ano = $request->input('ano');
        $ano->id_contrato = $request->input('id_contrato');
        $ano->planejado = $request->input('planejado');
        $ano->reservado = $request->input('reservado');
        $ano->contratado = $request->input('contratado');

        if($ano->save());{
            return response()->json([
                'mensagem' => 'Ano de Execução cadastrado com sucesso!', 
                'ano' => new AnoDeExecResource($ano)
            ], 202);
        }
    }

    public function searchAnoExec($id) 
    {
        $ano = AnoDeExecucao::find($id);
        if($ano){
            return new AnoDeExecResource($ano);
        }
        return response()->json([
            'mensagem' => 'Ano de Execução não encontrado!'
        ]);
    }


}
