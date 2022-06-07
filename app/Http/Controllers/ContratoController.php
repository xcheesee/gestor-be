<?php

namespace App\Http\Controllers;

use App\Models\Contrato as Contrato;
use App\Http\Resources\Contrato as ContratoResource;
use Illuminate\Http\Request;

/**
 * @group Contrato
 *
 * APIs para listar, cadastrar, editar e remover dados de contrato
 */
class ContratoController extends Controller
{
    /**
     * Lista os contratos
     * @authenticated
     *
     *
     */
    public function index()
    {
        $contratos = Contrato::paginate(15);
        return ContratoResource::collection($contratos);
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
     * Cadastra um novo contrato
     * @authenticated
     *
     *
     * @bodyParam processo_sei string required Processo SEI. Example: 0123000134569000
     * @bodyParam credor string required Nome do credor. Example: Teste Silva
     * @bodyParam cnpj_cpf string required Cnpj ou Cpf. Example: 45106963896
     * @bodyParam objeto string required Objeto. Example: teste
     * @bodyParam numero_contrato string required Número do contrato. Example: 2343rbte67b63
     * @bodyParam data_assinatura date Data de assinatura do contrato. Example: 2022-05-20
     * @bodyParam valor_contrato float required Valor do contrato. Example: 1500
     * @bodyParam data_inicio_vigencia date required Data de inicio da vigência. Example: 2022-05-23
     * @bodyParam data_fim_vigencia date Data de fim da vigência. Example: 2023-05-20
     * @bodyParam condicao_pagamento string required Condição do pagamento. Example: Em até 10 dias após adimplemento
     * @bodyParam prazo_contrato_meses integer required Prazo do contrato em meses. Example: 12
     * @bodyParam prazo_a_partir_de string Condição do início do prazo. Example: A partir do início da vigência
     * @bodyParam data_prazo_maximo date O prazo máximo do contrato. Example: 2023-06-20
     * @bodyParam nome_empresa string required Nome da empresa. Example: Teste LTDA
     * @bodyParam telefone_empresa string required Telefone da empresa. Example: 11913314554
     * @bodyParam email_empresa string required E-Mail da empresa. Example: teste@prefeitura.com
     * @bodyParam outras_informacoes text Informações adicionais. Example: Exemplo. Nenhuma outra informação
     *
     * @response 200 {
     *     "data": {
     *         "id": 14,
     *         "processo_sei": "0123000134569000",
     *         "credor": "Teste Silva",
     *         "cnpj_cpf": "45106963896",
     *         "objeto": "teste",
     *         "numero_contrato": "2343rbte67b63",
     *         "data_assinatura": "2022-05-20",
     *         "valor_contrato": 1500,
     *         "data_inicio_vigencia": "2022-05-23",
     *         "data_fim_vigencia": "2023-05-20",
     *         "condicao_pagamento": "Após 10 dias após adimplemento",
     *         "prazo_contrato_meses": 12,
     *         "prazo_a_partir_de": "A partir do início da vigência",
     *         "data_prazo_maximo": "2023-06-20",
     *         "nome_empresa": "Teste LTDA",
     *         "telefone_empresa": "11913314554",
     *         "email_empresa": "teste@prefeitura.com",
     *         "outras_informacoes": "Exemplo. Nenhuma outra informação"
     *     }
     * }
     */
    public function store(Request $request)
    {
        $contrato = new Contrato;
        $contrato->processo_sei = $request->input('processo_sei');
        $contrato->credor = $request->input('credor');
        $contrato->cnpj_cpf = $request->input('cnpj_cpf');
        $contrato->objeto = $request->input('objeto');
        $contrato->numero_contrato = $request->input('numero_contrato');
        $contrato->data_assinatura = $request->input('data_assinatura');
        $contrato->valor_contrato = $request->input('valor_contrato');
        $contrato->data_inicio_vigencia = $request->input('data_inicio_vigencia');
        $contrato->data_fim_vigencia = $request->input('data_fim_vigencia');
        $contrato->condicao_pagamento = $request->input('condicao_pagamento');
        $contrato->prazo_contrato_meses = $request->input('prazo_contrato_meses');
        $contrato->prazo_a_partir_de = $request->input('prazo_a_partir_de');
        $contrato->data_prazo_maximo = $request->input('data_prazo_maximo');
        $contrato->nome_empresa = $request->input('nome_empresa');
        $contrato->telefone_empresa = $request->input('telefone_empresa');
        $contrato->email_empresa = $request->input('email_empresa');
        $contrato->outras_informacoes = str_replace("\n",'<br />', addslashes(htmlspecialchars($request->input('outras_informacoes'))));

        if ($contrato->save()) {
            return new ContratoResource($contrato);
        }
    }

    /**
     * Mostra um contrato específico
     * @authenticated
     *
     *
     * @urlParam id integer required ID do contrato. Example: 14
     *
     * @response 200 {
     *     "data": {
     *         "id": 14,
     *         "processo_sei": "0123000134569000",
     *         "credor": "Teste Silva",
     *         "cnpj_cpf": "45106963896",
     *         "objeto": "teste",
     *         "numero_contrato": "2343rbte67b63",
     *         "data_assinatura": "2022-05-20",
     *         "valor_contrato": 1500,
     *         "data_inicio_vigencia": "2022-05-23",
     *         "data_fim_vigencia": "2023-05-20",
     *         "condicao_pagamento": "Após 10 dias após adimplemento",
     *         "prazo_contrato_meses": 12,
     *         "prazo_a_partir_de": "A partir do início da vigência",
     *         "data_prazo_maximo": "2023-06-20",
     *         "nome_empresa": "Teste LTDA",
     *         "telefone_empresa": "11913314554",
     *         "email_empresa": "teste@prefeitura.com",
     *         "outras_informacoes": "Exemplo. Nenhuma outra informação"
     *     }
     * }
     */
    public function show($id)
    {
        $contrato = Contrato::findOrFail($id);
        return new ContratoResource($contrato);
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
     * Edita um contrato
     * @authenticated
     *
     *
     * @urlParam id integer required ID do contrato que deseja editar. Example: 14
     *
     * @bodyParam processo_sei string required Processo SEI. Example: 0123000134569000
     * @bodyParam credor string required Nome do credor. Example: Teste Silva
     * @bodyParam cnpj_cpf string required Cnpj ou Cpf. Example: 45106963896
     * @bodyParam objeto string required Objeto. Example: teste
     * @bodyParam numero_contrato string required Número do contrato. Example: 2343rbte67b63
     * @bodyParam data_assinatura date Data de assinatura do contrato. Example: 2022-05-21
     * @bodyParam valor_contrato float required Valor do contrato. Example: 1600
     * @bodyParam data_inicio_vigencia date required Data de inicio da vigência. Example: 2022-05-24
     * @bodyParam data_fim_vigencia date Data de fim da vigência. Example: 2023-05-21
     * @bodyParam condicao_pagamento string required Condição do pagamento. Example: Em até 10 dias após adimplemento
     * @bodyParam prazo_contrato_meses integer required Prazo do contrato em meses. Example: 12
     * @bodyParam prazo_a_partir_de string Condição do início do prazo. Example: A partir do início da vigência
     * @bodyParam data_prazo_maximo date O prazo máximo do contrato. Example: 2023-06-21
     * @bodyParam nome_empresa string required Nome da empresa. Example: Teste LTDA
     * @bodyParam telefone_empresa string required Telefone da empresa. Example: 11913314554
     * @bodyParam email_empresa string required E-Mail da empresa. Example: teste@prefeitura.com
     * @bodyParam outras_informacoes text Informações adicionais. Example: Exemplo. Nenhuma outra informação
     *
     * @response 200 {
     *     "data": {
     *         "id": 14,
     *         "processo_sei": "0123000134569000",
     *         "credor": "Teste Silva",
     *         "cnpj_cpf": "45106963896",
     *         "objeto": "teste",
     *         "numero_contrato": "2343rbte67b63",
     *         "data_assinatura": "2022-05-21",
     *         "valor_contrato": 1600,
     *         "data_inicio_vigencia": "2022-05-24",
     *         "data_fim_vigencia": "2023-05-21",
     *         "condicao_pagamento": "Após 10 dias após adimplemento",
     *         "prazo_contrato_meses": 12,
     *         "prazo_a_partir_de": "A partir do início da vigência",
     *         "data_prazo_maximo": "2023-06-21",
     *         "nome_empresa": "Teste LTDA",
     *         "telefone_empresa": "11913314554",
     *         "email_empresa": "teste@prefeitura.com",
     *         "outras_informacoes": "Exemplo. Nenhuma outra informação"
     *     }
     * }
     */
    public function update(Request $request, $id)
    {
        $contrato = Contrato::findOrFail($request->id);
        $contrato->processo_sei = $request->input('processo_sei');
        $contrato->credor = $request->input('credor');
        $contrato->cnpj_cpf = $request->input('cnpj_cpf');
        $contrato->objeto = $request->input('objeto');
        $contrato->numero_contrato = $request->input('numero_contrato');
        $contrato->data_assinatura = $request->input('data_assinatura');
        $contrato->valor_contrato = $request->input('valor_contrato');
        $contrato->data_inicio_vigencia = $request->input('data_inicio_vigencia');
        $contrato->data_fim_vigencia = $request->input('data_fim_vigencia');
        $contrato->condicao_pagamento = $request->input('condicao_pagamento');
        $contrato->prazo_contrato_meses = $request->input('prazo_contrato_meses');
        $contrato->prazo_a_partir_de = $request->input('prazo_a_partir_de');
        $contrato->data_prazo_maximo = $request->input('data_prazo_maximo');
        $contrato->nome_empresa = $request->input('nome_empresa');
        $contrato->telefone_empresa = $request->input('telefone_empresa');
        $contrato->email_empresa = $request->input('email_empresa');
        $contrato->outras_informacoes = $request->input('outras_informacoes');

        if ($contrato->save()) {
            return new ContratoResource($contrato);
        }
    }

    /**
     * Deleta um contrato
     * @authenticated
     *
     *
     * @urlParam id integer required ID do contrato que deseja deletar. Example: 14
     *
     * @response 200 {
     *     "message": "Contrato deletado com sucesso!",
     *     "data": {
     *         "id": 14,
     *         "processo_sei": "0123000134569000",
     *         "credor": "Teste Silva",
     *         "cnpj_cpf": "45106963896",
     *         "objeto": "teste",
     *         "numero_contrato": "2343rbte67b63",
     *         "data_assinatura": "2022-05-21",
     *         "valor_contrato": 1600,
     *         "data_inicio_vigencia": "2022-05-24",
     *         "data_fim_vigencia": "2023-05-21",
     *         "condicao_pagamento": "Após 10 dias após adimplemento",
     *         "prazo_contrato_meses": 12,
     *         "prazo_a_partir_de": "A partir do início da vigência",
     *         "data_prazo_maximo": "2023-06-21",
     *         "nome_empresa": "Teste LTDA",
     *         "telefone_empresa": "11913314554",
     *         "email_empresa": "teste@prefeitura.com",
     *         "outras_informacoes": "Exemplo. Nenhuma outra informação"
     *     }
     * }
     */
    public function destroy($id)
    {
        $contrato = Contrato::findOrFail($id);
        if ($contrato->delete()) {
            return response()->json([
                'message' => 'Contrato deletado com sucesso!',
                'data' => new ContratoResource($contrato)
            ]);
        }
    }
}
