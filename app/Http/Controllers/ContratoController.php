<?php

namespace App\Http\Controllers;

use App\Helpers\DepartamentoHelper;
use App\Http\Requests\ContratoFormRequest;
use App\Http\Requests\ContratoNovoRequest;
use App\Models\Contrato as Contrato;
use App\Http\Resources\Contrato as ContratoResource;
use App\Http\Resources\ContratoTotalizadores;
use App\Http\Resources\ContratoVencimento as ContratoVencimentoResource;
use App\Models\AditamentoPrazo;
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
     * @queryParam filter[departamento] Filtro de nome completo ou parte do nome da unidade requisitora. Example: Teste SA
     * @queryParam filter[inicio_depois_de] Filtro inicial de período da data de início da vigência. Example: 2022-01-01
     * @queryParam filter[inicio_antes_de] Filtro final de período da data de início da vigência. Example: 2022-05-20
     * @queryParam filter[vencimento_depois_de] Filtro inicial de período da data de vencimento do contrato. Example: 2023-01-01
     * @queryParam filter[vencimento_antes_de] Filtro final de período da data de vencimento do contrato. Example: 2023-12-31
     * @queryParam sort Campo a ser ordenado (padrão ascendente, inserir um hífen antes para decrescente). Colunas possíveis: 'id', 'processo_sei', 'credor', 'nome_empresa', 'numero_contrato', 'data_inicio_vigencia', 'data_vencimento' Example: -processo_sei
     *
     */
    public function index()
    {
        $user = auth()->user();
        $userDeptos = DepartamentoHelper::ids_deptos($user);

        $contratos = QueryBuilder::for(Contrato::class)
            ->select('empresas.nome as nome_empresa', 'departamentos.nome as nome_departamento', 'contratos.*', DB::raw('DATEDIFF(data_vencimento,data_inicio_vigencia) AS dias_vigente'))
            ->leftJoin('empresas', 'empresas.id', 'contratos.empresa_id')
            ->leftJoin('departamentos', 'departamentos.id', 'contratos.departamento_id')
            ->whereIn('contratos.departamento_id',$userDeptos)
            ->allowedFilters([
                    'processo_sei',
                    AllowedFilter::partial('nome_empresa','empresas.nome'),
                    AllowedFilter::partial('departamento','departamentos.nome'),
                    AllowedFilter::scope('inicio_depois_de'),
                    AllowedFilter::scope('inicio_antes_de'),
                    AllowedFilter::scope('vencimento_depois_de'),
                    AllowedFilter::scope('vencimento_antes_de'),
                ])
            ->allowedSorts('id', 'processo_sei', 'credor', 'nome_departamento', 'nome_empresa', 'numero_contrato',
                           'data_inicio_vigencia', 'data_vencimento', 'dias_vigente')
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
     * @bodyParam processo_sei string required Processo SEI. Example: 0123000134569000
     *
     * @response 200 {
     *     "data": {
     *         "id": 14,
     *         "departamento_id": 2,
     *         "departamento": "GABINETE/NDTIC",
     *         "empresa_id": 1,
     *         "nome_empresa": "Testes S.A.",
     *         "cnpj_empresa": "58.621.352/0001-44",
     *         "telefone_empresa": "11913314554",
     *         "email_empresa": "teste@prefeitura.com",
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
     *         "outras_informacoes": "Exemplo. Nenhuma outra informação",
     *     }
     * }
     */
    public function store(ContratoNovoRequest $request)
    {
        $contrato = new Contrato();
        $contrato->departamento_id = $request->input('departamento_id');
        $contrato->processo_sei = str_replace(array('.','-','/'),'',$request->input('processo_sei'));
        $contrato->estado_id = 1; //Cria contratos com o ID da primeira etapa
        // $contrato->licitacao_modelo_id = $request->input('licitacao_modelo_id');
        // $contrato->departamento_id = $request->input('departamento_id');
        // $contrato->envio_material_tecnico = $request->input('envio_material_tecnico');
        // $contrato->minuta_edital = $request->input('minuta_edital');
        // $contrato->abertura_certame = $request->input('abertura_certame');
        // $contrato->homologacao = $request->input('homologacao');
        // $contrato->credor = $request->input('credor');
        // $contrato->cnpj_cpf = $request->input('cnpj_cpf');
        // $contrato->tipo_objeto = $request->input('tipo_objeto');
        // $contrato->objeto = $request->input('objeto');
        // $contrato->numero_contrato = $request->input('numero_contrato');
        // $contrato->data_assinatura = $request->input('data_assinatura');
        // $contrato->valor_contrato = $request->input('valor_contrato');
        // $contrato->valor_mensal_estimativo = $request->input('valor_mensal_estimativo');
        // $contrato->data_inicio_vigencia = $request->input('data_inicio_vigencia');
        // $contrato->data_vencimento = $request->input('data_vencimento');
        // $contrato->condicao_pagamento = $request->input('condicao_pagamento');
        // $contrato->prazo_a_partir_de = $request->input('prazo_a_partir_de');
        // $contrato->data_prazo_maximo = $request->input('data_prazo_maximo');
        // $contrato->numero_nota_reserva = $request->input('numero_nota_reserva');
        // $contrato->valor_reserva = $request->input('valor_reserva');
        // $contrato->nome_empresa = $request->input('nome_empresa');
        // $contrato->telefone_empresa = $request->input('telefone_empresa');
        // $contrato->email_empresa = $request->input('email_empresa');
        // $contrato->outras_informacoes = $request->input('outras_informacoes');
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
     *         "empresa_id": 1,
     *         "nome_empresa": "Testes S.A.",
     *         "cnpj_empresa": "58.621.352/0001-44",
     *         "telefone_empresa": "11913314554",
     *         "email_empresa": "teste@prefeitura.com",
     *         "licitacao_modelo_id": 1,
     *         "licitacao_modelo": "Concorrência",
     *         "estado_id": 1,
     *         "estado": "Elaboração Material Técnico",
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

        $vl_contrato = $contrato->valor_contrato;
        if($vl_contrato){
            $aditamentos_valor = AditamentoValor::query()->where('contrato_id','=',$id)->get();
            foreach($aditamentos_valor as $adt_val){
                if($adt_val->tipo_aditamento == 'Acréscimo de valor') $vl_contrato += $adt_val->valor_aditamento;
                elseif($adt_val->tipo_aditamento == 'Redução de valor') $vl_contrato -= $adt_val->valor_aditamento;
            }
        }
        $contrato->adt_valor_corrigido = $vl_contrato;

        if ($contrato->data_vencimento){
            $dt_vencto = date_create_from_format('Y-m-d', $contrato->data_vencimento);
            if($vl_contrato){
                $aditamentos_prazo = AditamentoPrazo::query()->where('contrato_id','=',$id)->get();
                foreach($aditamentos_prazo as $adt_prz){
                    if($adt_prz->tipo_aditamento == 'Prorrogação de prazo')
                        date_add($dt_vencto,date_interval_create_from_date_string($adt_prz->dias_reajuste." days"));
                    elseif($adt_prz->tipo_aditamento == 'Supressão de prazo')
                        date_sub($dt_vencto,date_interval_create_from_date_string($adt_prz->dias_reajuste." days"));
                }
            }
            $contrato->adt_prazo_corrigido = $dt_vencto->format("Y-m-d");
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
     * @bodyParam empresa_id integer ID da empresa. Example: 1
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
     * @bodyParam numero_nota_reserva string Número da última nota de reserva. Example: 1024
     * @bodyParam valor_reserva float Valor total de reserva. Example: 200.00
     * @bodyParam outras_informacoes text Informações adicionais. Example: Exemplo. Nenhuma outra informação
     *
     * @response 200 {
     *     "data": {
     *         "id": 14,
     *         "departamento_id": 2,
     *         "departamento": "GABINETE/NDTIC",
     *         "empresa_id": 1,
     *         "nome_empresa": "Testes S.A.",
     *         "cnpj_empresa": "58.621.352/0001-44",
     *         "telefone_empresa": "11913314554",
     *         "email_empresa": "teste@prefeitura.com",
     *         "licitacao_modelo_id": 1,
     *         "licitacao_modelo": "Concorrência",
     *         "estado_id": 2,
     *         "estado": "Em Contratação",
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
     *         "outras_informacoes": "Exemplo. Nenhuma outra informação",
     *     }
     * }
     */
    public function update(ContratoFormRequest $request, $id)
    {
        $contrato = Contrato::findOrFail($id);
        $contrato->departamento_id = $request->input('departamento_id');
        $contrato->processo_sei = str_replace(array('.','-','/'),'',$request->input('processo_sei'));

        $contrato->empresa_id = $request->input('empresa_id') && $request->input('empresa_id') != 'null'? $request->input('empresa_id') : null;
        $contrato->licitacao_modelo_id = $request->input('licitacao_modelo_id') ? $request->input('licitacao_modelo_id') : null;
        $contrato->estado_id = $request->input('estado_id') ? $request->input('estado_id') : $contrato->estado_id;
        $contrato->envio_material_tecnico = $request->input('envio_material_tecnico') ? $request->input('envio_material_tecnico') : null;
        $contrato->minuta_edital = $request->input('minuta_edital') ? $request->input('minuta_edital') : null;
        $contrato->abertura_certame = $request->input('abertura_certame') ? $request->input('abertura_certame') : null;
        $contrato->homologacao = $request->input('homologacao') ? $request->input('homologacao') : null;
        $contrato->credor = $request->input('credor') ? $request->input('credor') : null;
        $contrato->cnpj_cpf = $request->input('cnpj_cpf') ? str_replace(array('.','-','/'),'',$request->input('cnpj_cpf')) : null;
        $contrato->tipo_objeto = $request->input('tipo_objeto') ? $request->input('tipo_objeto') : null;
        $contrato->objeto = $request->input('objeto') ? $request->input('objeto') : null;
        $contrato->numero_contrato = $request->input('numero_contrato') ? str_replace(array('.','-','/'),'',$request->input('numero_contrato')) : null;
        $contrato->data_assinatura = $request->input('data_assinatura') ? $request->input('data_assinatura') : null;
        $contrato->valor_contrato = $request->input('valor_contrato') ? str_replace(',','.',str_replace('.','',$request->input('valor_contrato'))) : null;
        $contrato->valor_mensal_estimativo = $request->input('valor_mensal_estimativo') ? str_replace(',','.',str_replace('.','',$request->input('valor_mensal_estimativo'))) : null;
        $contrato->data_inicio_vigencia = $request->input('data_inicio_vigencia') ? $request->input('data_inicio_vigencia') : null;
        $contrato->data_vencimento = $request->input('data_vencimento') ? $request->input('data_vencimento') : null;
        $contrato->condicao_pagamento = $request->input('condicao_pagamento') ? $request->input('condicao_pagamento') : null;
        $contrato->prazo_a_partir_de = $request->input('prazo_a_partir_de') ? $request->input('prazo_a_partir_de') : null;
        $contrato->data_prazo_maximo = $request->input('data_prazo_maximo') ? $request->input('data_prazo_maximo') : null;
        $contrato->numero_nota_reserva = $request->input('numero_nota_reserva') ? $request->input('numero_nota_reserva') : null;
        $contrato->valor_reserva = $request->input('valor_reserva') ? str_replace(',','.',str_replace('.','',$request->input('valor_reserva'))) : null;
        $contrato->outras_informacoes = $request->input('outras_informacoes') ? $request->input('outras_informacoes') : null;
		$contrato->nome_empresa = $request->input('nome_empresa') ? $request->input('nome_empresa') : null;
        $contrato->telefone_empresa = $request->input('telefone_empresa') ? $request->input('telefone_empresa') : null;
        $contrato->email_empresa = $request->input('email_empresa') ? $request->input('email_empresa') : null;
        $contrato->user_id = auth()->user()->id;

        //dd($request->input('empresa_id'));

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
     *         "empresa_id": 1,
     *         "nome_empresa": "Testes S.A.",
     *         "cnpj_empresa": "58.621.352/0001-44",
     *         "telefone_empresa": "11913314554",
     *         "email_empresa": "teste@prefeitura.com",
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
     * Mostra os valores de referência e totais para o formulário de execução financeira
     * @authenticated
     *
     *
     * @urlParam id integer required ID do contrato. Example: 14
     *
     * @queryParam execucao_id ID do registro de execução financeira que deseja ignorar no totalizador de empenhados e executados. Example: 2
     *
     * @response 200 {
     *     "data": {
     *         "id": 14,
     *         "valor_contrato": 1992,
     *         "valor_reserva": 777,
     *         "valor_dotacoes": 500.09,
     *         "valor_empenhos": 500.50,
     *         "valor_planejados": 900,
     *         "valor_aditamentos": 30,
     *         "total_empenhado": 400,
     *         "total_executado": 320
     *     }
     * }
     */
    public function exibeTotalizadores(int $id, Request $request)
    {
        $contrato = Contrato::findOrFail($id);

        $dotacoes = Dotacao::query()->where('contrato_id','=',$id)->get();
        $empenhos = EmpenhoNota::query()->where('contrato_id','=',$id)->get();
        $executadas = ExecucaoFinanceira::query()->where('contrato_id','=',$id)->get();
        $aditamentos = AditamentoValor::query()->where('contrato_id','=',$id)->get();

        $vl_contrato = $contrato->valor_contrato;
        if($vl_contrato){
            $aditamentos_valor = AditamentoValor::query()->where('contrato_id','=',$id)->get();
            foreach($aditamentos_valor as $adt_val){
                if($adt_val->tipo_aditamento == 'Acréscimo de valor') $vl_contrato += $adt_val->valor_aditamento;
                elseif($adt_val->tipo_aditamento == 'Redução de valor') $vl_contrato -= $adt_val->valor_aditamento;
            }
        }
        $contrato->adt_valor_corrigido = $vl_contrato;

        //array que irá retornar todos os valores solicitados. Os de contrato e reserva já se encontram no contrato, os demais precisamos somar
        $retorno = array();
        $retorno['id'] = $contrato->id;
        $retorno['valor_contrato'] = $contrato->valor_contrato;
        $retorno['valor_contrato_aditamentos'] = $contrato->adt_valor_corrigido;
        $retorno['valor_reserva'] = $contrato->valor_reserva > 0 ? $contrato->valor_reserva : 0;
        $retorno['valor_dotacoes'] = 0;
        $retorno['valor_empenhos'] = 0;
        $retorno['valor_planejados'] = 0;
        $retorno['valor_aditamentos'] = 0;
        $retorno['total_empenhado'] = 0;
        $retorno['total_executado'] = 0;

        foreach($dotacoes as $dotacao) {
            $retorno['valor_dotacoes'] += $dotacao->valor_dotacao;
        }

        foreach($empenhos as $empenho) {
            if ($empenho->tipo_empenho === "cancelamento" || $empenho->tipo_empenho === NULL) {
                $retorno['valor_empenhos'] -= $empenho->valor_empenho;
            } else{
                $retorno['valor_empenhos'] += $empenho->valor_empenho;
            }
        }

        $execucao_id = $request->query('execucao_id') ? $request->query('execucao_id') : 0;
        foreach($executadas as $executada){
            $retorno['valor_planejados'] += $executada->planejado_inicial;

            if($execucao_id == 0){
                $retorno['total_empenhado'] += $executada->empenhado;
                $retorno['total_executado'] += $executada->executado;
            }else{
                if ($executada->id != $execucao_id){
                    $retorno['total_empenhado'] += $executada->empenhado;
                    $retorno['total_executado'] += $executada->executado;
                }
            }
        }

        foreach($aditamentos as $aditamento) {
            if ($aditamento->tipo_aditamento === "Redução de valor" || $aditamento->tipo_aditamento === NULL) {
                 $retorno['valor_aditamentos'] -= $aditamento->valor_aditamento;
            } elseif ($aditamento->tipo_aditamento === "Acréscimo de valor") {
                $retorno['valor_aditamentos'] += $aditamento->valor_aditamento;
            }
        }

        $retornoJson = (object) $retorno;

        $contratoResource = new ContratoTotalizadores($retornoJson);
        return $contratoResource;
    }

    /**
     * Verifica se possui um número de processo SEI cadastrado no sistema, caso exista, retorna o código status 200 OK.
     *
     * Se não, a requisição ira retornar um codigo status 404 Not Found.
     *
     * @authenticated
     *
     * @bodyparam processo_sei string número do processo SEI. Example: 012300013456984444
     *
     * @response 200 {
     *      "mensagem": "Existe um ou mais contratos com este número SEI no sistema."
     *  }
     *
     * @response 404 {
     *      "mensagem": "Nenhum contrato com este número SEI foi cadastrado."
     *  }
     */
    public function verifica_sei(Request $request)
    {
        $numero_sei = $request->input('processo_sei');
        $numero_sei = str_replace(['-', '.', '/', ',', '*'], '', $numero_sei);

        $contrato = Contrato::where('processo_sei', $numero_sei)->first('processo_sei');

        if ($contrato) {
            return response()->json([
                'mensagem' => 'Existe um ou mais contratos com este número SEI no sistema.'
            ], 200);
        } else {
            return response()->json([
                'mensagem' => 'Nenhum contrato com este número SEI foi cadastrado.'
            ], 404);
        }
    }

    /**
     * Atualiza o ativo do contrato para false ou true
     *
     * @authenticated
     *
     * @urlParam id integer required ID do contrato. Example: 14
     * 
     * @response 200 {
     *      "mensagem": "Contrato deletado!"
     *  }
     * 
     */
    public function atualizaAtivoContrato(Request $request, $id)
    {
        $contrato = Contrato::find($id);
        
        $contrato->ativo = 0;
        $contrato->update();

        return response()->json([
            'mensagem' => "Contrato deletado!",
        ],202);
    }
}
