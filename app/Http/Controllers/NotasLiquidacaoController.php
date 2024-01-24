<?php

namespace App\Http\Controllers;

use App\Models\NotasLiquidacao;
use Illuminate\Http\Request;

/**
 * @group NotasLiquidacao
 *
 * APIs para listar, cadastrar, editar dados de Notas de Liquidação
 */
class NotasLiquidacaoController extends Controller
{
    /**
     * Lista todas as Notas de liquidação cadastradas.
     */
    public function index($id)
    {
        $nota = NotasLiquidacao::where('contrato_id', $id)->get();

        return response()->json([
            'data' => $nota
        ], 202);
    }

    /**
     * Cria uma nova nota de liquidação
     * 
     * @bodyParam contrato_id integer required numero do contrato. Example: 1
     * @bodyParam numero_nota_liquidacao integer required numero da nota de loquidacao. Example: 123456
     * @bodyParam data_pagamento date required data de pagamento. Example: nova
     * @bodyParam mes_referencia integer required mes de referencia. Example: 1
     * @bodyParam ano_referencia integer required ano de referencia. Example: 2024
     * @bodyParam valor float required Valor da nota de liquidação. Example: 52000000.00
     *
     * @response 202 {
     *     "mensagem": "Nota de reserva criada com sucesso!",
     *     "notaReserva"{
     *           "contrato_id": 1,
     *           "numero_nota_liquidacao": 1574862,
     *           "data_pagamento": "2024/01/23",
     *           "mes_referencia": 1,
     *           "ano_referencia": 2024,
     *           "valor": 52000.00
     *          }
     *      }
     */
    public function create(Request $request)
    {
        $nota = new NotasLiquidacao();

        $nota->contrato_id = $request->input('contrato_id');
        $nota->numero_nota_liquidacao = $request->input('numero_nota_liquidacao');
        $nota->data_pagamento = $request->input('data_pagamento');
        $nota->mes_referencia = $request->input('mes_referencia');
        $nota->ano_referencia = $request->input('ano_referencia');
        $nota->valor = number_format(str_replace(",", ".", str_replace(".", "", $request->input('valor'))), 2, '.', '');

        if($nota->save()){
            return response()->json([
                'mensagem' => 'Nota de liquidação criada com sucesso!',
                'notaLiquidacao' => $nota
            ], 202);
        }
    }

    /**
     * Mostra uma nota de liquidação
     * 
     * @UrlParam id integer required ID da nota de liquidação. Example: 1
     * 
     * @response 202 {
     *     "mensagem": "Nota de liquidação encontrada!",
     *     "notaLiquidacao": {
     *         "id": 1,
     *         "contrato_id": 2,
     *         "numero_nota_liquidacao": 1574862,
     *         "data_pagamento": "2024-01-23",
     *         "mes_referencia": 1,
     *         "ano_referencia": 2024,
     *         "valor": 52000,
     *         "created_at": "2024-01-24T18:34:54.000000Z",
     *         "updated_at": "2024-01-24T18:34:54.000000Z"
     *          }
     *      }
     */
    public function show($id)
    {
        $nota = NotasLiquidacao::find($id);

        if($nota){
            return response()->json([
                'mensagem' => 'Nota de liquidação encontrada!',
                'notaLiquidacao' => $nota
            ], 202);
        }
    }

    /**
     * Edita um nota de liquidação
     * 
     * @UrlParam id integer required ID da nota de liquidação. Example: 1
     * 
     * @bodyParam contrato_id integer required id do contrato. Example: 2
     * @bodyParam numero_nota_liquidacao integer required numero da nota de liquidação. Example: 1574862
     * @bodyParam data_pagamento date required data de pagamento da nota de liquidação. Example: 2024/01/23
     * @bodyParam mes_referencia integer required mes de referencia. Example: 1
     * @bodyParam ano_referencia integer required ano de referencia. Example: 2024
     * @bodyParam valor float required Valor da nota de liquidação. Example: 52000.00
     * 
     * @response 202 {
     *     "mensagem": "Nota de loquidação editada com sucesso!",
     *     "notaLiquidacao": {
     *         "id": 1,
     *         "contrato_id": 2,
     *         "numero_nota_liquidacao": 1574862,
     *         "data_pagamento": "2024/01/23",
     *         "mes_referencia": 1,
     *         "ano_referencia": 2024,
     *         "valor": "52000.00",
     *         "created_at": "2024-01-24T18:34:54.000000Z",
     *         "updated_at": "2024-01-24T18:44:05.000000Z"
     *      }
     *  }
     */
    public function edit(Request $request, $id)
    {
        $nota = NotasLiquidacao::find($id);

        $nota->contrato_id = $request->input('contrato_id');
        $nota->numero_nota_liquidacao = $request->input('numero_nota_liquidacao');
        $nota->data_pagamento = $request->input('data_pagamento');
        $nota->mes_referencia = $request->input('mes_referencia');
        $nota->ano_referencia = $request->input('ano_referencia');
        $nota->valor = number_format(str_replace(",", ".", str_replace(".", "", $request->input('valor'))), 2, '.', '');

        if($nota->update()){
            return response()->json([
                'mensagem' => 'Nota de loquidação editada com sucesso!',
                'notaLiquidacao' => $nota
            ], 202);
        }
    }

    /**
     * Deleta uma nota de liquidação
     * 
     * @UrlParam id integer required ID da nota de liquidação. Example: 2

     * @response 202 {
     *     "mensagem" : "Nota de Liquidação com o id 2 foi deletado."
     *     }
     */
    public function delete($id)
    {
        $nota = NotasLiquidacao::find($id);

        if($nota->delete()){
            return response()->json([
                'mensagem' => "Nota de Liquidação com o id $id foi deletado."
            ], 202);
        }
    }
}
