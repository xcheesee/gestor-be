<?php

namespace App\Http\Controllers;

use App\Models\DotacaoTipo;
use App\Http\Requests\DotacaoTipoFormRequest;
use App\Http\Resources\DotacaoTipo as DotacaoTipoResource;

/**
 * @group DotacaoTipo
 *
 * APIs para listar, cadastrar, editar e remover relacionamentos entre dotações e origem de recursos
 */
class DotacaoTipoController extends Controller
{
    /**
     * Lista os tipos de dotação
     * @authenticated
     *
     *
     */
    public function index()
    {
        $dotacaos = DotacaoTipo::paginate(15);
        return DotacaoTipoResource::collection($dotacaos);
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
     * Cadastra um tipo de dotação
     * @authenticated
     *
     *
     * @bodyParam numero_dotacao string required número da dotação completa (tabela dotacao_tipos). Example: "27.10.18.126.3011.1.220.44904000.00.0"
     * @bodyParam descricao string required descrição da ação da dotação. Example: "Desenvolvimento de Sistemas de Informação e Comunicação"
     * @bodyParam tipo_despesa string descrição textual do tipo de despesa. Example: "Serviços de Tecnologia da Informação e Comunicação - Pessoa Jurídica"
     *
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "numero_dotacao": "27.10.18.126.3011.1.220.44904000.00.0",
     *         "descricao": "Desenvolvimento de Sistemas de Informação e Comunicação",
     *         "tipo_despesa": "Serviços de Tecnologia da Informação e Comunicação - Pessoa Jurídica"
     *     }
     * }
     *
     */
    public function store(DotacaoTipoFormRequest $request)
    {
        $dotacao = new DotacaoTipo;
        $dotacao->numero_dotacao = $request->input('numero_dotacao');
        $dotacao->descricao = $request->input('descricao');
        $dotacao->tipo_despesa = $request->input('tipo_despesa');

        if ($dotacao->save()) {
            return new DotacaoTipoResource($dotacao);
        }
    }

    /**
     * Mostra um tipo de dotação específica
     * @authenticated
     *
     *
     * @urlParam id integer required ID do tipo de dotação. Example: 1
     *
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "numero_dotacao": "27.10.18.126.3011.1.220.44904000.00.0",
     *         "descricao": "Desenvolvimento de Sistemas de Informação e Comunicação",
     *         "tipo_despesa": "Serviços de Tecnologia da Informação e Comunicação - Pessoa Jurídica"
     *     }
     * }
     */
    public function show($id)
    {
        $dotacao = DotacaoTipo::findOrFail($id);
        return new DotacaoTipoResource($dotacao);
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
     * Edita um tipo de dotação
     * @authenticated
     *
     *
     * @urlParam id integer required ID do tipo de dotação que deseja editar. Example: 1
     *
     * @bodyParam numero_dotacao string required número da dotação completa (tabela dotacao_tipos). Example: "27.10.18.126.3011.1.220.44904000.00.0"
     * @bodyParam descricao string required descrição da ação da dotação. Example: "Desenvolvimento de Sistemas de Informação e Comunicação"
     * @bodyParam tipo_despesa string descrição textual do tipo de despesa. Example: "Serviços de Tecnologia da Informação e Comunicação - Pessoa Jurídica"
     *
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "numero_dotacao": "27.10.18.126.3011.1.220.44904000.00.0",
     *         "descricao": "Desenvolvimento de Sistemas de Informação e Comunicação",
     *         "tipo_despesa": "Serviços de Tecnologia da Informação e Comunicação - Pessoa Jurídica"
     *     }
     * }
     */
    public function update(DotacaoTipoFormRequest $request, $id)
    {
        $dotacao = DotacaoTipo::findOrFail($id);
        $dotacao->numero_dotacao = $request->input('numero_dotacao');
        $dotacao->descricao = $request->input('descricao');
        $dotacao->tipo_despesa = $request->input('tipo_despesa');

        if ($dotacao->save()) {
            return new DotacaoTipoResource($dotacao);
        }
    }

    /**
     * Deleta um tipo de dotação
     * @authenticated
     *
     *
     * @urlParam id integer required ID do tipo de dotação que deseja deletar. Example: 1
     *
     * @response 200 {
     *     "message": "Tipo de dotação deletada com sucesso!",
     *     "data": {
     *         "id": 1,
     *         "numero_dotacao": "27.10.18.126.3011.1.220.44904000.00.0",
     *         "descricao": "Desenvolvimento de Sistemas de Informação e Comunicação",
     *         "tipo_despesa": "Serviços de Tecnologia da Informação e Comunicação - Pessoa Jurídica"
     *     }
     * }
     */
    public function destroy($id)
    {
        $dotacao = DotacaoTipo::findOrFail($id);

        if ($dotacao->delete()) {
            return response()->json([
                'message' => 'Tipo de dotação deletada com sucesso!',
                'data' => new DotacaoTipoResource($dotacao)
            ]);
        }
    }
}
