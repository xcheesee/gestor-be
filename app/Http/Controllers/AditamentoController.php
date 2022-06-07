<?php

namespace App\Http\Controllers;

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
     * @bodyParam contranto_id integer required ID do contrato. Example: 5
     * @bodyParam tipo_aditamentos enum Tipo de aditamento('Acréscimo de valor', 'Redução de valor', 'Prorrogação de prazo', 'Supressão de prazo', 'Suspensão', 'Rescisão'). Example: Acréscimo de valor
     * @bodyParam valor_aditamento float Valor do aditamento. Example: 1000
     * @bodyParam data_fim_vigencia_atualizada date Data do fim da vigência atualizada. Example: 2001-08-14
     * @bodyParam indice_reajuste float Taxa de reajuste. Example: 10
     * @bodyParam data_base_reajuste date Data base do reajuste. Example: 2001-08-14
     * @bodyParam valor_reajustado float Valor que foi reajustado. Example: 1010
     * 
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "contrato_id": 5,
     *         "tipo_aditamentos": "Acréscimo de valor",
     *         "valor_aditamento": 1000,
     *         "data_fim_vigencia_atualizada": "2001-08-14",
     *         "indice_reajuste": 10,
     *         "data_base_reajuste": "2001-08-14",
     *         "valor_reajustado": 1010
     *     }
     * }
     */
    public function store(Request $request)
    {
        $aditamento = new Aditamento;
        $aditamento->contrato_id = $request->input('contrato_id');
        $aditamento->tipo_aditamentos = $request->input('tipo_aditamentos');
        $aditamento->valor_aditamento = $request->input('valor_aditamento');
        $aditamento->data_fim_vigencia_atualizada = $request->input('data_fim_vigencia_atualizada');
        $aditamento->indice_reajuste = $request->input('indice_reajuste');
        $aditamento->data_base_reajuste = $request->input('data_base_reajuste');
        $aditamento->valor_reajustado = $request->input('valor_reajustado');

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
     *         "data_fim_vigencia_atualizada": "2001-08-14",
     *         "indice_reajuste": 10,
     *         "data_base_reajuste": "2001-08-14",
     *         "valor_reajustado": 1010
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
     * @bodyParam data_fim_vigencia_atualizada date Data do fim da vigência atualizada. Example: 2001-08-14
     * @bodyParam indice_reajuste float Taxa de reajuste. Example: 10
     * @bodyParam data_base_reajuste date Data base do reajuste. Example: 2001-08-14
     * @bodyParam valor_reajustado float Valor que foi reajustado. Example: 1010
     * 
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "contrato_id": 5,
     *         "tipo_aditamentos": "Acréscimo de valor",
     *         "valor_aditamento": 1000,
     *         "data_fim_vigencia_atualizada": "2001-08-14",
     *         "indice_reajuste": 10,
     *         "data_base_reajuste": "2001-08-14",
     *         "valor_reajustado": 1010
     *     }
     * }
     */
    public function update(Request $request, $id)
    {
        $aditamento = Aditamento::findOrFail($request->id);
        $aditamento->contrato_id = $request->input('contrato_id');
        $aditamento->tipo_aditamentos = $request->input('tipo_aditamentos');
        $aditamento->valor_aditamento = $request->input('valor_aditamento');
        $aditamento->data_fim_vigencia_atualizada = $request->input('data_fim_vigencia_atualizada');
        $aditamento->indice_reajuste = $request->input('indice_reajuste');
        $aditamento->data_base_reajuste = $request->input('data_base_reajuste');
        $aditamento->valor_reajustado = $request->input('valor_reajustado');

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
     *         "data_fim_vigencia_atualizada": "2001-08-14",
     *         "indice_reajuste": 10,
     *         "data_base_reajuste": "2001-08-14",
     *         "valor_reajustado": 1010
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
     *             "data_fim_vigencia_atualizada": "2001-08-14",
     *             "indice_reajuste": 10,
     *             "data_base_reajuste": "2001-08-14",
     *             "valor_reajustado": 1010
     *         },
     *         {
     *             "id": 4,
     *             "contrato_id": 5,
     *             "tipo_aditamentos": "Redução de valor",
     *             "valor_aditamento": 1000,
     *             "data_fim_vigencia_atualizada": "2001-08-14",
     *             "indice_reajuste": 10,
     *             "data_base_reajuste": "2001-08-14",
     *             "valor_reajustado": 990
     *         },
     *         {
     *             "id": 5,
     *             "contrato_id": 5,
     *             "tipo_aditamentos": "Prorrogação de prazo",
     *             "valor_aditamento": 1000,
     *             "data_fim_vigencia_atualizada": "2022-05-01",
     *             "indice_reajuste": 10,
     *             "data_base_reajuste": "2022-05-05",
     *             "valor_reajustado": 1000
     *         },
     *         {
     *             "id": 6,
     *             "contrato_id": 5,
     *             "tipo_aditamentos": "Supressão de prazo",
     *             "valor_aditamento": 1000,
     *             "data_fim_vigencia_atualizada": null,
     *             "indice_reajuste": 10,
     *             "data_base_reajuste": null,
     *             "valor_reajustado": 1000
     *         },
     *         {
     *             "id": 7,
     *             "contrato_id": 5,
     *             "tipo_aditamentos": "Suspensão",
     *             "valor_aditamento": null,
     *             "data_fim_vigencia_atualizada": null,
     *             "indice_reajuste": null,
     *             "data_base_reajuste": null,
     *             "valor_reajustado": null
     *         },
     *         {
     *             "id": 8,
     *             "contrato_id": 5,
     *             "tipo_aditamentos": "Rescisão",
     *             "valor_aditamento": 0,
     *             "data_fim_vigencia_atualizada": "2022-05-01",
     *             "indice_reajuste": 0,
     *             "data_base_reajuste": "2022-05-01",
     *             "valor_reajustado": 0
     *         }
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
