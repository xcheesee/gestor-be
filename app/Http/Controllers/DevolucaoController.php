<?php

namespace App\Http\Controllers;

use App\Http\Requests\DevolucaoFormRequest;
use App\Http\Resources\Devolucao as DevolucaoResource;
use App\Models\Devolucao;
use Illuminate\Http\Request;

/**
 * @group Devolucao
 *
 * APIs para listar, cadastrar, editar e remover dados de execuções financeiras planejadas
 */
class DevolucaoController extends Controller
{
    /**
     * Lista valores devolucaos
     * @authenticated
     *
     *
     */
    public function index()
    {
        $devolucoes = Devolucao::paginate(15);
        return DevolucaoResource::collection($devolucoes);
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
     * Cadastra um novo valor devolucao
     * @authenticated
     *
     *
     * @bodyParam contrato_id integer required ID do contrato. Example: 3
     * @bodyParam ano integer required Ano referente ao valor devolucao. Valor acima de 2000. Example: 2022
     * @bodyParam data_devolucao date data de emissão da nota. Example: 2022-05-20
     * @bodyParam numero_devolucao integer Número da nota. Example: 6045
     * @bodyParam valor_devolucao float required Valor devolucao. Example: 1204679.85
     *
     * @response 200 {
     *     "data": {
     *         "id": 2,
     *         "contrato_id": 3,
     *         "ano": 2022,
     *         "data_devolucao": "2022-05-20",
     *         "numero_devolucao": 6045,
     *         "valor_devolucao": 1204679.85
     *     }
     * }
     */
    public function store(DevolucaoFormRequest $request)
    {
        $devolucao = new Devolucao;
        $devolucao->contrato_id = $request->input('contrato_id');
        $devolucao->ano = $request->input('ano');
        $devolucao->data_devolucao = $request->input('data_devolucao');
        $devolucao->numero_devolucao = $request->input('numero_devolucao');
        $devolucao->valor_devolucao = $request->input('valor_devolucao');
        if ($devolucao->save()) {
            return new DevolucaoResource($devolucao);
        }
    }

    /**
     * Mostra uma nota de valor devolucao mensal
     *
     * @authenticated
     *
     *
     * @urlParam id integer required ID da nota de valor devolucao. Example: 2
     *
     * @response 200 {
     *     "data": {
     *         "id": 2,
     *         "contrato_id": 3,
     *         "ano": 2022,
     *         "data_devolucao": "2022-05-20",
     *         "numero_devolucao": 6045,
     *         "valor_devolucao": 1204679.85
     *     }
     * }
     */
    public function show($id)
    {
        $devolucao = Devolucao::findOrFail($id);
        return new DevolucaoResource($devolucao);
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
     * Edita uma nota de valor devolucao mensal
     * @authenticated
     *
     *
     * @urlParam id integer required ID da nota de valor devolucao que deseja editar. Example: 2
     *
     * @bodyParam contrato_id integer required ID do contrato. Example: 3
     * @bodyParam ano integer required Ano referente ao valor devolucao. Valor acima de 2000. Example: 2022
     * @bodyParam data_devolucao date data de devolução. Example: 2022-05-20
     * @bodyParam numero_devolucao integer Número da nota. Example: 6045
     * @bodyParam valor_devolucao float required Valor devolucao. Example: 1204679.85
     *
     * @response 200 {
     *     "data": {
     *         "id": 2,
     *         "contrato_id": 3,
     *         "ano": 2022,
     *         "data_devolucao": "2022-05-20",
     *         "numero_devolucao": 6045,
     *         "valor_devolucao": 1204679.85
     *     }
     * }
     */
    public function update(DevolucaoFormRequest $request, $id)
    {
        $devolucao = Devolucao::findOrFail($id);
        $devolucao->contrato_id = $request->input('contrato_id');
        $devolucao->ano = $request->input('ano');
        $devolucao->data_devolucao = $request->input('data_devolucao');
        $devolucao->numero_devolucao = $request->input('numero_devolucao');
        $devolucao->valor_devolucao = $request->input('valor_devolucao');

        if ($devolucao->save()) {
            return new DevolucaoResource($devolucao);
        }
    }

    /**
     * Deleta uma nota de valor devolucao
     * @authenticated
     *
     *
     * @urlParam id integer required ID da nota de valor devolucao que deseja deletar. Example: 2
     *
     * @response 200 {
     *     "message": "Certidão deletada com sucesso!",
     *     "data": {
     *         "id": 2,
     *         "contrato_id": 3,
     *         "ano": 2022,
     *         "data_devolucao": "2022-05-20",
     *         "numero_devolucao": 6045,
     *         "valor_devolucao": 1204679.85
     *     }
     * }
     */
    public function destroy($id)
    {
        $devolucao = Devolucao::findOrFail($id);

        if ($devolucao->delete()) {
            return response()->json([
                'message' => 'Certidão deletada com sucesso!',
                'data' => new DevolucaoResource($devolucao)
            ]);
        }
    }

    /**
     * Lista as notaw de valor devolucao pelo ID do contrato
     * @authenticated
     *
     *
     * @urlParam id integer required ID do contrato. Example: 1
     *
     * @response 200 {
     *     "data": [
     *         {
     *             "id": 2,
     *             "contrato_id": 3,
     *             "ano": 2022,
     *             "data_devolucao": "2022-05-20",
     *             "numero_devolucao": 6045,
     *             "valor_devolucao": 1204679.85
     *         },
     *         {
     *             "id": 3,
     *             "contrato_id": 3,
     *             "ano": 2022,
     *             "data_devolucao": "2022-06-20",
     *             "numero_devolucao": 6046,
     *             "valor_devolucao": 1204680.00
     *         }
     *     ]
     * }
     */
    public function listar_por_contrato($id)
    {
        $devolucoes = Devolucao::query()
            ->where('contrato_id','=',$id)
            ->get();

        return DevolucaoResource::collection($devolucoes);
    }
}
