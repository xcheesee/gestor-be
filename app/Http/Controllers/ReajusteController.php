<?php

namespace App\Http\Controllers;

use App\Models\Reajuste;
use Illuminate\Http\Request;
use App\Http\Requests\ReajusteFormRequest;
use App\Http\Resources\Reajuste as ReajusteResource;

    /**
 * @group Reajuste
 *
 * APIs para listar, cadastrar, editar e remover dados de reajuste de valor
 */
class ReajusteController extends Controller
{
    /**
     * Lista os reajustes
     * @authenticated
     *
     *
     */
    public function index()
    {
        $reajustes = Reajuste::get();
        return ReajusteResource::collection($reajustes);
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
     * Cadastra um reajuste
     * @authenticated
     *
     *
     * @bodyParam contrato_id integer required ID do contrato. Example: 5
     * @bodyParam indice_reajuste float Índice de reajuste. Example: 5.43
     * @bodyParam valor_reajuste float Valor do reajuste. Example: 1000.00
     *
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "contrato_id": 5,
     *         "indice_reajuste": 5.43,
     *         "valor_reajuste": 1000.00
     *     }
     * }
     */
    public function store(ReajusteFormRequest $request)
    {
        $reajuste = new Reajuste;
        $reajuste->contrato_id = $request->input('contrato_id');
        $reajuste->indice_reajuste = str_replace(',','.',str_replace('.','',$request->input('indice_reajuste')));
        $reajuste->valor_reajuste = str_replace(',','.',str_replace('.','',$request->input('valor_reajuste')));
        $reajuste->percentual = $request->input('percentual');
        $reajuste->data_reajuste = $request->input('data_reajuste');

        if ($reajuste->save()) {
            return new ReajusteResource($reajuste);
        }
    }

    /**
     * Mostra um reajuste específico
     * @authenticated
     *
     *
     * @urlParam id integer required ID do reajuste. Example: 1
     *
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "contrato_id": 5,
     *         "indice_reajuste": 5.43,
     *         "valor_reajuste": 1000
     *     }
     * }
     */
    public function show($id)
    {
        $reajuste = Reajuste::findOrFail($id);
        return new ReajusteResource($reajuste);
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
     * Edita um reajuste
     * @authenticated
     *
     *
     * @urlParam id integer required ID do reajuste que deseja editar. Example: 1
     *
     * @bodyParam contranto_id integer required ID do contrato. Example: 5
     * @bodyParam indice_reajuste float Índice de reajuste. Example: 5.43
     * @bodyParam valor_reajuste float Valor do reajuste. Example: 1000
     * @bodyParam percentual float PCT do reajuste. Example: 184
     *
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "contrato_id": 5,
     *         "indice_reajuste": 5.43,
     *         "valor_reajuste": 1000,
     *     }
     * }
     */
    public function update(ReajusteFormRequest $request, $id)
    {
        $reajuste = Reajuste::findOrFail($request->id);
        $reajuste->contrato_id = $request->input('contrato_id');
        $reajuste->indice_reajuste = str_replace(',','.',str_replace('.','',$request->input('indice_reajuste')));
        $reajuste->valor_reajuste = str_replace(',','.',str_replace('.','',$request->input('valor_reajuste')));
        $reajuste->percentual = $request->input('percentual');
        $reajuste->data_reajuste = $request->input('data_reajuste');

        if ($reajuste->save()) {
            return new ReajusteResource($reajuste);
        }
    }

    /**
     * Deleta um reajuste
     * @authenticated
     *
     *
     * @urlParam id integer required ID do reajuste que deseja deletar. Example: 1
     *
     * @response 200 {
     *     "message": "Reajuste deletado com sucesso!",
     *     "data": {
     *         "id": 1,
     *         "contrato_id": 5,
     *         "indice_reajuste": 5.43,
     *         "valor_reajuste": 1000
     *     }
     * }
     */
    public function destroy($id)
    {
        $reajuste = Reajuste::findOrFail($id);

        if ($reajuste->delete()) {
            return response()->json([
                'message' => 'Reajuste deletado com sucesso!',
                'data' => new ReajusteResource($reajuste)
            ]);
        }
    }

    /**
     * Lista os reajustes pelo ID do contrato
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
     *             "indice_reajuste": 5.43,
     *             "valor_reajuste": 1000
     *         },
     *         {
     *             "id": 4,
     *             "contrato_id": 5,
     *             "indice_reajuste": 5.43,
     *             "valor_reajuste": 1000
     *         }
     *     ]
     * }
     */
    public function listar_por_contrato($id)
    {
        $reajustes = Reajuste::query()
            ->where('contrato_id','=',$id)
            ->get();

        return ReajusteResource::collection($reajustes);
    }
}
