<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Http\Requests\CategoriaFormRequest;
use App\Http\Resources\Categoria as CategoriaResource;

/**
 * @group Categorias
 *
 * APIs para listar os dados de categorias de contrato
 */
class CategoriaController extends Controller
{
    /**
     * Lista categorias
     * @authenticated
     *
     *
     */
    public function index()
    {
        $categorias = Categoria::get();
        return CategoriaResource::collection($categorias);
    }

    public function store(CategoriaFormRequest $request)
    {
        //
        $categoria = new Categoria;
        $categoria->nome = $request->input('nome');
        if ($categoria->save()) {
            return new CategoriaResource($categoria);
        }
    }

    /**
     * Mostra uma categoria específica
     * @authenticated
     *
     *
     * @urlParam id integer required ID da categoria. Example: 1
     *
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "nome": "Obra",
     *     }
     * }
     */
    public function show($id)
    {
        //
        $categoria = Categoria::findOrFail($id);
        return new CategoriaResource($categoria);
    }

    public function update(CategoriaFormRequest $request, $id)
    {
        //
        $categoria = Categoria::findOrFail($id);
        $categoria->nome = $request->input('nome');
        if ($categoria->save()) {
            return new CategoriaResource($categoria);
        }
    }

    public function destroy($id)
    {
        //
        $categoria = Categoria::findOrFail($id);

        if ($categoria->delete()) {
            return response()->json([
                'message' => 'Categoria deletada com sucesso!',
                'data' => new CategoriaResource($categoria)
            ]);
        }
    }
}
