<?php

namespace App\Http\Controllers;

use App\Models\GestaoContrato as GestaoContrato;
use App\Http\Resources\GestaoContrato as GestaoContratoResource;
use Illuminate\Http\Request;

/**
 * @group GestaoContrato
 *
 * APIs para listar, cadastrar, editar e remover dados de gestão de contrato
 */
class GestaoContratoController extends Controller
{
    /**
     * Lista as gestões de contratos
     * @authenticated
     * 
     * 
     */
    public function index()
    {
        $gestaoContratos = GestaoContrato::paginate(15);
        return GestaoContratoResource::collection($gestaoContratos);
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
     * Cadastra uma gestão de contrato
     * @authenticated
     * 
     * 
     * @bodyParam contrato_id integer required ID do contrato. Example: 1
     * @bodyParam gestao_fiscalizacao_id integer required ID da gestão de fiscalização: Example: 4
     * 
     * @response 200 {
     *     "data": {
     *         "id": 7,
     *         "contrato_id": 1,
     *         "gestao_fiscalizacao_id": 4
     *     }
     * }
     */
    public function store(Request $request)
    {
        $gestaoContrato = new GestaoContrato;
        $gestaoContrato->contrato_id = $request->input('contrato_id');
        $gestaoContrato->gestao_fiscalizacao_id = $request->input('gestao_fiscalizacao_id');

        if ($gestaoContrato->save()) {
            return new GestaoContratoResource($gestaoContrato);
        }
    }

    /**
     * Mostra uma gestão de contrato
     * @authenticated
     * 
     * 
     * @urlParam id integer required ID da gestão de contrato. Example: 7
     * 
     * @response 200 {
     *     "data": {
     *         "id": 7,
     *         "contrato_id": 1,
     *         "gestao_fiscalizacao_id": 4
     *     }
     * }
     */
    public function show($id)
    {
        $gestaoContrato = GestaoContrato::findOrFail($id);
        return new GestaoContratoResource($gestaoContrato);
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
     * Edita uma gestão de contrato
     * @authenticated
     * 
     * 
     * @urlParam id integer required ID da gestão de contrato que deseja editar. Example: 7
     * 
     * @bodyParam contrato_id integer required ID do contrato. Example: 1
     * @bodyParam gestao_fiscalizacao_id integer required ID da gestão de fiscalização. Example: 4
     * 
     * @response 200 {
     *     "data": {
     *         "id": 7,
     *         "contrato_id": 1,
     *         "gestao_fiscalizacao_id": 4
     *     }
     * }
     */
    public function update(Request $request, $id)
    {
        $gestaoContrato = GestaoContrato::findOrFail($request->id);
        $gestaoContrato->contrato_id = $request->input('contrato_id');
        $gestaoContrato->gestao_fiscalizacao_id = $request->input('gestao_fiscalizacao_id');

        if ($gestaoContrato->save()) {
            return new GestaoContratoResource($gestaoContrato);
        }
    }

    /**
     * Deleta uma gestão de contrato
     * @authenticated
     * 
     * 
     * @urlParam id integer required ID da gestão de contrato que deseja deletar. Example: 7
     * 
     * @response 200 {
     *     "message": "Gestão de contrato deletada com sucesso!",
     *     "data": {
     *         "id": 7,
     *         "contrato_id": 1,
     *         "gestao_fiscalizacao_id": 4
     *     }
     * }
     */
    public function destroy($id)
    {
        $gestaoContrato = GestaoContrato::findOrFail($id);

        if ($gestaoContrato->delete()) {
            return response()->json([
                'message' => 'Gestão de contrato deletada com sucesso!',
                'data' => new GestaoContratoResource($gestaoContrato)
            ]);
        }
    }

    /**
     * Lista as gestões de contrato pelo ID do contrato
     * @authenticated
     * 
     * 
     * @urlParam id integer required ID do contrato. Example: 1
     * 
     * @response 200 {
     *     "data": {
     *         "id": 7,
     *         "contrato_id": 1,
     *         "gestao_fiscalizacao_id": 4
     *     }
     * }
     */
    public function listar_por_contrato($id)
    {
        $gestaoContratos = GestaoContrato::query()
            ->where('contrato_id','=',$id)
            ->get();

        return GestaoContratoResource::collection($gestaoContratos);
    }
}
