<?php

namespace App\Http\Controllers;

use App\Http\Requests\DevolucaoFormRequest;
use App\Models\Devolucoes;
use Illuminate\Http\Request;

class DevolucoesController extends Controller
{
    /**
     * Lista todas as devoluções cadastradas do contrato.
     * 
     *   @response 202 {
     *       "data": [
     *         {
     *         "id": 1,
     *         "contrato_id": 1,
     *         "data_devolucao": "2024-01-24",
     *         "numero_devolucao": 99.999,
     *         "valor": 654231,
     *         "created_at": null,
     *         "updated_at": null
     *         }
     *      ]
     *   }
     */
    public function index($id)
    {
        $devolucao = Devolucoes::where('contrato_id', $id)->get();
        
        return response()->json([
            'data' => $devolucao
        ], 202);
    }

    /**
     * Cria uma nova devolução
     * 
     * @bodyparam contrato_id interger required numero do contrato. Example: 1
     * @bodyParam data_devolucao date required data da devolução. Example: "2024/01/24"
     * @bodyParam numero_devolucao integer required numero da devolução. Example: 99.999
     * @bodyParam valor float required Valor da devolução. Example: 654231.00
     *
     * @response 202 {
     *  {
     *      "mensagem": "Devolução cadastrada com sucesso!",
     *      "devolucao": {
     *          "contrato_id": 1,
     *          "data_devolucao": "2024/01/24",
     *          "numero_devolucao": 99.999,
     *          "valor": 654231,
     *          "updated_at": "2024-01-29T18:27:25.000000Z",
     *          "created_at": "2024-01-29T18:27:25.000000Z",
     *          "id": 2
     *      }
     *  }
     */
    public function create(DevolucaoFormRequest $request)
    {
        $devolucao = new Devolucoes();

        $devolucao->contrato_id = $request->input('contrato_id');
        $devolucao->data_devolucao = $request->input('data_devolucao');
        $devolucao->numero_devolucao = str_replace('.','',$request->input('numero_devolucao'));
        $devolucao->valor = str_replace(',','.',str_replace('.','',$request->input('valor')));

        if($devolucao->save()){
            return response()->json([
                'mensagem' => 'Devolução cadastrada com sucesso!',
                'devolucao' => $devolucao
            ], 202);
        }
    }
    
    /**
     * Mostra uma devolução
     * 
     * @UrlParam id integer required ID da devolução. Example: 1
     * 
     * @response 202 {
     *     "mensagem": "Devolução encontrada!",
     *     "devolucao": {
     *         "id": 1,
     *         "contrato_id": 1,
     *         "data_devolucao": "2024-01-24",
     *         "numero_devolucao": 99.999,
     *         "valor": 654231,
     *         "created_at": null,
     *         "updated_at": null
     *     }
     *   }
     */
    public function show($id)
    {
        $devolucao = Devolucoes::find($id);

        if($devolucao){
            return response()->json([
                'mensagem' => 'Devolução encontrada!',
                'devolucao' => $devolucao
            ]);
        }
    }

    /**
     * Edita uma devolução
     * 
     * @UrlParam id integer required ID da devolução. Example: 1
     * 
     * @bodyParam contrato_id integer required id do contraro. Example: 1574862
     * @bodyParam data_devolucao date required data da devolução. Example: 2024/01/23
     * @bodyParam numero_devolucao integer required numero da devolução. Example: nova
     * @bodyParam valor float required Valor da nota reserva. Example: 100000.00
     * 
     * @response 202 {
     *          "mensagem": "Devolução editada com sucesso.",
     *          "devolucao": {
     *              "id": 2,
     *              "contrato_id": 1,
     *              "data_devolucao": "2024/01/24",
     *              "numero_devolucao": 99.999,
     *              "valor": 100000,
     *              "created_at": "2024-01-29T18:27:25.000000Z",
     *              "updated_at": "2024-01-29T18:38:18.000000Z"
     *          }
     *      }
     */
    public function edit(DevolucaoFormRequest $request, $id)
    {
        $devolucao = Devolucoes::find($id);
        
        $devolucao->contrato_id = $request->input('contrato_id');
        $devolucao->data_devolucao = $request->input('data_devolucao');
        $devolucao->numero_devolucao = str_replace('.','',$request->input('numero_devolucao'));
        $devolucao->valor = str_replace(',','.',str_replace('.','',$request->input('valor')));

        if($devolucao->update()){
            return response()->json([
                'mensagem' => 'Devolução editada com sucesso.',
                'devolucao' => $devolucao
            ]);
        }
    }

    /**
     * Deleta uma devolução
     * 
     * @UrlParam id integer required ID da devolução. Example: 2

     * @response 202 {
     *     "mensagem" : "Devolução deletada."
     *     }
     */
    public function delete($id)
    {
        $devolucao = Devolucoes::find($id);

        if($devolucao->delete()){
            return response()->json([
                'mensagem' => 'Devolução deletada.'
            ], 202);
        }
    }
}
