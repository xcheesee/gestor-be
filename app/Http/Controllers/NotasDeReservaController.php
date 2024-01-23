<?php

namespace App\Http\Controllers;

use App\Models\NotasDeReserva;
use Illuminate\Http\Request;

/**
 * @group ExecFinanceira
 *
 * APIs para listar, cadastrar, editar dados de Notas de Reserva
 */
class NotasDeReservaController extends Controller
{
    /**
     * Lista todas as Notas Reservas cadastradas.
     */
    public function index() {
        $notas = NotasDeReserva::all();

        return response()->json($notas);
    }

    public function create(Request $request) {
        $nota = new NotasDeReserva();
        
        $nota->numero_nota_reserva = $request->numero_nota_reserva;
        $nota->data_emissao = $request->data_emissao;
        $nota->tipo_nota = $request->tipo_nota;
        $nota->valor = number_format(str_replace(",", ".", str_replace(".", "", $request->valor)), 2, '.', '');

        if($nota->save()) {
            return ('Nota reserva criada com sucesso!');
        }
        
    }

    public function show($id) {
        $nota = NotasDeReserva::find($id);

        if($nota) {
            return response()->json([
                'Mensagem' => 'Nota Encontrada!',
                'NotaReserva' => $nota,
            ]);
        }

    }

    public function edit(Request $request, $id) {
        $nota = NotasDeReserva::find($id);

        $nota->numero_nota_reserva = $request->numero_nota_reserva;
        $nota->data_emissao = $request->data_emissao;
        $nota->tipo_nota = $request->tipo_nota;
        $nota->valor = number_format(str_replace(",", ".", str_replace(".", "", $request->valor)), 2, '.', '');

        if($nota->update()) {
            return ('Nota reserva editada com sucesso!');
        }
    }

    public function delete($id) {
        $nota = NotasDeReserva::find($id);

        if($nota->delete()) {
            return ('Nota excluida com sucesso.');
        }
    }
}
