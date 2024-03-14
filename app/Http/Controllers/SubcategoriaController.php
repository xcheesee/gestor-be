<?php

namespace App\Http\Controllers;

use App\Models\Subcategoria;
use App\Http\Requests\SubcategoriaFormRequest;
use App\Http\Resources\Subcategoria as SubcategoriaResource;

/**
 * @group Subcategorias
 *
 * APIs para listar os dados de subcategorias de contrato
 */
class SubcategoriaController extends Controller
{
    /**
     * Lista subcategorias
     * @authenticated
     *
     *
     */
    public function index()
    {
        $categorias = Subcategoria::get();
        return SubcategoriaResource::collection($categorias);
    }

    public function store(SubcategoriaFormRequest $request)
    {
        //
        $categoria = new Subcategoria;
        $categoria->nome = $request->input('nome');
        if ($categoria->save()) {
            return new SubcategoriaResource($categoria);
        }
    }

    /**
     * Mostra uma subcategoria específica
     * @authenticated
     *
     *
     * @urlParam id integer required ID da subcategoria. Example: 1
     *
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "categoria_id": 1,
     *         "nome": "Implantação de Parque",
     *     }
     * }
     */
    public function show($id)
    {
        //
        $categoria = Subcategoria::findOrFail($id);
        return new SubcategoriaResource($categoria);
    }

    public function update(SubcategoriaFormRequest $request, $id)
    {
        //
        $categoria = Subcategoria::findOrFail($id);
        $categoria->nome = $request->input('nome');
        if ($categoria->save()) {
            return new SubcategoriaResource($categoria);
        }
    }

    public function destroy($id)
    {
        //
        $categoria = Subcategoria::findOrFail($id);

        if ($categoria->delete()) {
            return response()->json([
                'message' => 'Subcategoria deletada com sucesso!',
                'data' => new SubcategoriaResource($categoria)
            ]);
        }
    }

    /**
     * Lista as subcategorias de uma categoria
     * @authenticated
     *
     *
     * @urlParam cat_id integer required ID da categoria. Example: 1
     *
     * @response 200 {
     *     "data": [
     *          {
     *              "id": 1,
     *              "categoria_id": 1,
     *              "nome": "Implantação de Parque",
     *          },
     *          {
     *              "id": 2,
     *              "categoria_id": 1,
     *              "nome": "Requalificação de Parque",
     *          },
     *          {
     *              "id": 3,
     *              "categoria_id": 1,
     *              "nome": "Outro",
     *          }
     *     ]
     * }
     */
    public function listar_subcategorias($cat_id)
    {
        $categorias = Subcategoria::query()->where('categoria_id','=',$cat_id)->get();
        return SubcategoriaResource::collection($categorias);
    }
}
