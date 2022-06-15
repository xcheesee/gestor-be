<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubprefeituraFormRequest;
use App\Models\Subprefeitura as Subprefeitura;
use App\Http\Resources\Subprefeitura as SubprefeituraResource;
use Illuminate\Http\Request;

/**
 * @group Subprefeitura
 *
 * APIs para listar, cadastrar, editar e remover dados de subprefeitura
 */
class SubprefeituraController extends Controller
{
    /**
     * Lista as subprefeituras
     * @authenticated
     *
     *
     */
    public function index()
    {
        $subprefeituras = Subprefeitura::paginate(15);
        return SubprefeituraResource::collection($subprefeituras);
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
     * Cadastra uma subprefeitura
     * @authenticated
     *
     *
     * @bodyParam nome string required Nome da subprefeitura. Example: Butantã
     * @bodyParam regiao enum required Nome da região ('N', 'S', 'L', 'CO'). Example: CO
     *
     * @response 200 {
     *     "data": {
     *         "id": "2",
     *         "nome": "Butantã",
     *         "regiao": "CO"
     *     }
     * }
     */
    public function store(SubprefeituraFormRequest $request)
    {
        $subprefeitura = new Subprefeitura;
        $subprefeitura->nome = $request->input('nome');
        $subprefeitura->regiao = $request->input('regiao');

        if ($subprefeitura->save()) {
            return new SubprefeituraResource($subprefeitura);
        }
    }

    /**
     * Mostra uma subprefeitura específica
     * @authenticated
     *
     *
     * @urlParam id integer required ID da subprefeitura. Example: 2
     *
     * @response 200 {
     *     "data": {
     *         "id": "2",
     *         "nome": "Butantã",
     *         "regiao": "CO"
     *     }
     * }
     */
    public function show($id)
    {
        $subprefeitura = Subprefeitura::findOrFail($id);
        return new SubprefeituraResource($subprefeitura);
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
     * Edita uma subprefeitura
     * @authenticated
     *
     *
     * @urlParam id integer required ID da subprefeitura que deseja editar. Example: 2
     *
     * @bodyParam nome string required Nome da subprefeitura. Example: Butantã
     * @bodyParam regiao enum required Nome da região ('N', 'S', 'L', 'CO'). Example: CO
     *
     * @response 200 {
     *     "data": {
     *         "id": "2",
     *         "nome": "Butantã",
     *         "regiao": "CO"
     *     }
     * }
     */
    public function update(Request $request, $id)
    {
        $subprefeitura = Subprefeitura::findOrFail($request->id);
        $subprefeitura->nome = $request->input('nome');
        $subprefeitura->regiao = $request->input('regiao');

        if ($subprefeitura->save()) {
            return new SubprefeituraResource($subprefeitura);
        }
    }

    /**
     * Deleta uma subprefeitura
     * @authenticated
     *
     *
     * @urlParam id integer required ID da subprefeitura que deseja deletar. Example: 2
     *
     * @response 200 {
     *     "message": "Subprefeitura deletada com sucesso!",
     *     "data": {
     *         "id": "2",
     *         "nome": "Butantã",
     *         "regiao": "CO"
     *     }
     * }
     */
    public function destroy($id)
    {
        $subprefeitura = Subprefeitura::findOrFail($id);

        if ($subprefeitura->delete()) {
            return response()->json([
                'message' => 'Subprefeitura deletada com sucesso!',
                'data' => new SubprefeituraResource($subprefeitura)
            ]);
        }
    }

    /**
     * Lista as subprefeituras pela região (N,S,L,CO)
     * @unauthenticated
     *
     *
     * @urlParam id integer required ID do contrato. Example: 5
     *
     * @response 200 {
     *     "data": [
     *         {
     *             "id": 2,
     *             "nome": "Butantã",
     *             "regiao": "CO"
     *         },
     *         {
     *             "id": 16,
     *             "nome": "Lapa",
     *             "regiao": "CO"
     *         },
     *         {
     *             "id": 22,
     *             "nome": "Pinheiros",
     *             "regiao": "CO"
     *         },
     *         {
     *             "id": 29,
     *             "nome": "Sé",
     *             "regiao": "CO"
     *         }
     *     ]
     * }
     */
    public function listar_por_regiao($regiao)
    {
        $subprefeituras = Subprefeitura::query()
            ->where('regiao','=',$regiao)
            ->get();

        return SubprefeituraResource::collection($subprefeituras);
    }

    public function listar_regioes(){
        return response()->json([
            [
                'id' => 'CO',
                'nome' => 'Centro-Oeste'
            ],
            [
                'id' => 'L',
                'nome' => 'Leste'
            ],
            [
                'id' => 'N',
                'nome' => 'Norte'
            ],
            [
                'id' => 'S',
                'nome' => 'Sul'
            ],
        ]);
    }
}
