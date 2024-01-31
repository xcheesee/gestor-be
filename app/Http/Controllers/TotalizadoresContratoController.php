<?php

namespace App\Http\Controllers;

use App\Models\EmpenhoNota;
use App\Models\NotasDeReserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TotalizadoresContratoController extends Controller
{
    public function ExibirTotais(Request $request, $id)
    {
        $contrato_id =  $id;

        $notas_reserva = NotasDeReserva::where('contrato_id', $contrato_id)->get();
        $notas_empenho = EmpenhoNota::where('contrato_id', $contrato_id)->get();

        $total_reserva = 0;
        foreach ($notas_reserva as $nota_reserva) {
            $total_reserva += $nota_reserva->valor;
        }

        $total_empenho = 0;
        foreach ($notas_empenho as $nota_empenho) {
            $total_empenho += $nota_empenho->valor_empenho;
        }

        $media_empenho_ano = DB::table('empenho_notas')
        ->where('contrato_id', $contrato_id)
        ->select(DB::raw('ano_referencia'), DB::raw('ROUND(AVG(valor_empenho), 2) as media_anual'))
        ->groupBy('ano_referencia')
        ->get();

        $media_anual_empenho = array();
        foreach ($media_empenho_ano as $media) {
            array_push($media_anual_empenho, $media);
        }
        
        return response()->json([
            'totalResevado' => $total_reserva,
            'totalEmpenhado' => $total_empenho,
            'media_anual_empenho' => $media_anual_empenho
        ]);
    }
}
