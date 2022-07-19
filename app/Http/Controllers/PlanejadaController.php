<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanejadaFormRequest;
use App\Http\Resources\Planejada as PlanejadaResource;;
use App\Models\Planejada as Planejada;
use Illuminate\Http\Request;

/**
 * @group Planejada
 *
 * APIs para listar, cadastrar, editar e remover dados de execuções financeiras planejadas
 */
class PlanejadaController extends Controller
{
    /**
     * Lista notas de valores planejados mensais
     * @authenticated
     *
     *
     */
    public function index()
    {
        $planejadas = Planejada::get();
        return PlanejadaResource::collection($planejadas);
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
     * Cadastra uma nova nota de valor planejado
     * @authenticated
     *
     *
     * @bodyParam contrato_id integer required ID do contrato. Example: 3
     * @bodyParam mes integer required Mês referente ao valor planejado. Valores entre 1 a 12. Example: 1
     * @bodyParam ano integer required Ano referente ao valor planejado. Valor acima de 2000. Example: 2022
     * @bodyParam tipo_lancamento string Tipo do lançamento, pode ser empenho ou reserva. Example: empenho
     * @bodyParam modalidade string Modalidade da nota, podendo ser 'normal', 'complementar' ou 'reajuste'. Example: complementar
     * @bodyParam data_emissao_planejado date data de emissão da nota. Example: 2022-05-20
     * @bodyParam numero_planejado integer Número da nota. Example: 6045
     * @bodyParam valor_planejado float required Valor planejado. Example: 1204679.85
     *
     * @response 200 {
     *     "data": {
     *         "id": 2,
     *         "contrato_id": 3,
     *         "mes": 1,
     *         "ano": 2022,
     *         "tipo_lancamento": "empenho",
     *         "modalidade": "complementar",
     *         "data_emissao_planejado": "2022-05-20",
     *         "numero_planejado": 6045,
     *         "valor_planejado": 1204679.85
     *     }
     * }
     */
    public function store(PlanejadaFormRequest $request)
    {
        $planejada = new Planejada;
        $planejada->contrato_id = $request->input('contrato_id');
        $planejada->mes = $request->input('mes');
        $planejada->ano = $request->input('ano');
        $planejada->tipo_lancamento = $request->input('tipo_lancamento');
        $planejada->modalidade = $request->input('modalidade');
        $planejada->data_emissao_planejado = $request->input('data_emissao_planejado');
        $planejada->numero_planejado = $request->input('numero_planejado');
        $planejada->valor_planejado = $request->input('valor_planejado');

        if ($planejada->save()) {
            return new PlanejadaResource($planejada);
        }
    }

    /**
     * Mostra uma nota de valor planejado mensal
     *
     * @authenticated
     *
     *
     * @urlParam id integer required ID da nota de valor planejado. Example: 2
     *
     * @response 200 {
     *     "data": {
     *         "id": 2,
     *         "contrato_id": 3,
     *         "mes": 1,
     *         "ano": 2022,
     *         "tipo_lancamento": "empenho",
     *         "modalidade": "complementar",
     *         "data_emissao_planejado": "2022-05-20",
     *         "numero_planejado": 6045,
     *         "valor_planejado": 1204679.85
     *     }
     * }
     */
    public function show($id)
    {
        $planejada = Planejada::findOrFail($id);
        return new PlanejadaResource($planejada);
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
     * Edita uma nota de valor planejado mensal
     * @authenticated
     *
     *
     * @urlParam id integer required ID da nota de valor planejado que deseja editar. Example: 2
     *
     * @bodyParam contrato_id integer required ID do contrato. Example: 3
     * @bodyParam mes integer required Mês referente ao valor planejado. Valores entre 1 a 12. Example: 1
     * @bodyParam ano integer required Ano referente ao valor planejado. Valor acima de 2000. Example: 2022
     * @bodyParam tipo_lancamento string Tipo do lançamento, pode ser empenho ou reserva. Example: empenho
     * @bodyParam modalidade string Modalidade da nota, podendo ser 'normal', 'complementar' ou 'reajuste'. Example: complementar
     * @bodyParam data_emissao_planejado date data de emissão da nota. Example: 2022-05-20
     * @bodyParam numero_planejado integer Número da nota. Example: 6045
     * @bodyParam valor_planejado float required Valor planejado. Example: 1204679.85
     *
     * @response 200 {
     *     "data": {
     *         "id": 2,
     *         "contrato_id": 3,
     *         "mes": 1,
     *         "ano": 2022,
     *         "tipo_lancamento": "empenho",
     *         "modalidade": "complementar",
     *         "data_emissao_planejado": "2022-05-20",
     *         "numero_planejado": 6045,
     *         "valor_planejado": 1204679.85
     *     }
     * }
     */
    public function update(PlanejadaFormRequest $request, $id)
    {
        $planejada = Planejada::findOrFail($request->id);
        $planejada->contrato_id = $request->input('contrato_id');
        $planejada->mes = $request->input('mes');
        $planejada->ano = $request->input('ano');
        $planejada->tipo_lancamento = $request->input('tipo_lancamento');
        $planejada->modalidade = $request->input('modalidade');
        $planejada->data_emissao_planejado = $request->input('data_emissao_planejado');
        $planejada->numero_planejado = $request->input('numero_planejado');
        $planejada->valor_planejado = $request->input('valor_planejado');

        if ($planejada->save()) {
            return new PlanejadaResource($planejada);
        }
    }

    /**
     * Deleta uma nota de valor planejado
     * @authenticated
     *
     *
     * @urlParam id integer required ID da nota de valor planejado que deseja deletar. Example: 2
     *
     * @response 200 {
     *     "message": "Certidão deletada com sucesso!",
     *     "data": {
     *         "id": 2,
     *         "contrato_id": 3,
     *         "mes": 1,
     *         "ano": 2022,
     *         "tipo_lancamento": "empenho",
     *         "modalidade": "complementar",
     *         "data_emissao_planejado": "2022-05-20",
     *         "numero_planejado": 6045,
     *         "valor_planejado": 1204679.85
     *     }
     * }
     */
    public function destroy($id)
    {
        $planejada = Planejada::findOrFail($id);

        if ($planejada->delete()) {
            return response()->json([
                'message' => 'Certidão deletada com sucesso!',
                'data' => new PlanejadaResource($planejada)
            ]);
        }
    }

    /**
     * Lista as notaw de valor planejado pelo ID do contrato
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
     *             "tipo_lancamento": "empenho",
     *             "modalidade": "complementar",
     *             "data_emissao_planejado": "2022-05-20",
     *             "numero_planejado": 6045,
     *             "valor_planejado": 1204679.85
     *         },
     *         {
     *             "id": 3,
     *             "contrato_id": 3,
     *             "mes": 2,
     *             "ano": 2022,
     *             "tipo_lancamento": "empenho",
     *             "modalidade": "normal",
     *             "data_emissao_planejado": "2022-06-20",
     *             "numero_planejado": 6046,
     *             "valor_planejado": 1204680.00
     *         }
     *     ]
     * }
     */
    public function listar_por_contrato($id)
    {
        $planejadas = Planejada::query()
            ->where('contrato_id','=',$id)
            ->get();

        return PlanejadaResource::collection($planejadas);
    }
}
