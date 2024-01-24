<?php

namespace App\Http\Controllers;

use App\Models\NotasDeReserva;
use Illuminate\Http\Request;

/**
 * @group NotasDeReserva
 *
 * APIs para listar, cadastrar, editar dados de Notas de Reserva
 */
class NotasDeReservaController extends Controller
{
    /**
     * Lista todas as Notas Reservas cadastradas.
     */
    public function index($id) {
        $notas = NotasDeReserva::where('contrato_id', $id)->get();

        return response()->json([
            'data' => $notas
        ], 202);
    }

    /**
     * Cria uma nova nota de reserva
     * 
     * @bodyParam numero_nota_reserva integer required numero da nota reserva. Example: 1574862
     * @bodyParam data_emissao date required data de emissão da nota reserva. Example: 2024/01/23
     * @bodyParam tipo_nota enum required tipo da nota reserva ('nova','correcao','cancelamento','renovacao'). Example: nova
     * @bodyParam valor float required Valor da nota reserva. Example: 52000000.00
     *
     * @response 202 {
     *     "mensagem": "Nota de reserva criada com sucesso!",
     *     "notaReserva"{
     *           "id": 2,
     *           "numero_nota_reserva": 1574862,
     *           "data_emissao": "2024-01-23",
     *           "tipo_nota": nova,
     *           "valor": 52000000,
     *          }
     *      }
     */
    public function create(Request $request) {
        $nota = new NotasDeReserva();
        
        $nota->contrato_id = $request->input('contrato_id');
        $nota->numero_nota_reserva = $request->input('numero_nota_reserva');
        $nota->data_emissao = $request->input('data_emissao');
        $nota->tipo_nota = $request->input('tipo_nota');
        $nota->valor = number_format(str_replace(",", ".", str_replace(".", "", $request->input('valor'))), 2, '.', '');
        
        if($nota->save()) {
            return response()->json([
                'mensagem' => 'Nota de reserva criada com sucesso!',
                'notaReserva' => $nota
            ], 202);
        }
        
    }
    
    
    /**
     * Mostra uma nota reserva
     * 
     * @UrlParam id integer required ID da nota reserva. Example: 1
     * 
     * @response 202 {
     *     "mensagem": "Nota Encontrada!",
     *     "notaReserva"{
     *           "id": 1,
     *           "numero_nota_reserva": 1574862,
     *           "data_emissao": "2024-01-23",
     *           "tipo_nota": nova,
     *           "valor": "52000.00",
     *          }
     *      }
     */
    public function show($id) {
        $nota = NotasDeReserva::find($id);

        if($nota) {
            return response()->json([
                'mensagem' => 'Nota Encontrada!',
                'notaReserva' => $nota,
            ], 202);
        }

    }

    /**
     * Edita um nota reserva
     * 
     * @UrlParam id integer required ID da nota reserva. Example: 1
     * 
     * @bodyParam numero_nota_reserva integer required numero da nota reserva. Example: 1574862
     * @bodyParam data_emissao date required data de emissão da nota reserva. Example: 2024/01/23
     * @bodyParam tipo_nota enum required tipo da nota reserva ('nova','correcao','cancelamento','renovacao'). Example: nova
     * @bodyParam valor float required Valor da nota reserva. Example: 52000.00
     * 
     * @response 202 {
     *     "mensagem": "Nota editada com sucesso!",
     *     "notaReserva"{
     *           "id": 1,
     *           "numero_nota_reserva": 1574862,
     *           "data_emissao": "2024-01-23",
     *           "tipo_nota": "nova",
     *           "valor": "52000.00",
     *          }
     *      }
     */
    public function edit(Request $request, $id) {
        $nota = NotasDeReserva::find($id);

        $nota->contrato_id = $request->input('contrato_id');
        $nota->numero_nota_reserva = $request->input('numero_nota_reserva');
        $nota->data_emissao = $request->input('data_emissao');
        $nota->tipo_nota = $request->input('tipo_nota');
        $nota->valor = number_format(str_replace(",", ".", str_replace(".", "", $request->input('valor'))), 2, '.', '');

        if($nota->update()) {
            return response()->json([
                'mensagem' => 'Nota editada com sucesso!',
                'notaReserva' => $nota
            ], 202);
        }
    }

    /**
     * Deleta uma nota reserva
     * 
     * @UrlParam id integer required ID da nota reserva. Example: 2

     * @response 202 {
     *     "mensagem": "Nota excluida com sucesso.",
     *     }
     */
    public function delete($id) {
        $nota = NotasDeReserva::find($id);

        if($nota->delete()) {
            return response()->json([
                'mensagem' => 'Nota excluida com sucesso.',
            ], 202);
        }
    }
}
