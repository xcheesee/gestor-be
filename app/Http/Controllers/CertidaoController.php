<?php

namespace App\Http\Controllers;

use App\Http\Requests\CertidaoFormRequest;
use App\Models\Certidao as Certidao;
use App\Http\Resources\Certidao as CertidaoResource;
use Illuminate\Http\Request;

/**
 * @group Certidão
 *
 * APIs para listar, cadastrar, editar e remover dados de certidão
 */
class CertidaoController extends Controller
{
    /**
     * Lista certidões
     * @authenticated
     *
     *
     */
    public function index()
    {
        $certidoes = Certidao::get();
        return CertidaoResource::collection($certidoes);
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
     * @bodyParam contrato_id integer required ID do contrato. Example: 13
     * @bodyParam certidoes string Nome da certidão. Example: Certidão negativa de débitos
     * @bodyParam validade_certidoes date Validade da certidão. Example: 2022-05-20
     *
     * @response 200 {
     *     "data": {
     *         "id": 24,
     *         "contrato_id": 13,
     *         "certidoes": "Certidão negativa de débitos",
     *         "validade_certidoes": "2022-05-20"
     *     }
     * }
     */
    public function store(CertidaoFormRequest $request)
    {
        $certidao = new Certidao;
        $certidao->contrato_id = $request->input('contrato_id');
        $certidao->certidoes = $request->input('certidoes');
        $certidao->validade_certidoes = $request->input('validade_certidoes');
        if ($certidao->save()) {
            return new CertidaoResource($certidao);
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
     *         "id": 24,
     *         "contrato_id": 13,
     *         "certidoes": "Certidão negativa de débitos",
     *         "validade_certidoes": "2022-05-20"
     *     }
     * }
     */
    public function show($id)
    {
        $certidao = Certidao::findOrFail($id);
        return new CertidaoResource($certidao);
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
     * @bodyParam certidoes string Nome da certidão. Example: Certidão negativa de débitos
     * @bodyParam validade_certidoes date Validade da certidão. Example: 2023-06-21
     *
     * @response 200 {
     *     "data": {
     *         "id": 24,
     *         "contrato_id": 14,
     *         "certidoes": "Certidão negativa de débitos",
     *         "validade_certidoes": "2023-06-21"
     *     }
     * }
     */
    public function update(Request $request, $id)
    {
        $certidao = Certidao::findOrFail($id);
        $certidao->contrato_id = $request->input('contrato_id');
        $certidao->certidoes = $request->input('certidoes');
        $certidao->validade_certidoes = $request->input('validade_certidoes');

        if ($certidao->save()) {
            return new CertidaoResource($certidao);
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
     *         "certidoes": "Certidão negativa para débitos",
     *         "validade_certidoes": "2023-06-21"
     *     }
     * }
     */
    public function destroy($id)
    {
        $certidao = Certidao::findOrFail($id);

        if ($certidao->delete()) {
            return response()->json([
                'message' => 'Certidão deletada com sucesso!',
                'data' => new CertidaoResource($certidao)
            ]);
        }
    }

    /**
     * Lista as certidões pelo ID do contrato
     * @authenticated
     *
     *
     * @urlParam id integer required ID do contrato. Example: 1
     *
     * @response 200 {
     *     "data": [
     *         {
     *             "id": 3,
     *             "contrato_id": 1,
     *             "certidoes": "abc",
     *             "validade_certidoes": "2022-06-17"
     *         },
     *         {
     *             "id": 21,
     *             "contrato_id": 1,
     *             "certidoes": "stu",
     *             "validade_certidoes": "2022-06-23"
     *         }
     *     ]
     * }
     */
    public function listar_por_contrato($id)
    {
        $certidoes = Certidao::query()
            ->where('contrato_id','=',$id)
            ->get();

        return CertidaoResource::collection($certidoes);
    }
}
