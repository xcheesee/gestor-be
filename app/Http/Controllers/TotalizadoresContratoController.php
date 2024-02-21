<?php

namespace App\Http\Controllers;

use App\Models\Devolucoes;
use App\Models\EmpenhoNota;
use App\Models\NotasDeReserva;
use App\Models\NotasLiquidacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TotalizadoresContratoController extends Controller
{
    public function ExibirTotais(Request $request, $id)
    {
        $contrato_id =  $id;

        $notas_reserva = NotasDeReserva::where('contrato_id', $contrato_id)->get();
        $notas_empenho = EmpenhoNota::where('contrato_id', $contrato_id)->get();
        $notas_liquidacao = NotasLiquidacao::where('contrato_id', $contrato_id)->get();
        $devolucoes = Devolucoes::where('contrato_id', $contrato_id)->get();

        $total_reserva = 0;
        //TODO: verificar se a nota de reserva é de cancelamento, pois neste caso o valor deve ser subtraído
        foreach ($notas_reserva as $nota_reserva) {
            $total_reserva += $nota_reserva->valor;
        }

        $total_empenho = 0;
        //TODO: verificar se a nota de empenho é de cancelamento, pois neste caso o valor deve ser subtraído
        foreach ($notas_empenho as $nota_empenho) {
            $total_empenho += $nota_empenho->valor_empenho;
        }

        $realizado = 0;
        foreach ($notas_liquidacao as $nota_liquidacao) {
            $realizado += $nota_liquidacao->valor;
        }

        $total_devolucoes = 0;
        foreach ($devolucoes as $devolucao) {
            $total_devolucoes += $devolucao->valor;
        }

        $saldo = $total_empenho - $realizado - $total_devolucoes;

        $media_empenho_ano = DB::table('empenho_notas')
        ->where('contrato_id', $contrato_id)
        ->select(DB::raw('ano_referencia'), DB::raw('ROUND(AVG(valor_empenho), 2) as media_anual'))
        ->groupBy('ano_referencia')
        ->get();

        $media_anual_empenho = array();
        foreach ($media_empenho_ano as $media) {
            array_push($media_anual_empenho, $media);
        }

        $media_realizado_ano = DB::table('notas_liquidacao')
        ->where('contrato_id', $contrato_id)
        ->select(DB::raw('ano_referencia'), DB::raw('ROUND(AVG(valor), 2) as media_anual'))
        ->groupBy('ano_referencia')
        ->get();

        $media_anual_realizado = array();
        foreach ($media_realizado_ano as $media) {
            array_push($media_anual_realizado, $media);
        }

        return response()->json([
            'totalResevado' => $total_reserva,
            'totalEmpenhado' => $total_empenho,
            'realizado' => $realizado,
            'totalDevolucoes' => $total_devolucoes,
            'saldo' => $saldo,
            'mediaAnualEmpenho' => $media_anual_empenho,
            'mediaAnualRealizado' => $media_anual_realizado
        ], 202);
    }
}
