<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExecutadaFormRequest;
use App\Http\Resources\Executada as ExecutadaResource;
use App\Models\Executada;
use Illuminate\Http\Request;

/**
 * @group Executada
 *
 * APIs para listar, cadastrar, editar e remover dados de execuções financeiras executadas
 */
class ExecutadaController extends Controller
{
    /**
     * Lista notas de valores executados mensais
     * @authenticated
     *
     *
     */
    public function index()
    {
        $executadas = Executada::paginate(15);
        return ExecutadaResource::collection($executadas);
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
     * Cadastra uma nova nota de valor executado
     * @authenticated
     *
     *
     * @bodyParam contrato_id integer required ID do contrato. Example: 3
     * @bodyParam mes integer required Mês referente ao valor executado. Valores entre 1 a 12. Example: 1
     * @bodyParam ano integer required Ano referente ao valor executado. Valor acima de 2000. Example: 2022
     * @bodyParam data_emissao_executado date data de emissão da nota. Example: 2022-05-20
     * @bodyParam numero_executado integer Número da nota. Example: 6045
     * @bodyParam valor_executado float required Valor executado. Example: 1204679.85
     *
     * @response 200 {
     *     "data": {
     *         "id": 2,
     *         "contrato_id": 3,
     *         "mes": 1,
     *         "ano": 2022,
     *         "data_emissao_executado": "2022-05-20",
     *         "numero_executado": 6045,
     *         "valor_executado": 1204679.85
     *     }
     * }
     */
    public function store(ExecutadaFormRequest $request)
    {
        $executada = new Executada;
        $executada->contrato_id = $request->input('contrato_id');
        $executada->mes = $request->input('mes');
        $executada->ano = $request->input('ano');
        $executada->data_emissao_executado = $request->input('data_emissao_executado');
        $executada->numero_executado = $request->input('numero_executado');
        $executada->valor_executado = $request->input('valor_executado');
        if ($executada->save()) {
            return new ExecutadaResource($executada);
        }
    }

    /**
     * Mostra uma nota de valor executado mensal
     *
     * @authenticated
     *
     *
     * @urlParam id integer required ID da nota de valor executado. Example: 2
     *
     * @response 200 {
     *     "data": {
     *         "id": 2,
     *         "contrato_id": 3,
     *         "mes": 1,
     *         "ano": 2022,
     *         "data_emissao_executado": "2022-05-20",
     *         "numero_executado": 6045,
     *         "valor_executado": 1204679.85
     *     }
     * }
     */
    public function show($id)
    {
        $executada = Executada::findOrFail($id);
        return new ExecutadaResource($executada);
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
     * Edita uma nota de valor executado mensal
     * @authenticated
     *
     *
     * @urlParam id integer required ID da nota de valor executado que deseja editar. Example: 2
     *
     * @bodyParam contrato_id integer required ID do contrato. Example: 3
     * @bodyParam mes integer required Mês referente ao valor executado. Valores entre 1 a 12. Example: 1
     * @bodyParam ano integer required Ano referente ao valor executado. Valor acima de 2000. Example: 2022
     * @bodyParam data_emissao_executado date data de emissão da nota. Example: 2022-05-20
     * @bodyParam numero_executado integer Número da nota. Example: 6045
     * @bodyParam valor_executado float required Valor executado. Example: 1204679.85
     *
     * @response 200 {
     *     "data": {
     *         "id": 2,
     *         "contrato_id": 3,
     *         "mes": 1,
     *         "ano": 2022,
     *         "data_emissao_executado": "2022-05-20",
     *         "numero_executado": 6045,
     *         "valor_executado": 1204679.85
     *     }
     * }
     */
    public function update(ExecutadaFormRequest $request, $id)
    {
        $executada = Executada::findOrFail($request->id);
        $executada->contrato_id = $request->input('contrato_id');
        $executada->mes = $request->input('mes');
        $executada->ano = $request->input('ano');
        $executada->data_emissao_executado = $request->input('data_emissao_executado');
        $executada->numero_executado = $request->input('numero_executado');
        $executada->valor_executado = $request->input('valor_executado');

        if ($executada->save()) {
            return new ExecutadaResource($executada);
        }
    }

    /**
     * Deleta uma nota de valor executado
     * @authenticated
     *
     *
     * @urlParam id integer required ID da nota de valor executado que deseja deletar. Example: 2
     *
     * @response 200 {
     *     "message": "Certidão deletada com sucesso!",
     *     "data": {
     *         "id": 2,
     *         "contrato_id": 3,
     *         "mes": 1,
     *         "ano": 2022,
     *         "data_emissao_executado": "2022-05-20",
     *         "numero_executado": 6045,
     *         "valor_executado": 1204679.85
     *     }
     * }
     */
    public function destroy($id)
    {
        $executada = Executada::findOrFail($id);

        if ($executada->delete()) {
            return response()->json([
                'message' => 'Certidão deletada com sucesso!',
                'data' => new ExecutadaResource($executada)
            ]);
        }
    }

    /**
     * Lista as notaw de valor executado pelo ID do contrato
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
     *             "mes": 1,
     *             "ano": 2022,
     *             "data_emissao_executado": "2022-05-20",
     *             "numero_executado": 6045,
     *             "valor_executado": 1204679.85
     *         },
     *         {
     *             "id": 3,
     *             "contrato_id": 3,
     *             "mes": 2,
     *             "ano": 2022,
     *             "data_emissao_executado": "2022-06-20",
     *             "numero_executado": 6046,
     *             "valor_executado": 1204680.00
     *         }
     *     ]
     * }
     */
    public function listar_por_contrato($id)
    {
        $executadas = Executada::query()
            ->where('contrato_id','=',$id)
            ->get();

        return ExecutadaResource::collection($executadas);
    }
}
