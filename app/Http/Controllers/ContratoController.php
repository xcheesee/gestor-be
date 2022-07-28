<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContratoFormRequest;
use App\Models\Contrato as Contrato;
use App\Http\Resources\Contrato as ContratoResource;
use App\Http\Resources\ContratoTotalizadores;
use App\Http\Resources\ContratoVencimento as ContratoVencimentoResource;
use App\Models\ExecucaoFinanceira;
use App\Models\Planejada;
use App\Models\Dotacao;
use App\Models\EmpenhoNota;
use App\Models\AditamentoValor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

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
     * @queryParam filter[processo_sei] Filtro de número do processo. Example: 0123000134569000
     * @queryParam filter[nome_empresa] Filtro de nome completo ou parte do nome da empresa. Example: Teste SA
     * @queryParam filter[inicio_depois_de] Filtro inicial de período da data de início da vigência. Example: 2022-01-01
     * @queryParam filter[inicio_antes_de] Filtro final de período da data de início da vigência. Example: 2022-05-20
     * @queryParam filter[vencimento_depois_de] Filtro inicial de período da data de vencimento do contrato. Example: 2023-01-01
     * @queryParam filter[vencimento_antes_de] Filtro final de período da data de vencimento do contrato. Example: 2023-12-31
     * @queryParam sort Campo a ser ordenado (padrão ascendente, inserir um hífen antes para decrescente). Colunas possíveis: 'id', 'processo_sei', 'credor', 'nome_empresa', 'numero_contrato', 'data_inicio_vigencia', 'data_vencimento' Example: -processo_sei
     *
     */
    public function index()
    {
        $contratos = QueryBuilder::for(Contrato::class)
            ->allowedFilters([
                    'processo_sei', 'nome_empresa',
                    AllowedFilter::scope('inicio_depois_de'),
                    AllowedFilter::scope('inicio_antes_de'),
                    AllowedFilter::scope('vencimento_depois_de'),
                    AllowedFilter::scope('vencimento_antes_de'),
                ])
            ->allowedSorts('id', 'processo_sei', 'credor', 'nome_empresa', 'numero_contrato', 'data_inicio_vigencia', 'data_vencimento')
            ->paginate(15);
        return ContratoResource::collection($contratos);
    }

    /**
     * Lista os contratos com data de vencimento menor do que 6 meses.
     * @authenticated
     *
     * @response 200 {
     *     "data": [{
     *         "id": 14,
     *         "processo_sei": "0123000134569000",
     *         "cnpj_cpf": "45106963896",
     *         "numero_contrato": "2343rbte67b63",
     *         "data_vencimento": "2023-05-20",
     *         "nome_empresa": "Teste LTDA",
     *         "telefone_empresa": "11913314554",
     *         "email_empresa": "teste@prefeitura.com",
     *         "dias_ate_vencimento": 163,
     *         "meses_ate_vencimento": "5 meses e 10 dia(s)"
     *     },
     *     {
     *         "id": 11,
     *         "processo_sei": "0000000000000016",
     *         "cnpj_cpf": "00100200345",
     *         "numero_contrato": "005SVMA2022",
     *         "data_vencimento": "2022-12-14",
     *         "nome_empresa": "Honos",
     *         "telefone_empresa": "11910203040",
     *         "email_empresa": "lucashonorato@gmail.com",
     *         "dias_ate_vencimento": 146,
     *         "meses_ate_vencimento": "4 meses e 24 dia(s)"
     *     }]
     * }
     */
    public function contratos_vencimento() {

        $contratosVencimento = Contrato::query()->whereRaw('DATEDIFF(data_vencimento, NOW()) <= 182')->get();
        return ContratoVencimentoResource::collection($contratosVencimento);
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
     * @bodyParam departamento_id integer ID do departamento. Example: 2
     * @bodyParam licitacao_modelo_id integer ID do modelo de licitação. Example: 1
     * @bodyParam envio_material_tecnico date Data do envio de material técnico. Example: 2022-06-20
     * @bodyParam minuta_edital date Data do minuta do edital. Example: 2022-06-21
     * @bodyParam abertura_certame date Data da abertura do certame. Example: 2022-06-22
     * @bodyParam homologacao date Data de homologação. Example: 2022-06-23
     * @bodyParam processo_sei string required Processo SEI. Example: 0123000134569000
     * @bodyParam credor string required Nome do credor. Example: Teste Silva
     * @bodyParam cnpj_cpf string required Cnpj ou Cpf. Example: 45106963896
     * @bodyParam tipo_objeto string Tipo de Objeto ('obra','projeto','serviço' ou 'aquisição'). Example: projeto
     * @bodyParam objeto string required Objeto. Example: teste
     * @bodyParam numero_contrato string required Número do contrato. Example: 2343rbte67b63
     * @bodyParam data_assinatura date Data de assinatura do contrato. Example: 2022-05-21
     * @bodyParam valor_contrato float required Valor do contrato. Example: 1600
     * @bodyParam valor_mensal_estimativo float required Valor do contrato. Example: 1600
     * @bodyParam data_inicio_vigencia date required Data de inicio da vigência. Example: 2022-05-24
     * @bodyParam data_vencimento date Data de fim da vigência. Example: 2023-05-21
     * @bodyParam condicao_pagamento string required Condição do pagamento. Example: Em até 10 dias após adimplemento
     * @bodyParam prazo_a_partir_de string Condição do início do prazo. Example: A partir do início da vigência
     * @bodyParam data_prazo_maximo date O prazo máximo do contrato. Example: 2023-06-21
     * @bodyParam nome_empresa string required Nome da empresa. Example: Teste LTDA
     * @bodyParam numero_nota_reserva string Número da última nota de reserva. Example: 1024
     * @bodyParam valor_reserva float Valor total de reserva. Example: 200.00
     * @bodyParam telefone_empresa string required Telefone da empresa. Example: 11913314554
     * @bodyParam email_empresa string required E-Mail da empresa. Example: teste@prefeitura.com
     * @bodyParam outras_informacoes text Informações adicionais. Example: Exemplo. Nenhuma outra informação
     *
     * @response 200 {
     *     "data": {
     *         "id": 14,
     *         "departamento_id": 2,
     *         "departamento": "GABINETE/NDTIC",
     *         "licitacao_modelo_id": 1,
     *         "licitacao_modelo": "Concorrência",
     *         "envio_material_tecnico": "2022-06-20",
     *         "minuta_edital": "2022-06-21",
     *         "abertura_certame": "2022-06-22",
     *         "homologacao": "2022-06-23",
     *         "processo_sei": "0123000134569000",
     *         "credor": "Teste Silva",
     *         "cnpj_cpf": "45106963896",
     *         "tipo_objeto": "serviço",
     *         "objeto": "teste",
     *         "numero_contrato": "2343rbte67b63",
     *         "data_assinatura": "2022-05-20",
     *         "valor_contrato": 1200.00,
     *         "valor_mensal_estimativo": 100.00,
     *         "data_inicio_vigencia": "2022-05-23",
     *         "data_vencimento": "2023-05-20",
     *         "condicao_pagamento": "Após 10 dias após adimplemento",
     *         "prazo_a_partir_de": "A partir do início da vigência",
     *         "data_prazo_maximo": "2023-06-20",
     *         "numero_nota_reserva": "1024",
     *         "valor_reserva": "200.00",
     *         "nome_empresa": "Teste LTDA",
     *         "telefone_empresa": "11913314554",
     *         "email_empresa": "teste@prefeitura.com",
     *         "outras_informacoes": "Exemplo. Nenhuma outra informação",
     *     }
     * }
     */
    public function store(ContratoFormRequest $request)
    {
        $contrato = new Contrato();
        $contrato->licitacao_modelo_id = $request->input('licitacao_modelo_id');
        $contrato->envio_material_tecnico = $request->input('envio_material_tecnico');
        $contrato->minuta_edital = $request->input('minuta_edital');
        $contrato->abertura_certame = $request->input('abertura_certame');
        $contrato->homologacao = $request->input('homologacao');
        $contrato->processo_sei = $request->input('processo_sei');
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
        $contrato->numero_nota_reserva = $request->input('numero_nota_reserva');
        $contrato->valor_reserva = $request->input('valor_reserva');
        $contrato->nome_empresa = $request->input('nome_empresa');
        $contrato->telefone_empresa = $request->input('telefone_empresa');
        $contrato->email_empresa = $request->input('email_empresa');
        $contrato->outras_informacoes = $request->input('outras_informacoes');
        $contrato->user_id = auth()->user()->id;

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
     *         "departamento_id": 2,
     *         "departamento": "GABINETE/NDTIC",
     *         "licitacao_modelo_id": 1,
     *         "licitacao_modelo": "Concorrência",
     *         "envio_material_tecnico": "2022-06-20",
     *         "minuta_edital": "2022-06-21",
     *         "abertura_certame": "2022-06-22",
     *         "homologacao": "2022-06-23",
     *         "processo_sei": "0123000134569000",
     *         "credor": "Teste Silva",
     *         "cnpj_cpf": "45106963896",
     *         "tipo_objeto": "serviço",
     *         "objeto": "teste",
     *         "numero_contrato": "2343rbte67b63",
     *         "data_assinatura": "2022-05-20",
     *         "valor_contrato": 1200.00,
     *         "valor_mensal_estimativo": 100.00,
     *         "data_inicio_vigencia": "2022-05-23",
     *         "data_vencimento": "2023-05-20",
     *         "condicao_pagamento": "Após 10 dias após adimplemento",
     *         "prazo_a_partir_de": "A partir do início da vigência",
     *         "data_prazo_maximo": "2023-06-20",
     *         "numero_nota_reserva": "1024",
     *         "valor_reserva": "200.00",
     *         "nome_empresa": "Teste LTDA",
     *         "telefone_empresa": "11913314554",
     *         "email_empresa": "teste@prefeitura.com",
     *         "outras_informacoes": "Exemplo. Nenhuma outra informação",
     *         "execucao_financeira": {
     *             "1-2022": {
     *                 "id": "1",
     *                 "mes": "Jan-2022",
     *                 "planejado": 12000,
     *                 "executado": 10000.5,
     *                 "empenhado": 10500,
     *                 "saldo": 500.5
     *             },
     *             "2-2022": {
     *                 "id": "2",
     *                 "mes": "Fev-2022",
     *                 "planejado": 11999.99,
     *                 "executado": 0,
     *                 "empenhado": 0,
     *                 "saldo": 0
     *             }
     *         }
     *     }
     * }
     */
    public function show($id)
    {
        $contrato = Contrato::findOrFail($id);

        $executadas = ExecucaoFinanceira::query()->where('contrato_id','=',$id)->orderByRaw('ano,mes')->get();

        $execucao_financeira = array();
        $meses = array('','Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez');
        foreach($executadas as $executada){
            $execucao_financeira[$executada->mes.'-'.$executada->ano]['id'] = $executada->id;
            $execucao_financeira[$executada->mes.'-'.$executada->ano]['mes'] = $meses[$executada->mes].'-'.$executada->ano;
            $execucao_financeira[$executada->mes.'-'.$executada->ano]['planejado'] = $executada->planejado_inicial;
            $execucao_financeira[$executada->mes.'-'.$executada->ano]['contratado'] = $executada->contratado_atualizado;
            $execucao_financeira[$executada->mes.'-'.$executada->ano]['executado'] = $executada->executado ? $executada->executado : 0.00;
            $execucao_financeira[$executada->mes.'-'.$executada->ano]['empenhado'] = $executada->empenhado;
            $execucao_financeira[$executada->mes.'-'.$executada->ano]['saldo'] = $executada->saldo;
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
     * @bodyParam departamento_id integer ID do departamento. Example: 2
     * @bodyParam licitacao_modelo_id integer ID do modelo de licitação. Example: 1
     * @bodyParam envio_material_tecnico date Data do envio de material técnico. Example: 2022-06-20
     * @bodyParam minuta_edital date Data do minuta do edital. Example: 2022-06-21
     * @bodyParam abertura_certame date Data da abertura do certame. Example: 2022-06-22
     * @bodyParam homologacao date Data de homologação. Example: 2022-06-23
     * @bodyParam processo_sei string required Processo SEI. Example: 0123000134569000
     * @bodyParam credor string required Nome do credor. Example: Teste Silva
     * @bodyParam cnpj_cpf string required Cnpj ou Cpf. Example: 45106963896
     * @bodyParam tipo_objeto string Tipo de Objeto ('obra','projeto','serviço' ou 'aquisição'). Example: projeto
     * @bodyParam objeto string required Objeto. Example: teste
     * @bodyParam numero_contrato string required Número do contrato. Example: 2343rbte67b63
     * @bodyParam data_assinatura date Data de assinatura do contrato. Example: 2022-05-21
     * @bodyParam valor_contrato float required Valor do contrato. Example: 1600
     * @bodyParam valor_mensal_estimativo float required Valor do contrato. Example: 1600
     * @bodyParam data_inicio_vigencia date required Data de inicio da vigência. Example: 2022-05-24
     * @bodyParam data_vencimento date Data de fim da vigência. Example: 2023-05-21
     * @bodyParam condicao_pagamento string required Condição do pagamento. Example: Em até 10 dias após adimplemento
     * @bodyParam prazo_a_partir_de string Condição do início do prazo. Example: A partir do início da vigência
     * @bodyParam data_prazo_maximo date O prazo máximo do contrato. Example: 2023-06-21
     * @bodyParam nome_empresa string required Nome da empresa. Example: Teste LTDA
     * @bodyParam numero_nota_reserva string Número da última nota de reserva. Example: 1024
     * @bodyParam valor_reserva float Valor total de reserva. Example: 200.00
     * @bodyParam telefone_empresa string required Telefone da empresa. Example: 11913314554
     * @bodyParam email_empresa string required E-Mail da empresa. Example: teste@prefeitura.com
     * @bodyParam outras_informacoes text Informações adicionais. Example: Exemplo. Nenhuma outra informação
     *
     * @response 200 {
     *     "data": {
     *         "id": 14,
     *         "departamento_id": 2,
     *         "departamento": "GABINETE/NDTIC",
     *         "licitacao_modelo_id": 1,
     *         "licitacao_modelo": "Concorrência",
     *         "envio_material_tecnico": "2022-06-20",
     *         "minuta_edital": "2022-06-21",
     *         "abertura_certame": "2022-06-22",
     *         "homologacao": "2022-06-23",
     *         "processo_sei": "0123000134569000",
     *         "credor": "Teste Silva",
     *         "cnpj_cpf": "45106963896",
     *         "tipo_objeto": "serviço",
     *         "objeto": "teste",
     *         "numero_contrato": "2343rbte67b63",
     *         "data_assinatura": "2022-05-20",
     *         "valor_contrato": 1200.00,
     *         "valor_mensal_estimativo": 100.00,
     *         "data_inicio_vigencia": "2022-05-23",
     *         "data_vencimento": "2023-05-20",
     *         "condicao_pagamento": "Após 10 dias após adimplemento",
     *         "prazo_a_partir_de": "A partir do início da vigência",
     *         "data_prazo_maximo": "2023-06-20",
     *         "numero_nota_reserva": "1024",
     *         "valor_reserva": "200.00",
     *         "nome_empresa": "Teste LTDA",
     *         "telefone_empresa": "11913314554",
     *         "email_empresa": "teste@prefeitura.com",
     *         "outras_informacoes": "Exemplo. Nenhuma outra informação",
     *     }
     * }
     */
    public function update(ContratoFormRequest $request, $id)
    {
        $contrato = Contrato::findOrFail($id);
        $contrato->departamento_id = $request->input('departamento_id');
        $contrato->licitacao_modelo_id = $request->input('licitacao_modelo_id');
        $contrato->envio_material_tecnico = $request->input('envio_material_tecnico');
        $contrato->minuta_edital = $request->input('minuta_edital');
        $contrato->abertura_certame = $request->input('abertura_certame');
        $contrato->homologacao = $request->input('homologacao');
        $contrato->processo_sei = $request->input('processo_sei');
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
        $contrato->numero_nota_reserva = $request->input('numero_nota_reserva');
        $contrato->valor_reserva = $request->input('valor_reserva');
        $contrato->nome_empresa = $request->input('nome_empresa');
        $contrato->telefone_empresa = $request->input('telefone_empresa');
        $contrato->email_empresa = $request->input('email_empresa');
        $contrato->outras_informacoes = $request->input('outras_informacoes');
        $contrato->user_id = auth()->user()->id;

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
     *         "departamento_id": 2,
     *         "departamento": "GABINETE/NDTIC",
     *         "licitacao_modelo_id": 1,
     *         "licitacao_modelo": "Concorrência",
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
     *         "valor_contrato": 1500,
     *         "valor_reserva": 200,
     *         "valor_dotacoes": 199.90,
     *         "valor_empenhos": 500.50,
     *         "valor_aditamentos": 300
     *     }
     * }
     */
    public function exibeTotalizadores(int $id)
    {
        $contrato = Contrato::findOrFail($id);

        $dotacoes = Dotacao::query()->where('contrato_id','=',$id)->get();
        $empenhos = EmpenhoNota::query()->where('contrato_id','=',$id)->get();
        $executadas = ExecucaoFinanceira::query()->where('contrato_id','=',$id)->get();
        $aditamentos = AditamentoValor::query()->where('contrato_id','=',$id)->get();

        //array que irá retornar todos os valores solicitados. Os de contrato e reserva já se encontram no contrato, os demais precisamos somar
        $retorno = array();
        $retorno['id'] = $contrato->id;
        $retorno['valor_contrato'] = $contrato->valor_contrato;
        $retorno['valor_reserva'] = $contrato->valor_reserva > 0 ? $contrato->valor_reserva : 0;
        $retorno['valor_dotacoes'] = 0;
        $retorno['valor_empenhos'] = 0;
        $retorno['valor_planejados'] = 0;
        $retorno['valor_aditamentos'] = 0;

        foreach($dotacoes as $dotacao) {
            $retorno['valor_dotacoes'] += $dotacao->valor_dotacao;
        }

        foreach($empenhos as $empenho) {

            $total_empenho = $retorno['valor_empenhos'] += $empenho->valor_empenho;
    
                if ($empenho->tipo_empenho === "cancelamento" || $empenho->tipo_empenho === NULL) {
                    $valor_cancelamento_null = $empenho->valor_empenho;
        
                    $retorno['valor_empenhos'] = $total_empenho - ($valor_cancelamento_null * 2);
                }
        }    

        foreach($executadas as $executada){
            $retorno['valor_planejados'] += $executada->planejado_inicial;
        }

        foreach($aditamentos as $aditamento) {

            $total_aditamento = $retorno['valor_aditamentos'] += $aditamento->valor_aditamento;

                if ($aditamento->tipo_aditamento === "Redução de valor" || $aditamento->tipo_aditamento === NULL) {
                    $valor_reducao_null = $aditamento->valor_aditamento;

                    $retorno['valor_aditamentos'] = $total_aditamento - ($valor_reducao_null * 2);
                }
        }

        $retornoJson = (object) $retorno;

        $contratoResource = new ContratoTotalizadores($retornoJson);
        return $contratoResource;
    }
}
