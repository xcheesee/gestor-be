<?php

namespace App\Http\Controllers;

use App\Models\Distrito as Distrito;
use App\Http\Resources\Distrito as DistritoResource;
use Illuminate\Http\Request;

/**
 * @group Distrito
 *
 * APIs para listar, cadastrar, editar e remover dados de distrito
 */
class DistritoController extends Controller
{
    /**
     * Lista os distritos
     * @authenticated
     * 
     * 
     */
    public function index()
    {
        $distritos = Distrito::paginate(100);
        return DistritoResource::collection($distritos);
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
     * Cadastra um distrito
     * @authenticated
     * 
     * 
     * @bodyParam subprefeitura_id integer required ID da subprefeitura. Example: 4
     * @bodyParam nome string required Nome do distrito. Example: Exemplo
     *  
     * @response 200 {
     *     "data": {
     *         "id": 102,
     *         "subprefeitura_id": 4,
     *         "nome": "Exemplo"
     *     }
     * }
     */
    public function store(Request $request)
    {
        $distrito = new Distrito;
        $distrito->subprefeitura_id = $request->input('subprefeitura_id');
        $distrito->nome = $request->input('nome');

        if ($distrito->save()) {
            return new DistritoResource($distrito);
        }
    }

    /**
     * Mostra um distrito específico
     * @authenticated
     * 
     * 
     * @urlParam id integer required ID do distrito. Example: 102
     * 
     * @response 200 {
     *     "data": {
     *         "id": 102,
     *         "subprefeitura_id": 4,
     *         "nome": "Exemplo"
     *     }
     * }
     */
    public function show($id)
    {
        $distrito = Distrito::findOrFail($id);
        return new DistritoResource($distrito);
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
     * Edita um distrito
     * @authenticated
     * 
     * 
     * @urlParam id integer required ID do distrito que deseja editar. Example: 102
     * 
     * 
     * @bodyParam subprefeitura_id integer required ID da subprefeitura. Example: 3
     * @bodyParam nome string required Nome do distrito. Example: Exemplo
     * 
     * @response 200 {
     *     "data": {
     *         "id": 102,
     *         "subprefeitura_id": 3,
     *         "nome": "Exemplo"
     *     }
     * }
     */
    public function update(Request $request, $id)
    {
        $distrito = Distrito::findOrFail($request->id);
        $distrito->subprefeitura_id = $request->input('subprefeitura_id');
        $distrito->nome = $request->input('nome');

        if ($distrito->save()) {
            return new DistritoResource($distrito);
        }
    }

    /**
     * Deleta um distrito
     * @authenticated
     * 
     * 
     * @urlParam id integer required ID do distrito que deseja deletar. Example: 102
     * 
     * @response 200 {
     *     "message": "Distrito deletado com sucesso!",
     *     "data": {
     *         "id": 102,
     *         "subprefeitura_id": 3,
     *         "nome": "Exemplo"
     *     }
     * }
     */
    public function destroy($id)
    {
        $distrito = Distrito::findOrFail($id);

        if ($distrito->delete()) {
            return response()->json([
                'message' => 'Distrito deletado com sucesso!',
                'data' => new DistritoResource($distrito)
            ]);
        }
    }

    /**
     * Lista os distritos pelo ID da subprefeitura
     * @authenticated
     * 
     * 
     * @urlParam id integer required ID da subprefeitura. Example: 3
     * 
     * @response 200 {
     *     "data": [
     *         {
     *             "id": 17,
     *             "subprefeitura_id": 3,
     *             "nome": "Campo Limpo"
     *         },
     *         {
     *             "id": 19,
     *             "subprefeitura_id": 3,
     *             "nome": "Capão Redondo"
     *         },
     *         {
     *             "id": 85,
     *             "subprefeitura_id": 3,
     *             "nome": "Vila Andrade"
     *         },
     *         {
     *             "id": 102,
     *             "subprefeitura_id": 3,
     *             "nome": "Exemplo"
     *         }
     *     ]
     * }
     */
    public function listar_por_subprefeitura($id)
    {
        $distritos = Distrito::query()
            ->where('subprefeitura_id','=',$id)
            ->get();

        return DistritoResource::collection($distritos);
    }
}
