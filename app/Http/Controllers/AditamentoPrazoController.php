<?php

namespace App\Http\Controllers;

use App\Helpers\ContratoHelper;
use App\Http\Requests\AditamentoPrazoFormRequest;
use App\Models\AditamentoPrazo;
use App\Http\Resources\AditamentoPrazo as AditamentoPrazoResource;
use App\Models\Contrato;
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
        $aditamentos = AditamentoPrazo::get();
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
     * @bodyParam tipo_aditamento enum Tipo de aditamento('Prorrogação de prazo', 'Supressão de prazo', 'Suspensão', 'Rescisão'). Example: Prorrogação de prazo
     * @bodyParam dias_reajuste integer required Dias de acréscimo. Example: 60
     *
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "contrato_id": 5,
     *         "tipo_aditamento": "Prorrogação de prazo",
     *         "dias_reajuste": 60
     *     }
     * }
     */
    public function store(AditamentoPrazoFormRequest $request)
    {
        $aditamento = new AditamentoPrazo;
        $aditamento->contrato_id = $request->input('contrato_id');
        $aditamento->tipo_aditamento = $request->input('tipo_aditamento');
        $aditamento->dias_reajuste = $request->input('dias_reajuste');

        if ($aditamento->save()) {
            /* TODO: Verificar se Suspensão e Rescisão vão ocasionar em alteração de status do contrato. */

            //atualiza o campo de data de vencimento aditada do contrato
            $contrato = Contrato::findOrFail($aditamento->contrato_id);
            $contrato->data_vencimento_aditada = ContratoHelper::calculaDataVencimentoAditada($contrato);
            $contrato->save();


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
     *         "tipo_aditamento": "Acréscimo de valor",
     *         "dias_reajuste": 60,
     *         "percentual": 184
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
     * @bodyParam tipo_aditamento enum Tipo de aditamento('Prorrogação de prazo', 'Supressão de prazo', 'Suspensão', 'Rescisão'). Example: Prorrogação de prazo
     * @bodyParam dias_reajuste integer required Dias de acréscimo. Example: 60
     *
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "contrato_id": 5,
     *         "tipo_aditamento": "Prorrogação de prazo",
     *         "dias_reajuste": 60
     *     }
     * }
     */
    public function update(AditamentoPrazoFormRequest $request, $id)
    {
        $aditamento = AditamentoPrazo::findOrFail($request->id);
        $aditamento->contrato_id = $request->input('contrato_id');
        $aditamento->tipo_aditamento = $request->input('tipo_aditamento');
        $aditamento->dias_reajuste = $request->input('dias_reajuste');

        if ($aditamento->save()) {
            //atualiza o campo de data de vencimento aditada do contrato
            $contrato = Contrato::findOrFail($aditamento->contrato_id);
            $contrato->data_vencimento_aditada = ContratoHelper::calculaDataVencimentoAditada($contrato);
            $contrato->save();

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
     *         "tipo_aditamento": "Prorrogação de prazo",
     *         "dias_reajuste": 60
     *     }
     * }
     */
    public function destroy($id)
    {
        $aditamento = AditamentoPrazo::findOrFail($id);

        if ($aditamento->delete()) {
            //atualiza o campo de data de vencimento aditada do contrato
            $contrato = Contrato::findOrFail($aditamento->contrato_id);
            $contrato->data_vencimento_aditada = ContratoHelper::calculaDataVencimentoAditada($contrato);
            $contrato->save();

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
     *             "tipo_aditamento": "Prorrogação de prazo",
     *             "dias_reajuste": 30
     *         },
     *         {
     *             "id": 6,
     *             "contrato_id": 5,
     *             "tipo_aditamento": "Supressão de prazo",
     *             "dias_reajuste": 15
     *         },
     *         {
     *             "id": 7,
     *             "contrato_id": 5,
     *             "tipo_aditamento": "Suspensão",
     *             "dias_reajuste": 90
     *         },
     *         {
     *             "id": 8,
     *             "contrato_id": 5,
     *             "tipo_aditamento": "Rescisão",
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
