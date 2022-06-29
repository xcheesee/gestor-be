<?php

namespace App\Http\Controllers;

use App\Http\Requests\AditamentoValorFormRequest;
use App\Models\AditamentoValor as AditamentoValor;
use App\Http\Resources\AditamentoValor as AditamentoValorResource;
use Illuminate\Http\Request;

/**
 * @group AditamentoValor
 *
 * APIs para listar, cadastrar, editar e remover dados de aditamento de valor
 */
class AditamentoValorController extends Controller
{
    /**
     * Lista os aditamentos
     * @authenticated
     *
     *
     */
    public function index()
    {
        $aditamentos = AditamentoValor::paginate(15);
        return AditamentoValorResource::collection($aditamentos);
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
     * @bodyParam tipo_aditamentos enum Tipo de aditamento('Acréscimo de valor', 'Redução de valor'). Example: Acréscimo de valor
     * @bodyParam valor_aditamento float Valor do aditamento. Example: 1000.00
     * @bodyParam indice_reajuste float Taxa de reajuste. Example: Teste
     * @bodyParam pct_reajuste float PCT do reajuste. Example: 18.4
     *
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "contrato_id": 5,
     *         "tipo_aditamentos": "Acréscimo de valor",
     *         "valor_aditamento": 1000.00,
     *         "indice_reajuste": "Teste",
     *         "pct_reajuste": 18.4
     *     }
     * }
     */
    public function store(AditamentoValorFormRequest $request)
    {
        $aditamento = new AditamentoValor;
        $aditamento->contrato_id = $request->input('contrato_id');
        $aditamento->tipo_aditamentos = $request->input('tipo_aditamentos');
        $aditamento->valor_aditamento = $request->input('valor_aditamento');
        $aditamento->indice_reajuste = $request->input('indice_reajuste');
        $aditamento->pct_reajuste = $request->input('pct_reajuste');

        if ($aditamento->save()) {
            return new AditamentoValorResource($aditamento);
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
     *         "indice_reajuste": "Teste",
     *         "pct_reajuste": 184
     *     }
     * }
     */
    public function show($id)
    {
        $aditamento = AditamentoValor::findOrFail($id);
        return new AditamentoValorResource($aditamento);
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
     * @bodyParam indice_reajuste float Taxa de reajuste. Example: Teste
     * @bodyParam pct_reajuste float PCT do reajuste. Example: 184
     *
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "contrato_id": 5,
     *         "tipo_aditamentos": "Acréscimo de valor",
     *         "valor_aditamento": 1000,
     *         "indice_reajuste": "Teste",
     *         "pct_reajuste": 184
     *     }
     * }
     */
    public function update(AditamentoValorFormRequest $request, $id)
    {
        $aditamento = AditamentoValor::findOrFail($request->id);
        $aditamento->contrato_id = $request->input('contrato_id');
        $aditamento->tipo_aditamentos = $request->input('tipo_aditamentos');
        $aditamento->valor_aditamento = $request->input('valor_aditamento');
        $aditamento->indice_reajuste = $request->input('indice_reajuste');
        $aditamento->pct_reajuste = $request->input('pct_reajuste');

        if ($aditamento->save()) {
            return new AditamentoValorResource($aditamento);
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
        $aditamento = AditamentoValor::findOrFail($id);

        if ($aditamento->delete()) {
            return response()->json([
                'message' => 'Aditamento deletado com sucesso!',
                'data' => new AditamentoValorResource($aditamento)
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
     *             "indice_reajuste": "Teste",
     *             "pct_reajuste": 184
     *         },
     *         {
     *             "id": 4,
     *             "contrato_id": 5,
     *             "tipo_aditamentos": "Redução de valor",
     *             "valor_aditamento": 1000,
     *             "indice_reajuste": "Teste",
     *             "pct_reajuste": 295
     *         }
     *     ]
     * }
     */
    public function listar_por_contrato($id)
    {
        $aditamentos = AditamentoValor::query()
            ->where('contrato_id','=',$id)
            ->get();

        return AditamentoValorResource::collection($aditamentos);
    }
}
