<?php

namespace App\Http\Controllers;

use App\Models\OrigemRecurso;
use App\Http\Requests\OrigemRecursoFormRequest;
use App\Http\Resources\OrigemRecurso as OrigemRecursoResource;

/**
 * @group OrigemRecurso
 *
 * APIs para listar, cadastrar, editar e remover origens de recursos
 */
class OrigemRecursoController extends Controller
{
    /**
     * Lista as origens de recurso
     * @authenticated
     *
     *
     */
    public function index()
    {
        $origens = OrigemRecurso::paginate(15);
        return OrigemRecursoResource::collection($origens);
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
     * Cadastra uma origem de recurso
     * @authenticated
     *
     *
     * @bodyParam origem_id integer required ID do tipo de dotação (tabela origem_tipos). Example: 1
     * @bodyParam origem_recurso_id integer ID da origem do recurso. Example: 2
     * @bodyParam outros_descricao string Descrição em texto da origem quando for selecionado "outro" (não terá um ID específico nesse caso). Example: "Fonte teste"
     *
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "nome": "Tesouro"
     *     }
     * }
     *
     */
    public function store(OrigemRecursoFormRequest $request)
    {
        $origem = new OrigemRecurso;
        $origem->nome = $request->input('nome');

        if ($origem->save()) {
            return new OrigemRecursoResource($origem);
        }
    }

    /**
     * Mostra uma origem de recurso
     * @authenticated
     *
     *
     * @urlParam id integer required ID da relação dotação x origem recurso. Example: 1
     *
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "nome": "Tesouro"
     *     }
     * }
     */
    public function show($id)
    {
        $origem = OrigemRecurso::findOrFail($id);
        return new OrigemRecursoResource($origem);
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
     * Edita uma origem de recurso
     * @authenticated
     *
     *
     * @urlParam id integer required ID da relação dotação x origem recurso que deseja editar. Example: 1
     *
     * @bodyParam origem_id integer required ID do tipo de dotação (tabela origem_tipos). Example: 1
     * @bodyParam origem_recurso_id integer ID da origem do recurso. Example: 2
     * @bodyParam outros_descricao string Descrição em texto da origem quando for selecionado "outro" (não terá um ID específico nesse caso). Example: "Fonte teste"
     *
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "nome": "Tesouro"
     *     }
     * }
     */
    public function update(OrigemRecursoFormRequest $request, $id)
    {
        $origem = OrigemRecurso::findOrFail($id);
        $origem->nome = $request->input('nome');

        if ($origem->save()) {
            return new OrigemRecursoResource($origem);
        }
    }

    /**
     * Deleta uma origem de recurso
     * @authenticated
     *
     *
     * @urlParam id integer required ID da origem de recurso que deseja deletar. Example: 1
     *
     * @response 200 {
     *     "message": "Origem de recurso deletada com sucesso!",
     *     "data":{
     *         "id": 1,
     *         "nome": "Tesouro"
     *     }
     * }
     */
    public function destroy($id)
    {
        $origem = OrigemRecurso::findOrFail($id);

        if ($origem->delete()) {
            return response()->json([
                'message' => 'Origem de recurso deletada com sucesso!',
                'data' => new OrigemRecursoResource($origem)
            ]);
        }
    }
}
