<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use App\Http\Resources\Estado as EstadoResource;
use Illuminate\Http\Request;

/**
 * @group Estado
 *
 * APIs para listar, cadastrar, editar e remover dados de estado dos contratos
 */
class EstadoController extends Controller
{
   /**
    * Lista estado
    * @authenticated
    *
    *
    */
   public function index()
   {
       $estados = Estado::get();
       return EstadoResource::collection($estados);
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
    * Cadastra um novo estado
    * @authenticated
    *
    *
    * @bodyParam estados string Nome do estado. Example: Elaboração Material Técnico
    *
    * @response 200 {
    *     "data": {
    *         "id": 1,
    *         "valor": "Elaboração Material Técnico"
    *     }
    * }
    */
   public function store(Request $request)
   {
       $estado = new Estado;
       $estado->valor = $request->input('valor');
       if ($estado->save()) {
           return new EstadoResource($estado);
       }
   }

   /**
    * Mostra um estado específica
    * @authenticated
    *
    *
    * @urlParam id integer required ID do estado. Example: 1
    *
    * @response 200 {
    *     "data": {
    *         "id": 1,
    *         "valor": "Elaboração Material Técnico"
    *     }
    * }
    */
   public function show($id)
   {
       $estado = Estado::findOrFail($id);
       return new EstadoResource($estado);
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
    * Edita um estado
    * @authenticated
    *
    *
    * @urlParam id integer required ID do estado que deseja editar. Example: 1
    *
    * @bodyParam valor string Nome do estado. Example: Elaboração Material Técnico
    *
    * @response 200 {
    *     "data": {
    *         "id": 1,
    *         "valor": "Elaboração Material Técnico"
    *     }
    * }
    */
   public function update(Request $request, $id)
   {
       $estado = Estado::findOrFail($id);
       $estado->valor = $request->input('valor');

       if ($estado->save()) {
           return new EstadoResource($estado);
       }
   }

   /**
    * Deleta um estado
    * @authenticated
    *
    *
    * @urlParam id integer required ID do estado que deseja deletar. Example: 1
    *
    * @response 200 {
    *     "message": "Estado deletado com sucesso!",
    *     "data": {
    *         "id": 1,
    *         "valor": "Elaboração Material Técnico"
    *     }
    * }
    */
   public function destroy($id)
   {
       $estado = Estado::findOrFail($id);

       if ($estado->delete()) {
           return response()->json([
               'message' => 'Estado deletado com sucesso!',
               'data' => new EstadoResource($estado)
           ]);
       }
   }
}
