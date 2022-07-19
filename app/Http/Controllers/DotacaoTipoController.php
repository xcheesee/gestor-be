<?php

namespace App\Http\Controllers;

use App\Models\DotacaoTipo;
use App\Http\Requests\DotacaoTipoFormRequest;
use App\Http\Resources\DotacaoTipo as DotacaoTipoResource;
use Illuminate\Http\Request;

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
    public function index(Request $request)
    {
        $is_api_request = in_array('api',$request->route()->getAction('middleware'));
        if ($is_api_request){
            $dotacaos = DotacaoTipo::get();
            return DotacaoTipoResource::collection($dotacaos);
        }

        $filtros = array();
        $filtros['numero_dotacao'] = $request->query('f-numero_dotacao');
        $filtros['descricao'] = $request->query('f-descricao');
        $filtros['tipo_despesa'] = $request->query('f-tipo_despesa');

        $data = DotacaoTipo::sortable()
            ->when($filtros['numero_dotacao'], function ($query, $val) {
                return $query->where('numero_dotacao','like','%'.$val.'%');
            })
            ->when($filtros['descricao'], function ($query, $val) {
                return $query->where('descricao','like','%'.$val.'%');
            })
            ->when($filtros['tipo_despesa'], function ($query, $val) {
                return $query->where('tipo_despesa','like','%'.$val.'%');
            })
            ->paginate(10);

        $mensagem = $request->session()->get('mensagem');
        return view('cadaux.dotacao_tipo.index', compact('data','mensagem','filtros'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $mensagem = $request->session()->get('mensagem');
        return view ('cadaux.dotacao_tipo.create',compact('mensagem'));
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
        $dotacao_tipo = new DotacaoTipo;
        $dotacao_tipo->numero_dotacao = $request->input('numero_dotacao');
        $dotacao_tipo->descricao = $request->input('descricao');
        $dotacao_tipo->tipo_despesa = $request->input('tipo_despesa');

        if ($dotacao_tipo->save()) {
            $is_api_request = in_array('api',$request->route()->getAction('middleware'));
            if ($is_api_request){
                return new DotacaoTipoResource($dotacao_tipo);
            }

            $request->session()->flash('mensagem',"Tipo de Dotação nº '{$dotacao_tipo->numero_dotacao}' (ID {$dotacao_tipo->id}) criada com sucesso");
            return redirect()->route('cadaux-dotacao_tipos');
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
    public function show(Request $request, int $id)
    {
        $dotacao_tipo = DotacaoTipo::findOrFail($id);

        $is_api_request = in_array('api',$request->route()->getAction('middleware'));
        if ($is_api_request){
            return new DotacaoTipoResource($dotacao_tipo);
        }
        return view('cadaux.dotacao_tipo.show', compact('dotacao_tipo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, int $id)
    {
        $dotacao_tipo = DotacaoTipo::findOrFail($id);
        $mensagem = $request->session()->get('mensagem');
        return view ('cadaux.dotacao_tipo.edit', compact('dotacao_tipo','mensagem'));
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
        $dotacao_tipo = DotacaoTipo::findOrFail($id);
        $dotacao_tipo->numero_dotacao = $request->input('numero_dotacao');
        $dotacao_tipo->descricao = $request->input('descricao');
        $dotacao_tipo->tipo_despesa = $request->input('tipo_despesa');

        if ($dotacao_tipo->save()) {
            $is_api_request = in_array('api',$request->route()->getAction('middleware'));
            if ($is_api_request){
                return new DotacaoTipoResource($dotacao_tipo);
            }

            $request->session()->flash('mensagem',"Tipo de Dotação nº '{$dotacao_tipo->numero_dotacao}' (ID {$dotacao_tipo->id}) editada com sucesso");
            return redirect()->route('cadaux-dotacao_tipos');
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
