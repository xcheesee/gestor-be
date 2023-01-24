<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmpresaFormRequest;
use App\Http\Resources\EmpresaResource;
use App\Models\Empresa;
use Illuminate\Http\Request;

/**
 * @group Empresa
 *
 * APIs para listar, cadastrar, editar e remover dados de Empresa
 */
class EmpresaController extends Controller
{
    //
    /**
     * Lista as empresas
     * @authenticated
     *
     *
     */
    public function index(Request $request)
    {
        $is_api_request = in_array('api',$request->route()->getAction('middleware'));
        if ($is_api_request){
            $empresas = Empresa::get();
            return EmpresaResource::collection($empresas);
        }

        $filtros = array();
        $filtros['cnpj'] = $request->query('f-cnpj');
        $filtros['nome'] = $request->query('f-nome');

        $data = Empresa::sortable()
            ->when($filtros['cnpj'], function ($query, $val) {
                return $query->where('cnpj','like','%'.str_replace(array('.','-','/'),'',$val).'%');
            })
            ->when($filtros['nome'], function ($query, $val) {
                return $query->where('empresas.nome','like','%'.$val.'%');
            })
            ->paginate(10);

        $mensagem = $request->session()->get('mensagem');
        return view('cadaux.empresa.index', compact('data','mensagem','filtros'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $mensagem = $request->session()->get('mensagem');
        return view ('cadaux.empresa.create',compact('mensagem'));
    }

    /**
     * Cadastra um empresa
     * @authenticated
     *
     *
     * @bodyParam nome string required Nome da empresa. Example: Exemplo
     * @bodyParam subprefeitura_id integer required ID da subprefeitura. Example: 4
     *
     * @response 200 {
     *     "data": {
     *         "id": 102,
     *         "nome": "Exemplo",
     *         "subprefeitura_id": 4
     *     }
     * }
     */
    public function store(EmpresaFormRequest $request)
    {
        $empresa = new Empresa;
        $empresa->nome = $request->input('nome');
        $empresa->cnpj = str_replace(array('.','-','/'),'',$request->cnpj);
        $empresa->telefone = $request->input('telefone');
        $empresa->email = $request->input('email');

        if ($empresa->save()) {
            $is_api_request = in_array('api',$request->route()->getAction('middleware'));
            if ($is_api_request){
                return new EmpresaResource($empresa);
            }

            $request->session()->flash('mensagem',"Empresa '{$empresa->nome}' (ID {$empresa->id}) criado com sucesso");
            return redirect()->route('cadaux-empresas');
        }
    }

    /**
     * Mostra um empresa específico
     * @authenticated
     *
     *
     * @urlParam id integer required ID da empresa. Example: 102
     *
     * @response 200 {
     *     "data": {
     *         "id": 102,
     *         "nome": "Exemplo",
     *         "subprefeitura_id": 4
     *     }
     * }
     */
    public function show(Request $request, $id)
    {
        $empresa = Empresa::findOrFail($id);
        $is_api_request = in_array('api',$request->route()->getAction('middleware'));
        if ($is_api_request){
            return new EmpresaResource($empresa);
        }
        return view('cadaux.empresa.show', compact('empresa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, int $id)
    {
        $empresa = Empresa::findOrFail($id);
        $mensagem = $request->session()->get('mensagem');
        return view ('cadaux.empresa.edit', compact('empresa','mensagem'));
    }

    /**
     * Edita um empresa
     * @authenticated
     *
     *
     * @urlParam id integer required ID da empresa que deseja editar. Example: 102
     *
     *
     * @bodyParam nome string required Nome da empresa. Example: Exemplo
     * @bodyParam subprefeitura_id integer required ID da subprefeitura. Example: 3
     *
     * @response 200 {
     *     "data": {
     *         "id": 102,
     *         "nome": "Exemplo",
     *         "subprefeitura_id": 3
     *     }
     * }
     */
    public function update(EmpresaFormRequest $request, $id)
    {
        $empresa = Empresa::findOrFail($request->id);
        $empresa->nome = $request->input('nome');
        $empresa->cnpj = str_replace(array('.','-','/'),'',$request->cnpj);
        $empresa->telefone = $request->input('telefone');
        $empresa->email = $request->input('email');

        if ($empresa->save()) {
            $is_api_request = in_array('api',$request->route()->getAction('middleware'));
            if ($is_api_request){
                return new EmpresaResource($empresa);
            }

            $request->session()->flash('mensagem',"Empresa '{$empresa->nome}' (ID {$empresa->id}) editado com sucesso");
            return redirect()->route('cadaux-empresas');
        }
    }

    /**
     * Deleta um empresa
     * @authenticated
     *
     *
     * @urlParam id integer required ID da empresa que deseja deletar. Example: 102
     *
     * @response 200 {
     *     "message": "Empresa deletado com sucesso!",
     *     "data": {
     *         "id": 102,
     *         "nome": "Exemplo",
     *         "subprefeitura_id": 3
     *     }
     * }
     */
    public function destroy($id)
    {
        $empresa = Empresa::findOrFail($id);

        if ($empresa->delete()) {
            return response()->json([
                'message' => 'Empresa deletado com sucesso!',
                'data' => new EmpresaResource($empresa)
            ]);
        }
    }
}
