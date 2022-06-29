<?php

namespace App\Http\Controllers;

use App\Http\Requests\AditamentoPrazoFormRequest;
use App\Models\AditamentoPrazo;
use App\Http\Resources\AditamentoPrazo as AditamentoPrazoResource;
use Illuminate\Http\Request;

/**
 * @group AditamentoPrazo
 *
 * APIs para listar, cadastrar, editar e remover dados de aditamento de prazo
 */
class AditamentoPrazoController extends Controller
{
    /**
     * Lista os aditamentos
     * @authenticated
     *
     *
     */
    public function index()
    {
        $aditamentos = AditamentoPrazo::paginate(15);
        return AditamentoPrazoResource::collection($aditamentos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Cadastra um aditamento
     * @authenticated
     *
     *
     * @bodyParam contrato_id integer required ID do contrato. Example: 5
     * @bodyParam tipo_aditamentos enum Tipo de aditamento('Prorrogação de prazo', 'Supressão de prazo', 'Suspensão', 'Rescisão'). Example: Prorrogação de prazo
     * @bodyParam dias_reajuste integer required Dias de acréscimo. Example: 60
     *
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "contrato_id": 5,
     *         "tipo_aditamentos": "Prorrogação de prazo",
     *         "dias_reajuste": 60
     *     }
     * }
     */
    public function store(AditamentoPrazoFormRequest $request)
    {
        $aditamento = new AditamentoPrazo;
        $aditamento->contrato_id = $request->input('contrato_id');
        $aditamento->tipo_aditamentos = $request->input('tipo_aditamentos');
        $aditamento->dias_reajuste = $request->input('dias_reajuste');

        if ($aditamento->save()) {
            return new AditamentoPrazoResource($aditamento);
        }
    }

    /**
     * Mostra um aditamento específico
     * @authenticated
     *
     *
     * @urlParam id integer required ID do aditamento. Example: 1
     *
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "contrato_id": 5,
     *         "tipo_aditamentos": "Acréscimo de valor",
     *         "valor_aditamento": 1000,
     *         "dias_reajuste": 60,
     *         "indice_reajuste": "Teste",
     *         "pct_reajuste": 184
     *     }
     * }
     */
    public function show($id)
    {
        $aditamento = AditamentoPrazo::findOrFail($id);
        return new AditamentoPrazoResource($aditamento);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Edita um aditamento
     * @authenticated
     *
     *
     * @urlParam id integer required ID do aditamento que deseja editar. Example: 1
     *
     * @bodyParam contrato_id integer required ID do contrato. Example: 5
     * @bodyParam tipo_aditamentos enum Tipo de aditamento('Prorrogação de prazo', 'Supressão de prazo', 'Suspensão', 'Rescisão'). Example: Prorrogação de prazo
     * @bodyParam dias_reajuste integer required Dias de acréscimo. Example: 60
     *
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "contrato_id": 5,
     *         "tipo_aditamentos": "Prorrogação de prazo",
     *         "dias_reajuste": 60
     *     }
     * }
     */
    public function update(AditamentoPrazoFormRequest $request, $id)
    {
        $aditamento = AditamentoPrazo::findOrFail($request->id);
        $aditamento->contrato_id = $request->input('contrato_id');
        $aditamento->tipo_aditamentos = $request->input('tipo_aditamentos');
        $aditamento->dias_reajuste = $request->input('dias_reajuste');

        if ($aditamento->save()) {
            return new AditamentoPrazoResource($aditamento);
        }
    }

    /**
     * Deleta um aditamento
     * @authenticated
     *
     *
     * @urlParam id integer required ID do aditamento que deseja deletar. Example: 1
     *
     * @response 200 {
     *     "message": "Aditamento deletado com sucesso!",
     *     "data": {
     *         "id": 1,
     *         "contrato_id": 5,
     *         "tipo_aditamentos": "Prorrogação de prazo",
     *         "dias_reajuste": 60
     *     }
     * }
     */
    public function destroy($id)
    {
        $aditamento = AditamentoPrazo::findOrFail($id);

        if ($aditamento->delete()) {
            return response()->json([
                'message' => 'Aditamento deletado com sucesso!',
                'data' => new AditamentoPrazoResource($aditamento)
            ]);
        }
    }

    /**
     * Lista os aditamentos pelo ID do contrato
     * @authenticated
     *
     *
     * @urlParam id integer required ID do contrato. Example: 5
     *
     * @response 200 {
     *     "data": [
     *         {
     *             "id": 5,
     *             "contrato_id": 5,
     *             "tipo_aditamentos": "Prorrogação de prazo",
     *             "dias_reajuste": 30
     *         },
     *         {
     *             "id": 6,
     *             "contrato_id": 5,
     *             "tipo_aditamentos": "Supressão de prazo",
     *             "dias_reajuste": 15
     *         },
     *         {
     *             "id": 7,
     *             "contrato_id": 5,
     *             "tipo_aditamentos": "Suspensão",
     *             "dias_reajuste": 90
     *         },
     *         {
     *             "id": 8,
     *             "contrato_id": 5,
     *             "tipo_aditamentos": "Rescisão",
     *             "dias_reajuste": 0
     *         }
     *     ]
     * }
     */
    public function listar_por_contrato($id)
    {
        $aditamentos = AditamentoPrazo::query()
            ->where('contrato_id','=',$id)
            ->get();

        return AditamentoPrazoResource::collection($aditamentos);
    }
}
