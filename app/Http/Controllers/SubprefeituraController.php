<?php

namespace App\Http\Controllers;

use App\Helpers\PrefeituraHelper;
use App\Http\Requests\SubprefeituraFormRequest;
use App\Models\Subprefeitura as Subprefeitura;
use App\Http\Resources\Subprefeitura as SubprefeituraResource;
use Illuminate\Http\Request;

/**
 * @group Subprefeitura
 *
 * APIs para listar, cadastrar, editar e remover dados de subprefeitura
 */
class SubprefeituraController extends Controller
{
    /**
     * Lista as subprefeituras
     * @authenticated
     *
     *
     */
    public function index(Request $request)
    {
        $is_api_request = in_array('api',$request->route()->getAction('middleware'));
        if ($is_api_request){
            $subprefeituras = Subprefeitura::get();
            return SubprefeituraResource::collection($subprefeituras);
        }

        $filtros = array();
        $filtros['regiao'] = $request->query('f-regiao');
        $filtros['nome'] = $request->query('f-nome');

        $data = Subprefeitura::sortable()
            ->when($filtros['regiao'], function ($query, $val) {
                return $query->where('regiao','=',$val);
            })
            ->when($filtros['nome'], function ($query, $val) {
                return $query->where('nome','like','%'.$val.'%');
            })
            ->paginate(10);

        $mensagem = $request->session()->get('mensagem');
        return view('cadaux.subprefeitura.index', compact('data','mensagem','filtros'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $mensagem = $request->session()->get('mensagem');
        $regioes = PrefeituraHelper::regiaoDropdown();
        return view ('cadaux.subprefeitura.create',compact('mensagem','regioes'));
    }

    /**
     * Cadastra uma subprefeitura
     * @authenticated
     *
     *
     * @bodyParam nome string required Nome da subprefeitura. Example: Butantã
     * @bodyParam regiao enum required Nome da região ('N', 'S', 'L', 'CO'). Example: CO
     *
     * @response 200 {
     *     "data": {
     *         "id": "2",
     *         "nome": "Butantã",
     *         "regiao": "CO"
     *     }
     * }
     */
    public function store(SubprefeituraFormRequest $request)
    {
        $subprefeitura = new Subprefeitura;
        $subprefeitura->nome = $request->input('nome');
        $subprefeitura->regiao = $request->input('regiao');

        if ($subprefeitura->save()) {
            $is_api_request = in_array('api',$request->route()->getAction('middleware'));
            if ($is_api_request){
                return new SubprefeituraResource($subprefeitura);
            }

            $request->session()->flash('mensagem',"Subprefeitura '{$subprefeitura->nome}' (ID {$subprefeitura->id}) criada com sucesso");
            return redirect()->route('cadaux-subprefeituras');
        }
    }

    /**
     * Mostra uma subprefeitura específica
     * @authenticated
     *
     *
     * @urlParam id integer required ID da subprefeitura. Example: 2
     *
     * @response 200 {
     *     "data": {
     *         "id": "2",
     *         "nome": "Butantã",
     *         "regiao": "CO"
     *     }
     * }
     */
    public function show(Request $request, int $id)
    {
        $subprefeitura = Subprefeitura::findOrFail($id);

        $is_api_request = in_array('api',$request->route()->getAction('middleware'));
        if ($is_api_request){
            return new SubprefeituraResource($subprefeitura);
        }
        return view('cadaux.subprefeitura.show', compact('subprefeitura'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, int $id)
    {
        $subprefeitura = Subprefeitura::findOrFail($id);
        $regioes = PrefeituraHelper::regiaoDropdown();

        $mensagem = $request->session()->get('mensagem');
        return view ('cadaux.subprefeitura.edit', compact('subprefeitura','regioes','mensagem'));
    }

    /**
     * Edita uma subprefeitura
     * @authenticated
     *
     *
     * @urlParam id integer required ID da subprefeitura que deseja editar. Example: 2
     *
     * @bodyParam nome string required Nome da subprefeitura. Example: Butantã
     * @bodyParam regiao enum required Nome da região ('N', 'S', 'L', 'CO'). Example: CO
     *
     * @response 200 {
     *     "data": {
     *         "id": "2",
     *         "nome": "Butantã",
     *         "regiao": "CO"
     *     }
     * }
     */
    public function update(SubprefeituraFormRequest $request, $id)
    {
        $subprefeitura = Subprefeitura::findOrFail($request->id);
        $subprefeitura->nome = $request->input('nome');
        $subprefeitura->regiao = $request->input('regiao');

        if ($subprefeitura->save()) {
            $is_api_request = in_array('api',$request->route()->getAction('middleware'));
            if ($is_api_request){
                return new SubprefeituraResource($subprefeitura);
            }

            $request->session()->flash('mensagem',"Subprefeitura '{$subprefeitura->nome}' (ID {$subprefeitura->id}) editada com sucesso");
            return redirect()->route('cadaux-subprefeituras');
        }
    }

    /**
     * Deleta uma subprefeitura
     * @authenticated
     *
     *
     * @urlParam id integer required ID da subprefeitura que deseja deletar. Example: 2
     *
     * @response 200 {
     *     "message": "Subprefeitura deletada com sucesso!",
     *     "data": {
     *         "id": "2",
     *         "nome": "Butantã",
     *         "regiao": "CO"
     *     }
     * }
     */
    public function destroy($id)
    {
        $subprefeitura = Subprefeitura::findOrFail($id);

        if ($subprefeitura->delete()) {
            return response()->json([
                'message' => 'Subprefeitura deletada com sucesso!',
                'data' => new SubprefeituraResource($subprefeitura)
            ]);
        }
    }

    /**
     * Lista as subprefeituras pela região (N,S,L,CO)
     * @unauthenticated
     *
     *
     * @urlParam id integer required ID do contrato. Example: 5
     *
     * @response 200 {
     *     "data": [
     *         {
     *             "id": 2,
     *             "nome": "Butantã",
     *             "regiao": "CO"
     *         },
     *         {
     *             "id": 16,
     *             "nome": "Lapa",
     *             "regiao": "CO"
     *         },
     *         {
     *             "id": 22,
     *             "nome": "Pinheiros",
     *             "regiao": "CO"
     *         },
     *         {
     *             "id": 29,
     *             "nome": "Sé",
     *             "regiao": "CO"
     *         }
     *     ]
     * }
     */
    public function listar_por_regiao($regiao)
    {
        $subprefeituras = Subprefeitura::query()
            ->where('regiao','=',$regiao)
            ->get();

        return SubprefeituraResource::collection($subprefeituras);
    }

    public function listar_regioes(){
        return response()->json([
            [
                'id' => 'CO',
                'nome' => 'Centro-Oeste'
            ],
            [
                'id' => 'L',
                'nome' => 'Leste'
            ],
            [
                'id' => 'N',
                'nome' => 'Norte'
            ],
            [
                'id' => 'S',
                'nome' => 'Sul'
            ],
        ]);
    }
}
