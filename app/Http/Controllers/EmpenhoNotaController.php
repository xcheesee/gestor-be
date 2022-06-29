<?php

namespace App\Http\Controllers;

use App\Models\EmpenhoNota;
use App\Http\Requests\EmpenhoNotaFormRequest;
use App\Http\Resources\EmpenhoNota as EmpenhoNotaResource;

/**
 * @group EmpenhoNota
 *
 * APIs para listar, cadastrar, editar e remover dados de Nota de Empenho
 */
class EmpenhoNotaController extends Controller
{
    /**
     * Lista as Notas de Empenho
     * @authenticated
     *
     *
     */
    public function index()
    {
        $empenhonotas = EmpenhoNota::paginate(15);
        return EmpenhoNotaResource::collection($empenhonotas);
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
     * Cadastra uma nota de Empenho
     * @authenticated
     *
     *
     * @bodyParam contrato_id integer required ID do contrato. Example: 5
     * @bodyParam tipo_empenho string tipo da nota de Empenho ('complemento','cancelamento'). Example: complemento
     * @bodyParam data_emissao date Data na qual esta nota de Empenho foi emitida. Example: 2022-05-21
     * @bodyParam numero_nota integer Número desta nota de Empenho. Example: 1024
     * @bodyParam valor_empenho float required Valor desta nota de Empenho. Example: 1000.00
     *
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "contrato_id": 1,
     *         "tipo_empenho": "complemento",
     *         "data_emissao": "2022-05-21",
     *         "numero_nota": 1024,
     *         "valor_empenho": 1000.00
     *     }
     * }
     */
    public function store(EmpenhoNotaFormRequest $request)
    {
        $empenhonota = new EmpenhoNota;
        $empenhonota->contrato_id = $request->input('contrato_id');
        $empenhonota->tipo_empenho = $request->input('tipo_empenho');
        $empenhonota->data_emissao = $request->input('data_emissao');
        $empenhonota->numero_nota = $request->input('numero_nota');
        $empenhonota->valor_empenho = $request->input('valor_empenho');

        if ($empenhonota->save()) {
            return new EmpenhoNotaResource($empenhonota);
        }
    }

    /**
     * Mostra uma nota de Empenho específica
     * @authenticated
     *
     *
     * @urlParam id integer required ID da nota de Empenho. Example: 1
     *
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "contrato_id": 1,
     *         "tipo_empenho": "complemento",
     *         "data_emissao": "2022-05-21",
     *         "numero_nota": 1024,
     *         "valor_empenho": 1000.00
     *     }
     * }
     */
    public function show($id)
    {
        $empenhonota = EmpenhoNota::findOrFail($id);
        return new EmpenhoNotaResource($empenhonota);
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
     * Edita uma nota de Empenho
     * @authenticated
     *
     *
     * @urlParam id integer required ID da nota de Empenho que deseja editar. Example: 1
     *
     * @bodyParam contrato_id integer required ID do contrato. Example: 5
     * @bodyParam tipo_empenho string tipo da nota de Empenho ('complemento','cancelamento'). Example: complemento
     * @bodyParam data_emissao date Data na qual esta nota de Empenho foi emitida. Example: 2022-05-21
     * @bodyParam numero_nota integer Número desta nota de Empenho. Example: 1024
     * @bodyParam valor_empenho float required Valor desta nota de Empenho. Example: 1000.00
     *
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "contrato_id": 1,
     *         "tipo_empenho": "complemento",
     *         "data_emissao": "2022-05-21",
     *         "numero_nota": 1024,
     *         "valor_empenho": 1000.00
     *     }
     * }
     */
    public function update(EmpenhoNotaFormRequest $request, $id)
    {
        $empenhonota = EmpenhoNota::findOrFail($id);
        $empenhonota->contrato_id = $request->input('contrato_id');
        $empenhonota->tipo_empenho = $request->input('tipo_empenho');
        $empenhonota->data_emissao = $request->input('data_emissao');
        $empenhonota->numero_nota = $request->input('numero_nota');
        $empenhonota->valor_empenho = $request->input('valor_empenho');

        if ($empenhonota->save()) {
            return new EmpenhoNotaResource($empenhonota);
        }
    }

    /**
     * Deleta uma nota de Empenho
     * @authenticated
     *
     *
     * @urlParam id integer required ID da nota de Empenho que deseja deletar. Example: 1
     *
     * @response 200 {
     *     "message": "Nota de Empenho deletada com sucesso!",
     *     "data": {
     *         "id": 1,
     *         "contrato_id": 1,
     *         "tipo_empenho": "complemento",
     *         "data_emissao": "2022-05-21",
     *         "numero_nota": 1024,
     *         "valor_empenho": 1000.00
     *     }
     * }
     */
    public function destroy($id)
    {
        $empenhonota = EmpenhoNota::findOrFail($id);

        if ($empenhonota->delete()) {
            return response()->json([
                'message' => 'Nota de Empenho deletada com sucesso!',
                'data' => new EmpenhoNotaResource($empenhonota)
            ]);
        }
    }

    /**
     * Lista as Notas de Empenho pelo ID do contrato
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
     *             "tipo_empenho": "complemento",
     *             "data_emissao": "2022-05-21",
     *             "numero_nota": 1024,
     *             "valor_empenho": 1000.00
     *         },
     *         {
     *             "id": 2,
     *             "contrato_id": 5,
     *             "tipo_empenho": "cancelamento",
     *             "data_emissao": "2022-06-21",
     *             "numero_nota": null,
     *             "valor_empenho": 500.00
     *         }
     *     ]
     * }
     */
    public function listar_por_contrato($id)
    {
        $empenhonotas = EmpenhoNota::query()
            ->where('contrato_id','=',$id)
            ->get();

        return EmpenhoNotaResource::collection($empenhonotas);
    }
}
