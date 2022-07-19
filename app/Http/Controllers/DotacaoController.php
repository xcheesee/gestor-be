<?php

namespace App\Http\Controllers;

use App\Models\Dotacao;
use App\Http\Requests\DotacaoFormRequest;
use App\Http\Resources\Dotacao as DotacaoResource;
use App\Models\DotacaoRecurso;

/**
 * @group Dotacao
 *
 * APIs para listar, cadastrar, editar e remover dados de dotação orçamentária
 */
class DotacaoController extends Controller
{
    /**
     * Lista as dotações
     * @authenticated
     *
     *
     */
    public function index()
    {
        $dotacaos = Dotacao::get();
        return DotacaoResource::collection($dotacaos);
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
     * Cadastra uma dotação
     * @authenticated
     *
     *
     * @bodyParam dotacao_tipo_id integer required ID do tipo de dotação (tabela dotacao_tipos). Example: 5
     * @bodyParam contrato_id integer required ID do contrato. Example: 5
     * @bodyParam valor_dotacao float Valor desta dotação. Example: 1000.00
     * @bodyParam origem_recurso_id integer required ID da fonte/origem do recurso. Example: 2
     * @bodyParam outros_descricao string Descrição da fonte, usado apenas caso o usuário selecione "outros" (origem_recurso_id = 0). Example: Fonte Externa
     *
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "dotacao_tipo_id": 1,
     *         "contrato_id": 5,
     *         "valor_dotacao": 1000.00,
     *         "recursos": [
     *             {
     *                 "id": 1,
     *                 "dotacao_id": 1,
     *                 "origem_recurso_id": 1,
     *                 "nome": "Convênio Estadual",
     *                 "outros_descricao": null
     *             }
     *         ]
     *     }
     * }
     */
    public function store(DotacaoFormRequest $request)
    {
        $dotacao = new Dotacao;
        $dotacao->dotacao_tipo_id = $request->input('dotacao_tipo_id');
        $dotacao->contrato_id = $request->input('contrato_id');
        $dotacao->valor_dotacao = $request->input('valor_dotacao');

        if ($dotacao->save()) {
            if ($request->input('origem_recurso_id') > 0){
                $dotacaorecurso = new DotacaoRecurso();
                $dotacaorecurso->dotacao_id = $dotacao->id;
                $dotacaorecurso->origem_recurso_id = $request->input('origem_recurso_id') > 0 ? $request->input('origem_recurso_id') : null;
                $dotacaorecurso->outros_descricao = $request->input('outros_descricao');

                if ($dotacaorecurso->save()) {

                    return new DotacaoResource($dotacao);
                }
            }
            return new DotacaoResource($dotacao);
        }
    }

    /**
     * Mostra uma dotação específica
     * @authenticated
     *
     *
     * @urlParam id integer required ID da dotação. Example: 1
     *
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "dotacao_tipo_id": 1,
     *         "contrato_id": 5,
     *         "valor_dotacao": 1000.00,
     *         "recursos": [
     *             {
     *                 "id": 1,
     *                 "dotacao_id": 1,
     *                 "origem_recurso_id": 1,
     *                 "nome": "Tesouro Municipal",
     *                 "outros_descricao": null
     *             },
     *             {
     *                 "id": 2,
     *                 "dotacao_id": 1,
     *                 "origem_recurso_id": 4,
     *                 "nome": "FEMA",
     *                 "outros_descricao": null
     *             }
     *         ]
     *     }
     * }
     */
    public function show($id)
    {
        $dotacao = Dotacao::findOrFail($id);
        return new DotacaoResource($dotacao);
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
     * Edita uma dotação
     * @authenticated
     *
     *
     * @urlParam id integer required ID da dotação que deseja editar. Example: 1
     *
     * @bodyParam dotacao_tipo_id integer required ID do tipo de dotação (tabela dotacao_tipos). Example: 5
     * @bodyParam contrato_id integer required ID do contrato. Example: 5
     * @bodyParam valor_dotacao float Valor desta dotação. Example: 1000.00
     *
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "dotacao_tipo_id": 1,
     *         "contrato_id": 5,
     *         "valor_dotacao": 1000.00
     *     }
     * }
     */
    public function update(DotacaoFormRequest $request, $id)
    {
        $dotacao = Dotacao::findOrFail($id);
        $dotacao->dotacao_tipo_id = $request->input('dotacao_tipo_id');
        $dotacao->contrato_id = $request->input('contrato_id');
        $dotacao->valor_dotacao = $request->input('valor_dotacao');

        if ($dotacao->save()) {
            return new DotacaoResource($dotacao);
        }
    }

    /**
     * Deleta uma dotação
     * @authenticated
     *
     *
     * @urlParam id integer required ID da dotação que deseja deletar. Example: 1
     *
     * @response 200 {
     *     "message": "Dotação deletada com sucesso!",
     *     "data": {
     *         "id": 1,
     *         "dotacao_tipo_id": 1,
     *         "contrato_id": 5,
     *         "valor_dotacao": 1000.00
     *     }
     * }
     */
    public function destroy($id)
    {
        $dotacao = Dotacao::findOrFail($id);

        if ($dotacao->delete()) {
            return response()->json([
                'message' => 'Dotação deletada com sucesso!',
                'data' => new DotacaoResource($dotacao)
            ]);
        }
    }

    /**
     * Lista as dotações pelo ID do contrato
     * @authenticated
     *
     *
     * @urlParam id integer required ID do contrato. Example: 5
     *
     * @response 200 {
     *     "data": [
     *         {
     *             "id": 1,
     *             "dotacao_tipo_id": 1,
     *             "contrato_id": 5,
     *             "valor_dotacao": 1000.00
     *         },
     *         {
     *             "id": 2,
     *             "dotacao_tipo_id": 2,
     *             "contrato_id": 5,
     *             "valor_dotacao": 1300.00
     *         }
     *     ]
     * }
     */
    public function listar_por_contrato($id)
    {
        $dotacaos = Dotacao::query()
            ->where('contrato_id','=',$id)
            ->get();

        return DotacaoResource::collection($dotacaos);
    }
}
