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
     * Lista os tipos de contratação disponíveis
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
     * Cadastra um novo tipo de contratação
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
     * Mostra um tipo de contratação específico
     * @authenticated
     *
     *
     * @urlParam id integer required ID do tipo de contratação. Example: 1
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
     * Edita um tipo de contratação
     * @authenticated
     *
     *
     * @urlParam id integer required ID do tipo de contratação que deseja editar. Example: 1
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
    public function update(Request $request, $id)
    {
        $tipo_contratacao = TipoContratacao::findOrFail($request->id);
        $tipo_contratacao->nome = $request->input('nome');

        if ($tipo_contratacao->save()) {
            return new TipoContratacaoResource($tipo_contratacao);
        }
    }

    /**
     * Deleta um tipo de contratação
     * @authenticated
     *
     *
     * @urlParam id integer required ID da certidão que deseja deletar. Example: 24
     *
     * @response 200 {
     *     "message": "Tipo Contratação deletado com sucesso!",
     *     "data": {
     *         "id": 1,
     *         "nome": "Manut. Operação de Sist.Inf.Comunic/Serv.TIC PJ"
     *     }
     * }
     */
    public function destroy($id)
    {
        $tipo_contratacao = TipoContratacao::findOrFail($id);

        if ($tipo_contratacao->delete()) {
            return response()->json([
                'message' => 'Tipo Contratação deletado com sucesso!',
                'data' => new TipoContratacaoResource($tipo_contratacao)
            ]);
        }
    }
}
