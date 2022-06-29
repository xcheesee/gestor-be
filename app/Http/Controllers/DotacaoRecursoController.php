<?php

namespace App\Http\Controllers;

use App\Models\DotacaoRecurso;
use App\Http\Requests\DotacaoRecursoFormRequest;
use App\Http\Resources\DotacaoRecurso as DotacaoRecursoResource;

/**
 * @group DotacaoRecurso
 *
 * APIs para listar, cadastrar, editar e remover relacionamentos entre dotações e origem de recursos
 */
class DotacaoRecursoController extends Controller
{
    /**
     * Lista as relações dotação x origem recurso
     * @authenticated
     *
     *
     */
    public function index()
    {
        $dotacaos = DotacaoRecurso::paginate(15);
        return DotacaoRecursoResource::collection($dotacaos);
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
     * Cadastra uma relação dotação x origem recurso
     * @authenticated
     *
     *
     * @bodyParam dotacao_id integer required ID do tipo de dotação (tabela dotacao_tipos). Example: 1
     * @bodyParam origem_recurso_id integer ID da origem do recurso. Example: 2
     * @bodyParam outros_descricao string Descrição em texto da origem quando for selecionado "outro" (não terá um ID específico nesse caso). Example: "Fonte teste"
     *
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "dotacao_id": 1,
     *         "origem_recurso_id": 2,
     *         "outros_descricao": null
     *     }
     * }
     *
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "dotacao_id": 1,
     *         "origem_recurso_id": null,
     *         "outros_descricao": "Fonte teste"
     *     }
     * }
     *
     */
    public function store(DotacaoRecursoFormRequest $request)
    {
        $dotacao = new DotacaoRecurso;
        $dotacao->dotacao_id = $request->input('dotacao_id');
        $dotacao->origem_recurso_id = $request->input('origem_recurso_id');
        $dotacao->outros_descricao = $request->input('outros_descricao');

        if ($dotacao->save()) {
            return new DotacaoRecursoResource($dotacao);
        }
    }

    /**
     * Mostra uma relação dotação x origem recurso específica
     * @authenticated
     *
     *
     * @urlParam id integer required ID da relação dotação x origem recurso. Example: 1
     *
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "dotacao_id": 1,
     *         "origem_recurso_id": 2,
     *         "outros_descricao": null
     *     }
     * }
     */
    public function show($id)
    {
        $dotacao = DotacaoRecurso::findOrFail($id);
        return new DotacaoRecursoResource($dotacao);
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
     * Edita uma relação dotação x origem recurso
     * @authenticated
     *
     *
     * @urlParam id integer required ID da relação dotação x origem recurso que deseja editar. Example: 1
     *
     * @bodyParam dotacao_id integer required ID do tipo de dotação (tabela dotacao_tipos). Example: 1
     * @bodyParam origem_recurso_id integer ID da origem do recurso. Example: 2
     * @bodyParam outros_descricao string Descrição em texto da origem quando for selecionado "outro" (não terá um ID específico nesse caso). Example: "Fonte teste"
     *
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "dotacao_id": 1,
     *         "origem_recurso_id": 2,
     *         "outros_descricao": null
     *     }
     * }
     */
    public function update(DotacaoRecursoFormRequest $request, $id)
    {
        $dotacao = DotacaoRecurso::findOrFail($id);
        $dotacao->dotacao_id = $request->input('dotacao_id');
        $dotacao->origem_recurso_id = $request->input('origem_recurso_id');
        $dotacao->outros_descricao = $request->input('outros_descricao');

        if ($dotacao->save()) {
            return new DotacaoRecursoResource($dotacao);
        }
    }

    /**
     * Deleta uma relação dotação x origem recurso
     * @authenticated
     *
     *
     * @urlParam id integer required ID da relação dotação x origem recurso que deseja deletar. Example: 1
     *
     * @response 200 {
     *     "message": "Dotação-Recurso deletada com sucesso!",
     *     "data":{
     *         "id": 1,
     *         "dotacao_id": 1,
     *         "origem_recurso_id": 2,
     *         "outros_descricao": null
     *     }
     * }
     */
    public function destroy($id)
    {
        $dotacao = DotacaoRecurso::findOrFail($id);

        if ($dotacao->delete()) {
            return response()->json([
                'message' => 'Dotação-Recurso deletada com sucesso!',
                'data' => new DotacaoRecursoResource($dotacao)
            ]);
        }
    }
}
