<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExecucaoFinanceiraFormRequest;
use App\Http\Resources\ExecucaoFinanceira as ExecucaoFinanceiraResource;
use App\Models\ExecucaoFinanceira;
use Illuminate\Http\Request;

/**
 * @group ExecucaoFinanceira
 *
 * APIs para listar, cadastrar, editar e remover dados de execuções financeiras executadas
 */
class ExecucaoFinanceiraController extends Controller
{
    /**
     * Lista notas de valores executados mensais
     * @authenticated
     *
     *
     */
    public function index()
    {
        $executadas = ExecucaoFinanceira::get();
        return ExecucaoFinanceiraResource::collection($executadas);
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
     * @bodyParam planejado_inicial float Valor planejado inicial. Example: 1204679.85
     * @bodyParam contratado_inicial float Valor contratado inicial. Example: 1300000.00
     * @bodyParam valor_reajuste float Valor de reajuste. Example: 120.00
     * @bodyParam valor_aditivo float Valor de aditivo. Example: 6045.00
     * @bodyParam valor_cancelamento float Valor de cancelamento. Example: 500.95
     * @bodyParam empenhado float Valor empenhado de fato. Example: 604500.00
     * @bodyParam executado float Valor executado de fato. Example: 120467.99
     *
     * @response 200 {
     *     "data": {
     *         "id": 2,
     *         "contrato_id": 3,
     *         "mes": 1,
     *         "ano": 2022,
     *         "planejado_inicial": 1204679.85,
     *         "contratado_inicial": 1300000.00,
     *         "contratado_atualizado": 1305664.05,
     *         "valor_reajuste": 120.00,
     *         "valor_aditivo": 6045.00,
     *         "valor_cancelamento": 500.95,
     *         "empenhado": 604500.00,
     *         "executado": 120467.99,
     *         "saldo": 484032.01
     *     }
     * }
     */
    public function store(ExecucaoFinanceiraFormRequest $request)
    {
        $executada = new ExecucaoFinanceira;
        $executada->contrato_id = $request->input('contrato_id');
        $executada->mes = $request->input('mes');
        $executada->ano = $request->input('ano');
        $executada->planejado_inicial = $request->input('planejado_inicial');
        $executada->contratado_inicial = $request->input('contratado_inicial');
        $executada->valor_reajuste = str_replace(',','.',str_replace('.','',$request->input('valor_reajuste')));
        $executada->valor_aditivo = str_replace(',','.',str_replace('.','',$request->input('valor_aditivo')));
        $executada->valor_cancelamento = str_replace(',','.',str_replace('.','',$request->input('valor_cancelamento')));
        $executada->empenhado = $request->input('empenhado');
        $executada->executado = $request->input('executado');
        if ($executada->save()) {
            return new ExecucaoFinanceiraResource($executada);
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
     *         "planejado_inicial": 1204679.85,
     *         "contratado_inicial": 1300000.00,
     *         "contratado_atualizado": 1305664.05,
     *         "valor_reajuste": 120.00,
     *         "valor_aditivo": 6045.00,
     *         "valor_cancelamento": 500.95,
     *         "empenhado": 604500.00,
     *         "executado": 120467.99,
     *         "saldo": 484032.01
     *     }
     * }
     */
    public function show($id)
    {
        $executada = ExecucaoFinanceira::findOrFail($id);
        return new ExecucaoFinanceiraResource($executada);
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
     * @bodyParam planejado_inicial float Valor planejado inicial. Example: 1204679.85
     * @bodyParam contratado_inicial float Valor contratado inicial. Example: 1300000.00
     * @bodyParam valor_reajuste float Valor de reajuste. Example: 120.00
     * @bodyParam valor_aditivo float Valor de aditivo. Example: 6045.00
     * @bodyParam valor_cancelamento float Valor de cancelamento. Example: 500.95
     * @bodyParam empenhado float Valor empenhado de fato. Example: 604500.00
     * @bodyParam executado float Valor executado de fato. Example: 120467.99
     *
     * @response 200 {
     *     "data": {
     *         "id": 2,
     *         "contrato_id": 3,
     *         "mes": 1,
     *         "ano": 2022,
     *         "planejado_inicial": 1204679.85,
     *         "contratado_inicial": 1300000.00,
     *         "contratado_atualizado": 1305664.05,
     *         "valor_reajuste": 120.00,
     *         "valor_aditivo": 6045.00,
     *         "valor_cancelamento": 500.95,
     *         "empenhado": 604500.00,
     *         "executado": 120467.99,
     *         "saldo": 484032.01
     *     }
     * }
     */
    public function update(ExecucaoFinanceiraFormRequest $request, $id)
    {
        $executada = ExecucaoFinanceira::findOrFail($request->id);
        $executada->contrato_id = $request->input('contrato_id');
        $executada->mes = $request->input('mes');
        $executada->ano = $request->input('ano');
        $executada->planejado_inicial = $request->input('planejado_inicial');
        $executada->contratado_inicial = $request->input('contratado_inicial');
        $executada->valor_reajuste = str_replace(',','.',str_replace('.','',$request->input('valor_reajuste')));
        $executada->valor_aditivo = str_replace(',','.',str_replace('.','',$request->input('valor_aditivo')));
        $executada->valor_cancelamento = str_replace(',','.',str_replace('.','',$request->input('valor_cancelamento')));
        $executada->empenhado = $request->input('empenhado');
        $executada->executado = $request->input('executado');

        if ($executada->save()) {
            return new ExecucaoFinanceiraResource($executada);
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
     *         "planejado_inicial": 1204679.85,
     *         "contratado_inicial": 1300000.00,
     *         "contratado_atualizado": 1305664.05,
     *         "valor_reajuste": 120.00,
     *         "valor_aditivo": 6045.00,
     *         "valor_cancelamento": 500.95,
     *         "empenhado": 604500.00,
     *         "executado": 120467.99,
     *         "saldo": 484032.01
     *     }
     * }
     */
    public function destroy($id)
    {
        $executada = ExecucaoFinanceira::findOrFail($id);

        if ($executada->delete()) {
            return response()->json([
                'message' => 'Certidão deletada com sucesso!',
                'data' => new ExecucaoFinanceiraResource($executada)
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
     *             "planejado_inicial": 1204679.85,
     *             "contratado_inicial": 1300000.00,
     *             "contratado_atualizado": 1305664.05,
     *             "valor_reajuste": 120.00,
     *             "valor_aditivo": 6045.00,
     *             "valor_cancelamento": 500.95,
     *             "empenhado": 604500.00,
     *             "executado": 120467.99,
     *             "saldo": 484032.01
     *         },
     *         {
     *             "id": 3,
     *             "contrato_id": 3,
     *             "mes": 1,
     *             "ano": 2022,
     *             "planejado_inicial": 1204679.85,
     *             "contratado_inicial": 1300000.00,
     *             "contratado_atualizado": 1305664.05,
     *             "valor_reajuste": 120.00,
     *             "valor_aditivo": 6045.00,
     *             "valor_cancelamento": 500.95,
     *             "empenhado": 604500.00,
     *             "executado": 120467.99,
     *             "saldo": 484032.01
     *         }
     *     ]
     * }
     */
    public function listar_por_contrato($id)
    {
        $executadas = ExecucaoFinanceira::query()
            ->where('contrato_id','=',$id)
            ->get();

        return ExecucaoFinanceiraResource::collection($executadas);
    }
}
