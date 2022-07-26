<?php

namespace App\Http\Controllers;

use App\Helpers\PrefeituraHelper;
use App\Http\Requests\DistritoFormRequest;
use App\Models\Distrito as Distrito;
use App\Http\Resources\Distrito as DistritoResource;
use Illuminate\Http\Request;

/**
 * @group Distrito
 *
 * APIs para listar, cadastrar, editar e remover dados de distrito
 */
class DistritoController extends Controller
{
    /**
     * Lista os distritos
     * @authenticated
     *
     *
     */
    public function index(Request $request)
    {
        $is_api_request = in_array('api',$request->route()->getAction('middleware'));
        if ($is_api_request){
            $distritos = Distrito::get();
            return DistritoResource::collection($distritos);
        }

        $filtros = array();
        $filtros['subprefeitura'] = $request->query('f-subprefeitura');
        $filtros['nome'] = $request->query('f-nome');

        $data = Distrito::sortable()
            ->select('distritos.*', 'sub.nome as sub_nome')
            ->leftJoin('subprefeituras as sub', 'subprefeitura_id', '=', 'sub.id')
            ->when($filtros['subprefeitura'], function ($query, $val) {
                return $query->where('sub.nome','like','%'.$val.'%');
            })
            ->when($filtros['nome'], function ($query, $val) {
                return $query->where('distritos.nome','like','%'.$val.'%');
            })
            ->paginate(10);

        $mensagem = $request->session()->get('mensagem');
        return view('cadaux.distrito.index', compact('data','mensagem','filtros'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $subprefeituras = PrefeituraHelper::subprefeituraDropdown();
        $mensagem = $request->session()->get('mensagem');
        return view ('cadaux.distrito.create',compact('subprefeituras','mensagem'));
    }

    /**
     * Cadastra um distrito
     * @authenticated
     *
     *
     * @bodyParam nome string required Nome do distrito. Example: Exemplo
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
    public function store(DistritoFormRequest $request)
    {
        $distrito = new Distrito;
        $distrito->nome = $request->input('nome');
        $distrito->subprefeitura_id = $request->input('subprefeitura_id');

        if ($distrito->save()) {
            $is_api_request = in_array('api',$request->route()->getAction('middleware'));
            if ($is_api_request){
                return new DistritoResource($distrito);
            }

            $request->session()->flash('mensagem',"Distrito '{$distrito->nome}' (ID {$distrito->id}) criado com sucesso");
            return redirect()->route('cadaux-distritos');
        }
    }

    /**
     * Mostra um distrito específico
     * @authenticated
     *
     *
     * @urlParam id integer required ID do distrito. Example: 102
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
        $distrito = Distrito::findOrFail($id);
        $is_api_request = in_array('api',$request->route()->getAction('middleware'));
        if ($is_api_request){
            return new DistritoResource($distrito);
        }
        return view('cadaux.distrito.show', compact('distrito'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, int $id)
    {
        $distrito = Distrito::findOrFail($id);
        $subprefeituras = PrefeituraHelper::subprefeituraDropdown();
        $mensagem = $request->session()->get('mensagem');
        return view ('cadaux.distrito.edit', compact('distrito','subprefeituras','mensagem'));
    }

    /**
     * Edita um distrito
     * @authenticated
     *
     *
     * @urlParam id integer required ID do distrito que deseja editar. Example: 102
     *
     *
     * @bodyParam nome string required Nome do distrito. Example: Exemplo
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
    public function update(DistritoFormRequest $request, $id)
    {
        $distrito = Distrito::findOrFail($request->id);
        $distrito->nome = $request->input('nome');
        $distrito->subprefeitura_id = $request->input('subprefeitura_id');

        if ($distrito->save()) {
            $is_api_request = in_array('api',$request->route()->getAction('middleware'));
            if ($is_api_request){
                return new DistritoResource($distrito);
            }

            $request->session()->flash('mensagem',"Distrito '{$distrito->nome}' (ID {$distrito->id}) editado com sucesso");
            return redirect()->route('cadaux-distritos');
        }
    }

    /**
     * Deleta um distrito
     * @authenticated
     *
     *
     * @urlParam id integer required ID do distrito que deseja deletar. Example: 102
     *
     * @response 200 {
     *     "message": "Distrito deletado com sucesso!",
     *     "data": {
     *         "id": 102,
     *         "nome": "Exemplo",
     *         "subprefeitura_id": 3
     *     }
     * }
     */
    public function destroy($id)
    {
        $distrito = Distrito::findOrFail($id);

        if ($distrito->delete()) {
            return response()->json([
                'message' => 'Distrito deletado com sucesso!',
                'data' => new DistritoResource($distrito)
            ]);
        }
    }

    /**
     * Lista os distritos pelo ID da subprefeitura
     * @authenticated
     *
     *
     * @urlParam id integer required ID da subprefeitura. Example: 3
     *
     * @response 200 {
     *     "data": [
     *         {
     *             "id": 17,
     *             "nome": "Campo Limpo",
     *             "subprefeitura_id": 3
     *         },
     *         {
     *             "id": 19,
     *             "nome": "Capão Redondo",
     *             "subprefeitura_id": 3
     *         },
     *         {
     *             "id": 85,
     *             "nome": "Vila Andrade",
     *             "subprefeitura_id": 3
     *         },
     *         {
     *             "id": 102,
     *             "nome": "Exemplo",
     *             "subprefeitura_id": 3
     *         }
     *     ]
     * }
     */
    public function listar_por_subprefeitura($id)
    {
        $distritos = Distrito::query()
            ->where('subprefeitura_id','=',$id)
            ->get();

        return DistritoResource::collection($distritos);
    }
}
