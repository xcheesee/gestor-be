<?php

namespace App\Http\Controllers;

use App\Models\LicitacaoModelo as LicitacaoModelo;
use App\Http\Resources\LicitacaoModelo as LicitacaoModeloResource;
use Illuminate\Http\Request;

/**
 * @group LicitacaoModelo
 *
 * APIs para listar, cadastrar, editar e remover dados de execuções financeiras planejadas
 */
class LicitacaoModeloController extends Controller
{
    /**
     * Lista os tipos de contratação disponíveis
     * @authenticated
     *
     *
     */
    public function index()
    {
        $tipo_contratacoes = LicitacaoModelo::paginate(15);
        return LicitacaoModeloResource::collection($tipo_contratacoes);
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
        $licitacao_modelo = new LicitacaoModelo;
        $licitacao_modelo->nome = $request->input('nome');
        if ($licitacao_modelo->save()) {
            return new LicitacaoModeloResource($licitacao_modelo);
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
        $licitacao_modelo = LicitacaoModelo::findOrFail($id);
        return new LicitacaoModeloResource($licitacao_modelo);
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
        $licitacao_modelo = LicitacaoModelo::findOrFail($request->id);
        $licitacao_modelo->nome = $request->input('nome');

        if ($licitacao_modelo->save()) {
            return new LicitacaoModeloResource($licitacao_modelo);
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
        $licitacao_modelo = LicitacaoModelo::findOrFail($id);

        if ($licitacao_modelo->delete()) {
            return response()->json([
                'message' => 'Tipo Contratação deletado com sucesso!',
                'data' => new LicitacaoModeloResource($licitacao_modelo)
            ]);
        }
    }
}
