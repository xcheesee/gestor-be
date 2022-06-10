<?php

namespace App\Http\Controllers;

use App\Models\TipoContratacao as TipoContratacao;
use App\Http\Resources\TipoContratacao as TipoContratacaoResource;
use Illuminate\Http\Request;

/**
 * @group TipoContratacao
 *
 * APIs para listar, cadastrar, editar e remover dados de tipo de contratação
 */
class TipoContratacaoController extends Controller
{
    /**
     * Lista certidões
     * @authenticated
     *
     *
     */
    public function index()
    {
        $tipo_contratacoes = TipoContratacao::paginate(15);
        return TipoContratacaoResource::collection($tipo_contratacoes);
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
     * Cadastra uma nova certidão
     * @authenticated
     *
     *
     * @bodyParam nome string Nome do tipo de contratação. Example: Manut. Operação de Sist.Inf.Comunic/Serv.TIC PJ
     *
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "nome": "Manut. Operação de Sist.Inf.Comunic/Serv.TIC PJ"
     *     }
     * }
     */
    public function store(Request $request)
    {
        $tipo_contratacao = new TipoContratacao;
        $tipo_contratacao->nome = $request->input('nome');
        if ($tipo_contratacao->save()) {
            return new TipoContratacaoResource($tipo_contratacao);
        }
    }

    /**
     * Mostra uma certidão específica
     * @authenticated
     *
     *
     * @urlParam id integer required ID da certidão. Example: 24
     *
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "nome": "Manut. Operação de Sist.Inf.Comunic/Serv.TIC PJ"
     *     }
     * }
     */
    public function show($id)
    {
        $tipo_contratacao = TipoContratacao::findOrFail($id);
        return new TipoContratacaoResource($tipo_contratacao);
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
     * Edita uma certidão
     * @authenticated
     *
     *
     * @urlParam id integer required ID da certidão que deseja editar. Example: 24
     *
     * @bodyParam contrato_id integer required ID do contrato. Example: 14
     * @bodyParam tipo_contratacoes string Nome da certidão. Example: Certidão negativa de débitos
     * @bodyParam validade_tipo_contratacoes date Validade da certidão. Example: 2023-06-21
     *
     * @response 200 {
     *     "data": {
     *         "id": 24,
     *         "contrato_id": 14,
     *         "tipo_contratacoes": "Certidão negativa de débitos",
     *         "validade_tipo_contratacoes": "2023-06-21"
     *     }
     * }
     */
    public function update(Request $request, $id)
    {
        $tipo_contratacao = TipoContratacao::findOrFail($request->id);
        $tipo_contratacao->nome = $request->input('nome');

        if ($tipo_contratacao->save()) {
            return new TipoContratacaoResource($tipo_contratacao);
        }
    }

    /**
     * Deleta uma certidão
     * @authenticated
     *
     *
     * @urlParam id integer required ID da certidão que deseja deletar. Example: 24
     *
     * @response 200 {
     *     "message": "Certidão deletada com sucesso!",
     *     "data": {
     *         "id": 24,
     *         "contrato_id": 14,
     *         "tipo_contratacoes": "Certidão negativa para débitos",
     *         "validade_tipo_contratacoes": "2023-06-21"
     *     }
     * }
     */
    public function destroy($id)
    {
        $tipo_contratacao = TipoContratacao::findOrFail($id);

        if ($tipo_contratacao->delete()) {
            return response()->json([
                'message' => 'Tipo Contratação deletada com sucesso!',
                'data' => new TipoContratacaoResource($tipo_contratacao)
            ]);
        }
    }
}
