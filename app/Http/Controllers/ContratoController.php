<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContratoFormRequest;
use App\Models\Contrato as Contrato;
use App\Http\Resources\Contrato as ContratoResource;
use App\Models\Planejada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
     * @bodyParam tipo_contratacao_id integer ID do tipo de contrataçãi. Example: 1
     * @bodyParam processo_sei string required Processo SEI. Example: 6027.2019/0007357-2
     * @bodyParam dotacao_orcamentaria string required Número da Dotação Orçamentária Example: 27.10.18.126.3024.2171.33904000.00
     * @bodyParam credor string required Nome do credor. Example: Teste Silva
     * @bodyParam cnpj_cpf string required Cnpj ou Cpf. Example: 45106963896
     * @bodyParam objeto string required Objeto. Example: teste
     * @bodyParam numero_contrato string required Número do contrato. Example: 052/SVMA/2019
     * @bodyParam data_assinatura date Data de assinatura do contrato. Example: 2022-05-20
     * @bodyParam valor_contrato float required Valor do contrato. Example: 1200.00
     * @bodyParam valor_mensal_estimativo float Valor estimnado do contrato a ser executado mensalmente. Example: 100.00
     * @bodyParam data_inicio_vigencia date required Data de inicio da vigência. Example: 2022-05-23
     * @bodyParam data_vencimento date Data de vencimento do contrato. Example: 2023-05-20
     * @bodyParam condicao_pagamento string required Condição do pagamento. Example: Em até 10 dias após adimplemento
     * @bodyParam prazo_a_partir_de string Condição do início do prazo. Example: A partir do início da vigência
     * @bodyParam data_prazo_maximo date O prazo máximo do contrato. Example: 2023-06-20
     * @bodyParam nome_empresa string required Nome da empresa. Example: Teste LTDA
     * @bodyParam telefone_empresa string required Telefone da empresa. Example: 11913314554
     * @bodyParam email_empresa string required E-Mail da empresa. Example: teste@prefeitura.com
     * @bodyParam outras_informacoes text Informações adicionais. Example: Exemplo. Nenhuma outra informação
     * @bodyParam envio_material_tecnico date O prazo para envio do Material Técnico. Example: 2023-05-20
     * @bodyParam minuta_edital date O prazo para envio do Material Técnico. Example: 2023-05-21
     * @bodyParam abertura_certame date O prazo para envio do Material Técnico. Example: 2023-05-21
     * @bodyParam homologacao date O prazo para envio do Material Técnico. Example: 2023-05-21
     * @bodyParam fonte_recurso text Local ou Organização fonte do recurso. Example: Tesouro
     *
     * @response 200 {
     *     "data": {
     *         "id": 14,
     *         "tipo_contratacao_id": 1,
     *         "processo_sei": "0123000134569000",
     *         "dotacao_orcamentaria": "2122123456789456465456465",
     *         "credor": "Teste Silva",
     *         "cnpj_cpf": "45106963896",
     *         "tipo_objeto": "serviço",
     *         "objeto": "teste",
     *         "numero_contrato": "2343rbte67b63",
     *         "data_assinatura": "2022-05-20",
     *         "valor_contrato": 1200,
     *         "valor_mensal_estimativo": 100,
     *         "data_inicio_vigencia": "2022-05-23",
     *         "data_vencimento": "2023-05-20",
     *         "condicao_pagamento": "Após 10 dias após adimplemento",
     *         "prazo_a_partir_de": "A partir do início da vigência",
     *         "data_prazo_maximo": "2023-06-20",
     *         "nome_empresa": "Teste LTDA",
     *         "telefone_empresa": "11913314554",
     *         "email_empresa": "teste@prefeitura.com",
     *         "outras_informacoes": "Exemplo. Nenhuma outra informação",
     *         "envio_material_tecnico": "2022-06-20",
     *         "minuta_edital": "2022-06-21",
     *         "abertura_certame": "2022-06-22",
     *         "homologacao": "2022-06-23",
     *         "fonte_recurso": "Tesouro"
     *     }
     * }
     */
    public function store(ContratoFormRequest $request)
    {
        $contrato = new Contrato();
        $contrato->tipo_contratacao_id = $request->input('tipo_contratacao_id');
        $contrato->processo_sei = $request->input('processo_sei');
        $contrato->dotacao_orcamentaria = $request->input('dotacao_orcamentaria');
        $contrato->credor = $request->input('credor');
        $contrato->cnpj_cpf = $request->input('cnpj_cpf');
        $contrato->tipo_objeto = $request->input('tipo_objeto');
        $contrato->objeto = $request->input('objeto');
        $contrato->numero_contrato = $request->input('numero_contrato');
        $contrato->data_assinatura = $request->input('data_assinatura');
        $contrato->valor_contrato = $request->input('valor_contrato');
        $contrato->valor_mensal_estimativo = $request->input('valor_mensal_estimativo');
        $contrato->data_inicio_vigencia = $request->input('data_inicio_vigencia');
        $contrato->data_vencimento = $request->input('data_vencimento');
        $contrato->condicao_pagamento = $request->input('condicao_pagamento');
        $contrato->prazo_a_partir_de = $request->input('prazo_a_partir_de');
        $contrato->data_prazo_maximo = $request->input('data_prazo_maximo');
        $contrato->nome_empresa = $request->input('nome_empresa');
        $contrato->telefone_empresa = $request->input('telefone_empresa');
        $contrato->email_empresa = $request->input('email_empresa');
        $contrato->outras_informacoes = str_replace("\n",'<br />', addslashes(htmlspecialchars($request->input('outras_informacoes'))));
        $contrato->envio_material_tecnico = $request->input('envio_material_tecnico');
        $contrato->minuta_edital = $request->input('minuta_edital');
        $contrato->abertura_certame = $request->input('abertura_certame');
        $contrato->homologacao = $request->input('homologacao');
        $contrato->fonte_recurso = $request->input('fonte_recurso');

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

        $planejadas = DB::table('planejadas')
                        ->selectRaw('mes,ano,SUM(valor_planejado) as planejado')
                        ->where('contrato_id','=',$id)->groupByRaw('ano,mes')->get();
        $executadas = DB::table('executadas')
                        ->selectRaw('mes,ano,SUM(valor_executado) as executado')
                        ->where('contrato_id','=',$id)->groupByRaw('ano,mes')->get();

        $execucao_financeira = array();
        $meses = array('','Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez');
        foreach($planejadas as $planejada){
            $execucao_financeira[$planejada->mes.'-'.$planejada->ano]['mes'] = $meses[$planejada->mes].'-'.$planejada->ano;
            $execucao_financeira[$planejada->mes.'-'.$planejada->ano]['planejado'] = $planejada->planejado;
            $execucao_financeira[$planejada->mes.'-'.$planejada->ano]['executado'] = 0.00;
        }
        foreach($executadas as $executada){
            $execucao_financeira[$executada->mes.'-'.$executada->ano]['executado'] = $executada->executado;
        }

        $execucaoFinanceira = (object) $execucao_financeira;
        $contrato->execucao_financeira = $execucaoFinanceira;

        $contratoResource = new ContratoResource($contrato);
        return $contratoResource;
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
