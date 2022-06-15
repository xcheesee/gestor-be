<?php

namespace App\Http\Controllers;

use App\Http\Requests\AditamentoFormRequest;
use App\Models\Aditamento as Aditamento;
use App\Http\Resources\Aditamento as AditamentoResource;
use Illuminate\Http\Request;

/**
 * @group Aditamento
 *
 * APIs para listar, cadastrar, editar e remover dados de aditamento
 */
class AditamentoController extends Controller
{
    /**
     * Lista os aditamentos
     * @authenticated
     *
     *
     */
    public function index()
    {
        $aditamentos = Aditamento::paginate(15);
        return AditamentoResource::collection($aditamentos);
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
     * @bodyParam tipo_aditamentos enum Tipo de aditamento('Acréscimo de valor', 'Redução de valor', 'Prorrogação de prazo', 'Supressão de prazo', 'Suspensão', 'Rescisão'). Example: Acréscimo de valor
     * @bodyParam valor_aditamento float Valor do aditamento. Example: 1000
     * @bodyParam dias_reajuste integer required Dias de acréscimo. Example: 60
     * @bodyParam indice_reajuste float Taxa de reajuste. Example: Teste
     * @bodyParam pct_reajuste float PCT do reajuste. Example: 184
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
    public function store(AditamentoFormRequest $request)
    {
        $aditamento = new Aditamento;
        $aditamento->contrato_id = $request->input('contrato_id');
        $aditamento->tipo_aditamentos = $request->input('tipo_aditamentos');
        $aditamento->valor_aditamento = $request->input('valor_aditamento');
        $aditamento->dias_reajuste = $request->input('dias_reajuste');
        $aditamento->indice_reajuste = $request->input('indice_reajuste');
        $aditamento->pct_reajuste = $request->input('pct_reajuste');

        if ($aditamento->save()) {
            return new AditamentoResource($aditamento);
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
        $aditamento = Aditamento::findOrFail($id);
        return new AditamentoResource($aditamento);
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
     * @bodyParam contranto_id integer required ID do contrato. Example: 5
     * @bodyParam tipo_aditamentos enum Tipo de aditamento('Acréscimo de valor', 'Redução de valor', 'Prorrogação de prazo', 'Supressão de prazo', 'Suspensão', 'Rescisão'). Example: Acréscimo de valor
     * @bodyParam valor_aditamento float Valor do aditamento. Example: 1000
     * @bodyParam dias_reajuste integer required Dias de acréscimo. Example: 60
     * @bodyParam indice_reajuste float Taxa de reajuste. Example: Teste
     * @bodyParam pct_reajuste float PCT do reajuste. Example: 184
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
    public function update(Request $request, $id)
    {
        $aditamento = Aditamento::findOrFail($request->id);
        $aditamento->contrato_id = $request->input('contrato_id');
        $aditamento->tipo_aditamentos = $request->input('tipo_aditamentos');
        $aditamento->valor_aditamento = $request->input('valor_aditamento');
        $aditamento->dias_reajuste = $request->input('dias_reajuste');
        $aditamento->indice_reajuste = $request->input('indice_reajuste');
        $aditamento->pct_reajuste = $request->input('pct_reajuste');

        if ($aditamento->save()) {
            return new AditamentoResource($aditamento);
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
     *         "tipo_aditamentos": "Acréscimo de valor",
     *         "valor_aditamento": 1000,
     *         "dias_reajuste": 60,
     *         "indice_reajuste": "Teste",
     *         "pct_reajuste": 184
     *     }
     * }
     */
    public function destroy($id)
    {
        $aditamento = Aditamento::findOrFail($id);

        if ($aditamento->delete()) {
            return response()->json([
                'message' => 'Aditamento deletado com sucesso!',
                'data' => new AditamentoResource($aditamento)
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
     *             "id": 1,
     *             "contrato_id": 5,
     *             "tipo_aditamentos": "Acréscimo de valor",
     *             "valor_aditamento": 1000,
     *             "dias_reajuste": 60,
     *             "indice_reajuste": "Teste",
     *             "pct_reajuste": 184
     *         },
     *         {
     *             "id": 4,
     *             "contrato_id": 5,
     *             "tipo_aditamentos": "Redução de valor",
     *             "valor_aditamento": 1000,
     *             "dias_reajuste": 45,
     *             "indice_reajuste": "Teste",
     *             "pct_reajuste": 295
     *         },
     *         {
     *             "id": 5,
     *             "contrato_id": 5,
     *             "tipo_aditamentos": "Prorrogação de prazo",
     *             "valor_aditamento": 1000,
     *             "dias_reajuste": 30,
     *             "indice_reajuste": "Teste",
     *             "pct_reajuste": 173
     *         },
     *         {
     *             "id": 6,
     *             "contrato_id": 5,
     *             "tipo_aditamentos": "Supressão de prazo",
     *             "valor_aditamento": 1000,
     *             "dias_reajuste": 15,
     *             "indice_reajuste": "Teste",
     *             "pct_reajuste": 193
     *         },
     *         {
     *             "id": 7,
     *             "contrato_id": 5,
     *             "tipo_aditamentos": "Suspensão",
     *             "valor_aditamento": null,
     *             "dias_reajuste": 90,
     *             "indice_reajuste": null,
     *             "pct_reajuste": 145
     *         },
     *         {
     *             "id": 8,
     *             "contrato_id": 5,
     *             "tipo_aditamentos": "Rescisão",
     *             "valor_aditamento": 0,
     *             "dias_reajuste": 0,
     *             "indice_reajuste": "teste",
     *             "pct_reajuste": 131
     *         },
     *     ]
     * }
     */
    public function listar_por_contrato($id)
    {
        $aditamentos = Aditamento::query()
            ->where('contrato_id','=',$id)
            ->get();
        
        return AditamentoResource::collection($aditamentos);
    }
}
