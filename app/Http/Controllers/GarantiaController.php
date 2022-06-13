<?php

namespace App\Http\Controllers;

use App\Models\Garantia as Garantia;
use App\Http\Resources\Garantia as GarantiaResource;
use Illuminate\Http\Request;

/**
 * @group Garantia
 *
 * APIs para listar, cadastrar, editar e remover dados de garantia
 */
class GarantiaController extends Controller
{
    /**
     * Lista as Garantias
     * @authenticated
     *
     *
     */
    public function index()
    {
        $garantias = Garantia::paginate(15);
        return GarantiaResource::collection($garantias);
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
     * Cadastra uma garantia
     * @authenticated
     *
     *
     * @bodyParam contrato_id integer required ID do contrato. Example: 24
     * @bodyParam instituicao_financeira string Instituição financeira. Example: Exemplo
     * @bodyParam numero_documento string Número do documento. Example: 050013
     * @bodyParam valor_garantia float Valor da garantia. Example: 1000
     * @bodyParam data_validade_garantia date Validade da garantia. Example: 2022-12-30
     *
     * @response 200 {
     *     "data": {
     *         "id": 10,
     *         "contrato_id": 24,
     *         "instituicao_financeira": "Exemplo",
     *         "numero_documento": "050013",
     *         "valor_garantia": 1000,
     *         "data_validade_garantia": "2022-12-30"
     *     }
     * }
     */
    public function store(Request $request)
    {
        $garantia = new Garantia;
        $garantia->contrato_id = $request->input('contrato_id');
        $garantia->instituicao_financeira = $request->input('instituicao_financeira');
        $garantia->numero_documento = $request->input('numero_documento');
        $garantia->valor_garantia = $request->input('valor_garantia');
        $garantia->data_validade_garantia = $request->input('data_validade_garantia');

        if ($garantia->save()) {
            return new GarantiaResource($garantia);
        }
    }

    /**
     * Mostra uma garantia específica
     * @authenticated
     *
     *
     * @urlParam id integer required ID da garantia. Example: 10
     *
     * @response 200 {
     *     "data": {
     *         "id": 10,
     *         "contrato_id": 24,
     *         "instituicao_financeira": "Exemplo",
     *         "numero_documento": "050013",
     *         "valor_garantia": 1000,
     *         "dta_validade_garantia": "2022-12-30"
     *     }
     * }
     */
    public function show($id)
    {
        $garantia = Garantia::findOrFail($id);
        return new GarantiaResource($garantia);
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
     * Edita uma garantia
     * @authenticated
     *
     *
     * @urlParam id integer required ID da garantia que deseja editar. Example: 10
     *
     * @bodyParam contrato_id integer required ID do contrato. Example: 24
     * @bodyParam instituicao_financeira string Instituição financeira. Example: Example
     * @bodyParam numero_documento string Número do documento. Example: 050013
     * @bodyParam valor_garantia float Valor da garantia. Example: 2000
     * @bodyParam data_validade_garantia date Validade da garantia. Example: 2023-01-01
     *
     * @response 200 {
     *     "data": {
     *         "id": 10,
     *         "contrato_id": 24,
     *         "instituicao_financeira": "Example",
     *         "numero_documento": "050013",
     *         "valor_garantia": 2000,
     *         "dta_validade_garantia": "2023-01-01"
     *     }
     * }
     */
    public function update(Request $request, $id)
    {
        $garantia = Garantia::findOrFail($request->id);
        $garantia->contrato_id = $request->input('contrato_id');
        $garantia->instituicao_financeira = $request->input('instituicao_financeira');
        $garantia->numero_documento = $request->input('numero_documento');
        $garantia->valor_garantia = $request->input('valor_garantia');
        $garantia->data_validade_garantia = $request->input('data_validade_garantia');

        if ($garantia->save()) {
            return new GarantiaResource($garantia);
        }
    }

    /**
     * Deleta uma garantia
     * @authenticated
     *
     *
     * @urlParam id integer required ID da garantia que deseja deletar. Example: 10
     *
     * @response 200 {
     *     "message": "Garantia deletada com sucesso!",
     *     "data": {
     *         "id": 10,
     *         "contrato_id": 24,
     *         "instituicao_financeira": "Example",
     *         "numero_documento": "050013",
     *         "valor_garantia": 2000,
     *         "dta_validade_garantia": "2023-01-01"
     *     }
     * }
     */
    public function destroy($id)
    {
        $garantia = Garantia::findOrFail($id);

        if ($garantia->delete()) {
            return response()->json([
                'message' => 'Garantia deletada com sucesso!',
                'data' => new GarantiaResource($garantia)
            ]);
        }
    }

    /**
     * Lista as garantias pelo ID do contrato
     * @authenticated
     *
     *
     * @urlParam id integer required ID do contrato. Example: 24
     *
     * @response 200 {
     *     "data": {
     *         "id": 10,
     *         "contrato_id": 24,
     *         "instituicao_financeira": "Exemplo",
     *         "numero_documento": "050013",
     *         "valor_garantia": 1000,
     *         "dta_validade_garantia": "2022-12-30"
     *     }
     * }
     */
    public function listar_por_contrato($id)
    {
        $garantias = Garantia::query()
            ->where('contrato_id','=',$id)
            ->get();

        return GarantiaResource::collection($garantias);
    }
}
