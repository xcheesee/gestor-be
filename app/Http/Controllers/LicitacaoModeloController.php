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
    public function index(Request $request)
    {
        $is_api_request = in_array('api',$request->route()->getAction('middleware'));

        $licitacao_modelos = LicitacaoModelo::get();

        if ($is_api_request){
            return LicitacaoModeloResource::collection($licitacao_modelos);
        }

        $mensagem = $request->session()->get('mensagem');
        return view ('cadaux.licitacao_modelo', compact('licitacao_modelos','mensagem'));
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
        $is_api_request = in_array('api',$request->route()->getAction('middleware'));
        $licitacao_modelo = new LicitacaoModelo;
        $licitacao_modelo->nome = $request->input('nome');

        if ($licitacao_modelo->save()) {
            if ($is_api_request) {
                return new LicitacaoModeloResource($licitacao_modelo);
            }

            $request->session()->flash('mensagem',"Modalidade de Licitação '{$licitacao_modelo->nome}' criada com sucesso, ID {$licitacao_modelo->id}.");
            return redirect()->route('cadaux-licitacao_modelos');
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
        $is_api_request = in_array('api',$request->route()->getAction('middleware'));
        $licitacao_modelo = LicitacaoModelo::findOrFail($request->id);
        $licitacao_modelo->nome = $request->input('nome');

        if ($licitacao_modelo->save()) {
            if ($is_api_request){
                return new LicitacaoModeloResource($licitacao_modelo);
            }

            return response()->json(['mensagem' => "Modalidade de Licitação '{$licitacao_modelo->nome}' - ID {$licitacao_modelo->id} editada com sucesso!"], 200);
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
