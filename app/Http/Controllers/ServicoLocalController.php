<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServicoLocalFormRequest;
use App\Models\ServicoLocal as ServicoLocal;
use App\Http\Resources\ServicoLocal as ServicoLocalResource;
use Illuminate\Http\Request;

/**
 * @group ServicoLocal
 *
 * APIs para listar, cadastrar, editar e remover dados de local de serviço
 */
class ServicoLocalController extends Controller
{
    /**
     * Lista os serviços locais
     * @authenticated
     *
     *
     */
    public function index()
    {
        $servicosLocais = ServicoLocal::get();
        return ServicoLocalResource::collection($servicosLocais);
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
     * Cadastra um serviço local
     * @authenticated
     *
     *
     * @bodyParam contrato_id integer required ID do contrato. Example: 5
     * @bodyParam ditrito_id integer required ID do distrito. Example: 13
     * @bodyParam subprefeitura_id integer required ID da subprefeitura. Example: 5
     * @bodyParam unidade string required Nome da unidade. Example: Unidade exemplo
     *
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "contrato_id": 5,
     *         "distrito_id": 13,
     *         "subprefeitura_id": 5,
     *         "unidade": "Unidade exemplo"
     *     }
     * }
     */
    public function store(ServicoLocalFormRequest $request)
    {
        $servicoLocal = new ServicoLocal;
        $servicoLocal->contrato_id = $request->input('contrato_id');
        $servicoLocal->regiao = $request->input('regiao');
        $servicoLocal->distrito_id = $request->input('distrito_id');
        $servicoLocal->subprefeitura_id = $request->input('subprefeitura_id');
        $servicoLocal->unidade = $request->input('unidade');

        if ($servicoLocal->save()) {
            return new ServicoLocalResource($servicoLocal);
        }
    }

    /**
     * Mostra um serviço local específico
     * @authenticated
     *
     *
     * @urlParam id integer required ID do serviço local. Example: 1
     *
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "contrato_id": 5,
     *         "distrito_id": 13,
     *         "subprefeitura_id": 5,
     *         "unidade": "Unidade exemplo"
     *     }
     * }
     */
    public function show($id)
    {
        $servicoLocal = ServicoLocal::findOrFail($id);
        return new ServicoLocalResource($servicoLocal);
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
     * Edita um serviço local
     * @authenticated
     *
     *
     * @urlParam id integer required ID do serviço local que deseja editar. Example: 1
     *
     * @bodyParam contrato_id integer required ID do contrato. Example: 5
     * @bodyParam distrito_id integer required ID do distrito. Example: 13
     * @bodyParam subprefeitura_id integer required ID da subprefeitura. Example: 5
     * @bodyParam unidade string required Nome da unidade. Example: Unidade exemplo
     *
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "contrato_id": 5,
     *         "distrito_id": 13,
     *         "subprefeitura_id": 5,
     *         "unidade": "Unidade exemplo"
     *     }
     * }
     */
    public function update(ServicoLocalFormRequest $request, $id)
    {
        $servicoLocal = ServicoLocal::findOrFail($request->id);
        $servicoLocal->contrato_id = $request->input('contrato_id');
        $servicoLocal->distrito_id = $request->input('distrito_id');
        $servicoLocal->regiao = $request->input('regiao');
        $servicoLocal->subprefeitura_id = $request->input('subprefeitura_id');
        $servicoLocal->unidade = $request->input('unidade');

        if ($servicoLocal->save()) {
            return new ServicoLocalResource($servicoLocal);
        }
    }

    /**
     * Deleta um serviço local
     * @authenticated
     *
     *
     * @urlParam id integer required ID do servico local que deseja deletar. Example: 1
     *
     * @response 200 {
     *     "message": "Serviço local deletado com sucesso!",
     *     "data": {
     *         "id": 1,
     *         "contrato_id": 5,
     *         "distrito_id": 13,
     *         "subprefeitura_id": 5,
     *         "unidade": "Unidade exemplo"
     *     }
     * }
     */
    public function destroy($id)
    {
        $servicoLocal = ServicoLocal::findOrFail($id);

        if ($servicoLocal->delete()) {
            return response()->json([
                'message' => 'Serviço local deletado com sucesso!',
                'data' => new ServicoLocalResource($servicoLocal)
            ]);
        }
    }

    /**
     * Lista os serviços locais pelo ID do contrato
     * @authenticated
     *
     *
     * @urlParam id integer required ID do contrato. Example: 5
     *
     * @response 200 {
     *     "data": {
     *         "id": 1,
     *         "contrato_id": 5,
     *         "distrito_id": 13,
     *         "subprefeitura_id": 5,
     *         "unidade": "Unidade exemplo"
     *     }
     * }
     */
    public function listar_por_contrato($id)
    {
        $servicosLocais = ServicoLocal::query()
            ->where('contrato_id','=',$id)
            ->orderBy('regiao')
            ->get();

        return ServicoLocalResource::collection($servicosLocais);
    }
}
