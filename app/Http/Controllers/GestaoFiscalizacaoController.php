<?php

namespace App\Http\Controllers;

use App\Http\Requests\GestaoFiscalizacaoFormRequest;
use App\Models\GestaoFiscalizacao as GestaoFiscalizacao;
use App\Http\Resources\GestaoFiscalizacao as GestaoFiscalizacaoResource;
use Illuminate\Http\Request;

/**
 * @group GestaoFiscalizacao
 *
 * APIs para listar, cadastrar, editar e remover dados de gestão da fiscalização de contrato
 */
class GestaoFiscalizacaoController extends Controller
{
    /**
     * Lista as gestões de fiscalizações
     * @authenticated
     *
     *
     */
    public function index()
    {
        $gestaoFiscalizacao = GestaoFiscalizacao::get();
        return GestaoFiscalizacaoResource::collection($gestaoFiscalizacao);
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
     * Cadastra uma gestão de fiscalização
     * @authenticated
     *
     *
     * @bodyParam contrato_id integer required ID do contrato. Example: 1
     * @bodyParam nome_gestor string Nome do gestor. Example: Lucas
     * @bodyParam email_gestor string E-mail do gestor. Example: lucas@email.com
     * @bodyParam nome_fiscal string Nome do fiscal. Example: Honorato
     * @bodyParam email_fiscal string E-mail do fiscal. Example: honorato@email.com
     * @bodyParam nome_suplente string Nome do suplente. Example: Sacramento
     * @bodyParam email_suplente string E-mail do suplente. Example: sacramento@email.com
     *
     * @response 200 {
     *     "data": {
     *         "id": 4,
     *         "contrato_id": 1,
     *         "nome_gestor": "Lucas",
     *         "email_gestor": "lucas@email.com",
     *         "nome_fiscal": "Honorato",
     *         "email_fiscal": "honorato@email.com",
     *         "nome_suplente": "Sacramento",
     *         "email_suplente": "sacramento@email.com"
     *     }
     * }
     */
    public function store(GestaoFiscalizacaoFormRequest $request)
    {
        $gestaoFiscalizacao = new GestaoFiscalizacao;
        $gestaoFiscalizacao->contrato_id = $request->input('contrato_id');
        $gestaoFiscalizacao->nome_gestor = $request->input('nome_gestor');
        $gestaoFiscalizacao->email_gestor = $request->input('email_gestor');
        $gestaoFiscalizacao->nome_fiscal = $request->input('nome_fiscal');
        $gestaoFiscalizacao->email_fiscal = $request->input('email_fiscal');
        $gestaoFiscalizacao->nome_suplente = $request->input('nome_suplente');
        $gestaoFiscalizacao->email_suplente = $request->input('email_suplente');

        if ($gestaoFiscalizacao->save()) {
            return new GestaoFiscalizacaoResource($gestaoFiscalizacao);
        }
    }

    /**
     * Mostra uma gestão fiscalização específica
     * @authenticated
     *
     *
     * @urlParam id integer required ID da gestão de fiscalização. Example: 4
     *
     * @response 200 {
     *     "data": {
     *         "id": 4,
     *         "contrato_id": 1,
     *         "nome_gestor": "Lucas",
     *         "email_gestor": "lucas@email.com",
     *         "nome_fiscal": "Honorato",
     *         "email_fiscal": "honorato@email.com",
     *         "nome_suplente": "Sacramento",
     *         "email_suplente": "sacaramento@email.com"
     *     }
     * }
     */
    public function show($id)
    {
        $gestaoFiscalizacao = GestaoFiscalizacao::findOrFail($id);
        return new GestaoFiscalizacaoResource($gestaoFiscalizacao);
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
     * Edita uma gestão de fiscalização
     * @authenticated
     *
     *
     * @urlParam id integer required ID da gestão de fiscalização que deseja editar. Example: 4
     *
     * @bodyParam contrato_id integer required ID do contrato. Example: 1
     * @bodyParam nome_gestor string Nome do gestor. Example: Lucas
     * @bodyParam email_gestor string E-mail do gestor. Example: lucas@email.com
     * @bodyParam nome_fiscal string Nome do fiscal. Example: Honorato
     * @bodyParam email_fiscal string E-mail do fiscal. Example: honorato@email.com
     * @bodyParam nome_suplente string Nome do suplente. Example: Sacramento
     * @bodyParam email_suplente string E-mail do suplente. Example: sacramento@email.com
     *
     * @response 200 {
     *     "data": {
     *         "id": 4,
     *         "contrato_id": 1,
     *         "nome_gestor": "Lucas",
     *         "email_gestor": "lucas@email.com",
     *         "nome_fiscal": "Honorato",
     *         "email_fiscal": "honorato@email.com",
     *         "nome_suplente": "Sacramento",
     *         "email_suplente": "sacramento@email.com"
     *     }
     * }
     */
    public function update(GestaoFiscalizacaoFormRequest $request, $id)
    {
        $gestaoFiscalizacao = GestaoFiscalizacao::findOrFail($request->id);
        $gestaoFiscalizacao->contrato_id = $request->input('contrato_id');
        $gestaoFiscalizacao->nome_gestor = $request->input('nome_gestor');
        $gestaoFiscalizacao->email_gestor = $request->input('email_gestor');
        $gestaoFiscalizacao->nome_fiscal = $request->input('nome_fiscal');
        $gestaoFiscalizacao->email_fiscal = $request->input('email_fiscal');
        $gestaoFiscalizacao->nome_suplente = $request->input('nome_suplente');
        $gestaoFiscalizacao->email_suplente = $request->input('email_suplente');

        if ($gestaoFiscalizacao->save()) {
            return new GestaoFiscalizacaoResource($gestaoFiscalizacao);
        }
    }

    /**
     * Deleta um gestão de fiscalização
     * @authenticated
     *
     *
     * @urlParam id integer required ID da gestão de fiscalização que deseja deletar. Example: 4
     *
     * @response 200 {
     *     "message": "Gestão de fiscalização deletada com sucesso!",
     *     "data": {
     *         "id": 4,
     *         "contrato_id": 1,
     *         "nome_gestor": "Lucas",
     *         "email_gestor": "lucas@email.com",
     *         "nome_fiscal": "Honorato",
     *         "email_fiscal": "honorato@email.com",
     *         "nome_suplente": "Sacramento",
     *         "email_suplente": "sacramento@email.com"
     *     }
     * }
     */
    public function destroy($id)
    {
        $gestaoFiscalizacao = GestaoFiscalizacao::findOrFail($id);

        if ($gestaoFiscalizacao->delete()) {
            return response()->json([
                'message' => 'Gestão de fiscalização deletada com sucesso!',
                'data' => new GestaoFiscalizacaoResource($gestaoFiscalizacao)
            ]);
        }
    }

    /**
     * Lista as gestões de fiscalização pelo ID do contrato
     * @authenticated
     *
     *
     * @urlParam id integer required ID do contrato. Example: 1
     *
     * @response 200 {
     *     "data": {
     *         "id": 4,
     *         "contrato_id": 1,
     *         "nome_gestor": "Lucas",
     *         "email_gestor": "lucas@email.com",
     *         "nome_fiscal": "Honorato",
     *         "email_fiscal": "honorato@email.com",
     *         "nome_suplente": "Sacramento",
     *         "email_suplente": "sacramento@email.com"
     *     }
     * }
     */
    public function listar_por_contrato($id)
    {
        $gestaoFiscalizacao = GestaoFiscalizacao::query()
            ->where('contrato_id','=',$id)
            ->get();

            return GestaoFiscalizacaoResource::collection($gestaoFiscalizacao);
    }
}
