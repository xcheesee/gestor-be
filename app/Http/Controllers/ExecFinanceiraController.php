<?php

namespace App\Http\Controllers;

use App\Http\Resources\AnoDeExecResource;
use App\Http\Resources\MesDeExecResource;
use App\Models\AnoDeExecucao;
use App\Models\MesDeExecucao;
use Illuminate\Http\Request;

/**
 * @group ExecFinanceira
 *
 * APIs para listar, cadastrar, editar dados de execuções financeiras
 */
class ExecFinanceiraController extends Controller
{
    /**
     * Lista notas de valores executados mensais
     *
     *
     */
    public function indexAnoExec($id)
    {
        $anos = AnoDeExecucao::where('id_contrato', $id)->get();

        return AnoDeExecResource::collection($anos);
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
        $ano->planejado = number_format(str_replace(",",".",str_replace(".","",$request->planejado)), 2, '.', '');
        $ano->reservado = number_format(str_replace(",",".",str_replace(".","",$request->reservado)), 2, '.', '');
        $ano->contratado = number_format(str_replace(",",".",str_replace(".","",$request->contratado)), 2, '.', '');

        if($ano->save());{
            return response()->json([
                'mensagem' => 'Ano de Execução cadastrado com sucesso!', 
                'ano' => new AnoDeExecResource($ano)
            ], 202);
        }
    }

    /**
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
     *               "execucao": "35"
     *           },
     *           {
     *               "id": 2,
     *               "id_ano_execucao": 1,
     *               "mes": 7,
     *               "execucao": "20"
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
     * Cria um novo mes de execução ou mais para um ano de execução
     * (A Data deverá ser passada desta forma [null, null, null, null, null, 35, 20, 4, 500, 200, -6, null])
     * 
     * @bodyParam id_ano_execucao integer required ID do ano de execução. Example: 2
     * @bodyParam data[] integer required valores de execução de cada mês. Example: [null, null, null, null, null, 35, 20, 4, 500, 200, -6, null]
     *
     * @response 202 {
     *     "mensagem": "Valores de execução do mês 1 foi cadastrado com sucesso!",
     */
    public function createMesExec(Request $request)
    {
        $meses_execucao = $request->data;
        
        $meses_existentes = MesDeExecucao::where('id_ano_execucao', $request->id_ano_execucao)->orderBy('mes')->get();

        $contador = 1;
        foreach ($meses_execucao as $valor) 
        {
            $mes = $meses_existentes->where('mes', $contador)->first();
            
            if ($mes) 
            {
                $mes->execucao = $valor;
                $mes->save();
            } else { 
                if ($valor != null){
                    $mes = new MesDeExecucao;
                    $mes->id_ano_execucao = $request->id_ano_execucao;
                    $mes->mes = $contador;
                    $mes->execucao = $valor;
                    $mes->save();
                }
            }   
            $contador++;
        }

        return response()->json([
            'mensagem' => "Valores de execução do mês $request->id_ano_execucao foi cadastrado com sucesso!"
        ]);
    }
}
