<?php

namespace App\Http\Controllers;

use App\Http\Resources\AnoDeExecResource;
use App\Http\Resources\MesDeExecResource;
use App\Models\AditamentoValor;
use App\Models\AnoDeExecucao;
use App\Models\EmpenhoNota;
use App\Models\MesDeExecucao;
use App\Models\NotasDeReserva;
use App\Models\NotasLiquidacao;
use App\Models\Reajuste;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


/**
 * @group ExecFinanceira
 *
 * APIs para listar, cadastrar, editar dados de execuções financeiras
 */
class ExecFinanceiraController extends Controller
{
    /**
     * Lista todos os anos de execução de um especifico contrato, ou seja deve ser passado
     * o ID do contrato.
     *
     * @urlParam id_contrato integer required ID do contrato. Example: 38
     */
    public function indexAnoExec($id)
    {
        $anos = AnoDeExecucao::where('id_contrato', $id)->get();

        $total_reserva = NotasDeReserva::where('contrato_id', $id)
            ->select(
                DB::raw('YEAR(data_emissao) as ano'),
                DB::raw('SUM(CASE WHEN tipo_nota = "cancelamento" THEN -valor ELSE valor END) as valor_total')
            )
            ->groupBy('ano')
            ->get();

        $resultado = $anos->map(function ($ano) use ($total_reserva) {
            $ano->reservado = $total_reserva->where('ano', $ano->ano)->first()->valor_total ?? 0;
            return $ano;
        });

        return response()->json([
            'data' => $resultado
        ]);
    }


    /**
     * Cria um novo ano de execução
     * 
     * @bodyParam ano integer required ID do contrato. Example: 2023
     * @bodyParam id_contrato integer required Mês referente ao valor executado. Example: 38
     * @bodyParam mes_inicial integer required Ano referente ao valor executado. Valor acima de 1 a 12. Example: 6
     * @bodyParam planejado float required Valor do planejado. Example: 105.000,22
     * @bodyParam reservado float required Valor do reservado. Example: 25.000,26
     * @bodyParam contratado float required Valor do Contratado. Example: 1.500,00
     *
     * @response 202 {
     *     "mensagem": "Ano de Execução cadastrado com sucesso!",
     *     "ano"{
     *           "id": 2,
     *           "ano": 2023,
     *           "id_contrato": 38,
     *           "mes_inicial": 6,
     *           "planejado": 105000.22,
     *           "reservado": 25000.26,
     *           "contratado": 1500.00,
     *          }
     *      }
     */
    public function createAnoExec(Request $request)
    {
        $ano = new AnoDeExecucao;

        $ano->ano = $request->input('ano');
        $ano->id_contrato = $request->input('id_contrato');
        $ano->mes_inicial = $request->input('mes_inicial');
        $ano->planejado = number_format(str_replace(",", ".", str_replace(".", "", $request->planejado)), 2, '.', '');
        //$request->reservado === null ? $ano->reservado = null : $ano->reservado = number_format(str_replace(",", ".", str_replace(".", "", $request->reservado)), 2, '.', '');
        $ano->contratado = number_format(str_replace(",", ".", str_replace(".", "", $request->contratado)), 2, '.', '');

        if ($ano->save())
            ; {
            return response()->json([
                'mensagem' => 'Ano de Execução cadastrado com sucesso!',
                'ano' => new AnoDeExecResource($ano)
            ], 202);
        }
    }

    /**
     * Listar meses do ano
     * 
     * Retornará todos os meses de execução a partir do ID do ano
     * 
     * @urlParam id integer required ID do ano de execução. Example: 2
     * 
     * @response 200 {
     *      "data": [
     *          {
     *               "id": 1,
     *               "id_ano_execucao": 1,
     *               "mes": 6,
     *               "execucao": "35",
     *               "empenhado": 9
     *           },
     *           {
     *               "id": 2,
     *               "id_ano_execucao": 1,
     *               "mes": 7,
     *               "execucao": "20",
     *               "empenhado": 9
     *           },
     *        ]
     *      }
     */
    public function indexMesExec($id)
    {
        $meses = MesDeExecucao::where('id_ano_execucao', $id)->get();

        return MesDeExecResource::collection($meses);
    }

    /**
     * Edita Ano de execução
     * 
     * @bodyParam id_ano_execucao integer required ID do ano de execução. Example: 2
     * @bodyParam planejado integer required valor do planejado. Example: 2541351.00
     * @bodyParam contratado integer required valor do cotratado. Example: 54542.00
     *
     * @response 202 {
     *     "mensagem": "Valores de execução do mês 1 foi cadastrado com sucesso!",
     */
    public function createMesExec(Request $request)
    {
        $ano_de_exec = AnoDeExecucao::find($request->id_ano_execucao);

        $ano_de_exec->update([
            'planejado' => number_format(str_replace(",", ".", str_replace(".", "", $request->planejado)), 2, '.', ''),
            'contratado' => number_format(str_replace(",", ".", str_replace(".", "", $request->contratado)), 2, '.', '')
        ]);

        // A logica a baixo era utilizada pra fazer o antigo metodo de cadastro recebido pelo front. Se não for utilizar, pode apagar.

        //$meses_execucao = $request->data_execucao;
        //$meses_empenhado = $request->data_empenhado;

        //$meses_existentes = MesDeExecucao::where('id_ano_execucao', $request->id_ano_execucao)->orderBy('mes')->get();

        //for ($i = 1; $i <= 12; $i++) {
        //    $mes = $meses_existentes->where('mes', $i)->first();

        //    if ($mes) {
        //        $mes->execucao = $meses_execucao[$i - 1];
        //        $mes->empenhado = $meses_empenhado[$i - 1];
        //        $mes->save();
        //    } else {
        //        if ($meses_execucao[$i - 1] > -1 || $meses_empenhado[$i - 1] > -1) {
        //            $mes = new MesDeExecucao;
        //            $mes->id_ano_execucao = $request->id_ano_execucao;
        //            $mes->mes = $i;
        //            $mes->execucao = $meses_execucao[$i - 1];
        //            $mes->empenhado = $meses_empenhado[$i - 1];
        //            $mes->save();
        //        }
        //    }
        //}

        return response()->json([
            'mensagem' => "Valores de execução do ano foram salvos com sucesso!"
        ]);
    }

    /**
     * Listar valores meses do ano
     * 
     * Retornará todos os valores dos meses do ano, Empenhos, Aditamentos, Reajustes.
     * 
     * Cada indice na lista representa um valor de mês em sequencia, por exemplo:
     * 
     * indice 0 = mês 1,
     * 
     * indice 1 = mês 2,
     * 
     * indice 2 = mês 3
     * 
     * ...
     * 
     * @UrlParam id_ano_execucao integer required ID do ano de execução. Example: 2
     *
     * @response 202 {
     *      "empenhos": [
     *          11707.08,
     *          "",
     *          511415.75,
     *          "",
     *          "",
     *          "",
     *          "",
     *          "",
     *          "",
     *          "",
     *          "",
     *          ""
     *      ],
     *      "aditamentos": [
     *          "",
     *          "",
     *          "",
     *          "",
     *          6666666.17,
     *          "",
     *          "",
     *          "",
     *          "",
     *          "",
     *          "",
     *          ""
     *      ],
     *      "reajustes": [
     *          "",
     *          "",
     *          "",
     *          "",
     *          65465,
     *          "",
     *          "",
     *          "",
     *          "",
     *          "",
     *          "",
     *          ""
     *      ]
     *   }       
     */
    public function indexValoresMesesAno($id)
    {
        $ano = AnoDeExecucao::where('id', $id)->first();

        $empenhos = EmpenhoNota::where('contrato_id', $ano->id_contrato)
            ->where('ano_referencia', $ano->ano)
            ->orderBy('mes_referencia', 'asc')
            ->get();

        $aditamentos = AditamentoValor::where('contrato_id', $ano->id_contrato)
            ->where(DB::raw('YEAR(data_aditamento)'), $ano->ano)
            ->orderBy(DB::raw('MONTH(data_aditamento)'), 'asc')
            ->get();

        $reajustes = Reajuste::where('contrato_id', $ano->id_contrato)
            ->where(DB::raw('YEAR(data_reajuste)'), $ano->ano)
            ->orderBy(DB::raw('MONTH(data_reajuste)'), 'asc')
            ->get();

        $executados = NotasLiquidacao::where('contrato_id', $ano->id_contrato)
            ->where(DB::raw('ano_referencia'), $ano->ano)
            ->orderBy(DB::raw('mes_referencia'), 'asc')
            ->get();

        $reservas = NotasDeReserva::where('contrato_id', $ano->id_contrato)
            ->where(DB::raw('YEAR(data_emissao)'), $ano->ano)
            ->orderBy(DB::raw('MONTH(data_emissao)'), 'asc')
            ->get();


        $empenho_valor_meses = ['', '', '', '', '', '', '', '', '', '', '', ''];
        $aditamento_valor_meses = ['', '', '', '', '', '', '', '', '', '', '', ''];
        $reajuste_valor_meses = ['', '', '', '', '', '', '', '', '', '', '', ''];
        $executado_valor_meses = ['', '', '', '', '', '', '', '', '', '', '', ''];
        $reservado_valor_meses = ['', '', '', '', '', '', '', '', '', '', '', ''];

        $total_empenho = 0;
        foreach ($empenhos as $empenho) {
            $mes_existente = $empenho->mes_referencia;
            $mes_int = intval($mes_existente);

            if ($empenho->tipo_empenho == 'cancelamento') {
                $total_empenho -= $empenho->valor_empenho;
            } else {
                $total_empenho += $empenho->valor_empenho;
            }

            $empenho_valor_meses[$mes_int - 1] = $total_empenho;
        }

        $total_aditamento = 0;
        foreach ($aditamentos as $aditamento) {
            $mes_existente = date('m', strtotime($aditamento->data_aditamento));
            $mes_int = intval($mes_existente);

            if ($aditamento->tipo_aditamento == "Redução de valor") {
                $total_aditamento -= $aditamento->valor_aditamento;
            } else {
                $total_aditamento += $aditamento->valor_aditamento;
            }

            $aditamento_valor_meses[$mes_int - 1] = $total_aditamento;
        }

        $total_reajuste = 0;
        foreach ($reajustes as $reajuste) {
            $mes_existente = date('m', strtotime($reajuste->data_reajuste));
            $mes_int = intval($mes_existente);

            $total_reajuste += $reajuste->valor_reajuste;

            $reajuste_valor_meses[$mes_int - 1] = $total_reajuste;
        }

        $total_executado = 0;
        foreach ($executados as $executado) {
            $mes_existente = $executado->mes_referencia;
            $mes_int = intval($mes_existente);

            $total_executado += $executado->valor;

            $executado_valor_meses[$mes_int - 1] = $total_executado;
        }

        $total_reservado = 0;
        foreach ($reservas as $reserva) {
            $mes_existente = date('m', strtotime($reserva->data_emissao));
            $mes_int = intval($mes_existente);

            if ($reserva->tipo_nota == 'cancelamento') {
                $total_reservado -= $reserva->valor;
            } else {
                $total_reservado += $reserva->valor;
            }

            $reservado_valor_meses[$mes_int - 1] = $total_reservado;
        }

        $obs = [
            'empenhos' => $empenho_valor_meses,
            'aditamentos' => $aditamento_valor_meses,
            'reajustes' => $reajuste_valor_meses,
            'executado' => $executado_valor_meses,
            'reservado' => $reservado_valor_meses
        ];

        return response()->json($obs);
    }

    /**
     * Deletar ano de execução.
     * 
     * Deletará o ano de execução a partir de seu ID e todos os seus meses de execução.
     * 
     * @urlParam id integer required ID do ano. Example: 2 
     */
    public function deleteAnoExec($id)
    {
        $ano = AnoDeExecucao::where('id', $id)->first();
        $meses_ano = MesDeExecucao::where('id_ano_execucao', $id)->get();

        foreach ($meses_ano as $mes) {
            $mes->delete();
        }

        $ano->delete();

        return response()->json([
            'mensagem' => "Ano de execução com o id $id e seus respectivos meses foram deletados!"
        ]);

    }
}