<?php

namespace App\Http\Controllers;

use App\Models\RecursoOrcamentario as RecursoOrcamentario;
use App\Http\Resources\RecursoOrcamentario as RecursoOrcamentarioResource;
use Illuminate\Http\Request;

/**
 * @group RecursoOrcamentario
 *
 * APIs para listar, cadastrar, editar e remover dados de recursos orçamentários de contrato
 */
class RecursoOrcamentarioController extends Controller
{
    /**
     * Lista os recursos orçamentários
     * @authenticated
     * 
     * 
     */
    public function index()
    {
        $recursoOrcamentario = RecursoOrcamentario::paginate(15);
        return RecursoOrcamentarioResource::collection($recursoOrcamentario);
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
     * Cadastra um recurso orçamentário
     * @authenticated
     * 
     * 
     * @bodyParam contrato_id integer required ID do contrato. Example: 5
     * @bodyParam nota_empenho string required Número da nota de empenho. Example: 123456
     * @bodyParam saldo_empenho float required Saldo de empenho. Example: 13
     * @bodyParam dotacao_orcamentaria string required Dotação Orçamentária. Example: 123456 
     * 
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "contrato_id": 5,
     *         "nota_empenho": "123456",
     *         "saldo_empenho": 13,
     *         "dotacao_orcamentaria": "123456"
     *     }
     * }
     */
    public function store(Request $request)
    {
        $recursoOrcamentario = new RecursoOrcamentario;
        $recursoOrcamentario->contrato_id = $request->input('contrato_id');
        $recursoOrcamentario->nota_empenho = $request->input('nota_empenho');
        $recursoOrcamentario->saldo_empenho = $request->input('saldo_empenho');
        $recursoOrcamentario->dotacao_orcamentaria = $request->input('dotacao_orcamentaria');

        if ($recursoOrcamentario->save()) {
            return new RecursoOrcamentarioResource($recursoOrcamentario);
        }
    }

    /**
     * Mostra um recurso orçamentário específico
     * @authenticated
     * 
     * 
     * @urlParam id integer required ID do recurso orçamentário. Example: 1
     * 
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "contrato_id": 5,
     *         "nota_empenho": "123456",
     *         "saldo_empenho": 13,
     *         "dotacao_empenho": "123456"
     *     }
     * }
     */
    public function show($id)
    {
        $recursoOrcamentario = RecursoOrcamentario::findOrFail($id);
        return new RecursoOrcamentarioResource($recursoOrcamentario);
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
     * Edita um recurso orçamentário
     * @authenticated 
     * 
     * 
     * @urlParam id integer required ID do recurso orçamentário que deseja editar. Example: 1
     * 
     * @bodyParam contrato_id integer required ID do contrato. Example: 5
     * @bodyParam nota_empenho string required Número da nota de empenho. Example: 123456
     * @bodyParam saldo_empenho float required Saldo de empenho. Example: 13
     * @bodyParam dotacao_empenho string required Dotação orçamentária. Example: 123456
     * 
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "contrato_id": 5,
     *         "nota_emepnho": "123456",
     *         "saldo_empenho": 13,
     *         "dotacao_empenho": "123456"
     *     }
     * }
     */
    public function update(Request $request, $id)
    {
        $recursoOrcamentario = RecursoOrcamentario::findOrFail($request->id);

        $recursoOrcamentario->contrato_id = $request->input('contrato_id');
        $recursoOrcamentario->nota_empenho = $request->input('nota_empenho');
        $recursoOrcamentario->saldo_empenho = $request->input('saldo_empenho');
        $recursoOrcamentario->dotacao_orcamentaria = $request->input('dotacao_orcamentaria');

        if ($recursoOrcamentario->save()) {
            return new RecursoOrcamentarioResource($recursoOrcamentario);
        }
    }

    /**
     * Deleta um recurso orçamentário
     * @authenticated
     * 
     * 
     * @urlParam id integer required ID do recurdo orçamentário que deseja deletar. Example: 1
     * 
     * @response 200 {
     *     "message": "Recurso orçamentário deletado com sucesso!",
     *     "data": {
     *         "id": 1,
     *         "contrato_id": 5,
     *         "nota_emepnho": "123456",
     *         "saldo_empenho": 13,
     *         "dotacao_empenho": "123456"
     *     }
     * }
     */
    public function destroy($id)
    {
        $recursoOrcamentario = RecursoOrcamentario::findOrFail($id);

        if ($recursoOrcamentario->delete()) {
            return response()->json([
                'message' => 'Recurso orçamentário deletado com sucesso!',
                'data' => new RecursoOrcamentarioResource($recursoOrcamentario)
            ]);
        }
    }

    /**
     * Lista os recursos orçamentários pelo ID do contrato
     * @authenticated
     * 
     * 
     * @urlParam id integer required ID do contrato. Example: 5
     * 
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "contrato_id": 5,
     *         "nota_empenho": "123456",
     *         "saldo_empenho": 13,
     *         "dotacao_empenho": "123456"
     *     }
     * }
     */
    public function listar_por_contrato($id)
    {
        $recursoOrcamentario = RecursoOrcamentario::query()
            ->where('contrato_id','=',$id)
            ->get();
        
        return RecursoOrcamentarioResource::collection($recursoOrcamentario);
    }
}
