<?php

use App\Http\Controllers\ExecFinanceiraController;
use App\Http\Controllers\NotasDeReservaController;
use App\Http\Controllers\NotasLiquidacaoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AditamentoPrazoController;
use App\Http\Controllers\AditamentoValorController;
use App\Http\Controllers\CertidaoController;
use App\Http\Controllers\ContratoController;
use App\Http\Controllers\DistritoController;
use App\Http\Controllers\DotacaoController;
use App\Http\Controllers\DotacaoRecursoController;
use App\Http\Controllers\DotacaoTipoController;
use App\Http\Controllers\EmpenhoNotaController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\ExecucaoFinanceiraController;
use App\Http\Controllers\GarantiaController;
use App\Http\Controllers\GestaoFiscalizacaoController;
use App\Http\Controllers\LicitacaoModeloController;
use App\Http\Controllers\OrigemRecursoController;
use App\Http\Controllers\ServicoLocalController;
use App\Http\Controllers\SubprefeituraController;
use App\Http\Controllers\ReajusteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('cadastrar', [AuthController::class, 'cadastrar']);
Route::post('login', [AuthController::class, 'login']);
Route::post('alterar_senha', [AuthController::class, 'alterar_senha']);

Route::group(['middleware' => ['auth:sanctum']], function() {
    /**
     * Exibe dados do usuário logado de acordo com o Token enviado
     * @authenticated
     *
     * @header Authorization Bearer 5|02KLXZaRYzgJybyy2rMTRKXKIOuuE3EylnT7JQVv
     *
     * @response 200 {
     *     "id": 1,
     *     "name": "Admin NDTIC",
     *     "email": "tisvma@prefeitura.sp.gov.br",
     *     "email_verified_at": null,
     *     "ativo": 1,
     *     "created_at": "2022-03-23T19:06:48.000000Z",
     *     "updated_at": "2022-03-23T19:06:48.000000Z"
     * }
     *
     * @response 401 {
     *     "message":"Unauthenticated."
     * }
     */
    Route::get('perfil', function(Request $request) {
        return auth()->user();
    });
    Route::post('logout', [AuthController::class, 'logout']);
    
    Route::get('contratos',[ContratoController::class, 'index']);
    Route::get('contratos_vencimento',[ContratoController::class, 'contratos_vencimento']);
    Route::get('contratos_sei', [ContratoController::class, 'verifica_sei']);
    Route::post('contrato', [ContratoController::class, 'store']);
    Route::get('contrato/{id}', [ContratoController::class, 'show']);
    Route::get('contrato_totais/{id}', [ContratoController::class, 'exibeTotalizadores']);
    Route::put('contrato/{id}', [ContratoController::class, 'update']);
    Route::delete('contrato/{id}', [ContratoController::class, 'destroy']);
    Route::delete('contrato/ativo/{id}', [ContratoController::class, 'atualizaAtivoContrato']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    //     return $request->user();
    // });
    
    Route::get('aditamentos_prazo', [AditamentoPrazoController::class, 'index']);
    Route::get('aditamentos_prazo/{id}', [AditamentoPrazoController::class, 'listar_por_contrato']);
    Route::post('aditamento_prazo', [AditamentoPrazoController::class, 'store']);
    Route::get('aditamento_prazo/{id}', [AditamentoPrazoController::class, 'show']);
    Route::put('aditamento_prazo/{id}', [AditamentoPrazoController::class, 'update']);
    Route::delete('aditamento_prazo/{id}', [AditamentoPrazoController::class, 'destroy']);
    
    Route::get('aditamentos_valor', [AditamentoValorController::class, 'index']);
    Route::get('aditamentos_valor/{id}', [AditamentoValorController::class, 'listar_por_contrato']);
    Route::post('aditamento_valor', [AditamentoValorController::class, 'store']);
    Route::get('aditamento_valor/{id}', [AditamentoValorController::class, 'show']);
    Route::put('aditamento_valor/{id}', [AditamentoValorController::class, 'update']);
    Route::delete('aditamento_valor/{id}', [AditamentoValorController::class, 'destroy']);
    
    Route::get('certidoes', [CertidaoController::class, 'index']);
    Route::get('certidoes/{id}', [CertidaoController::class, 'listar_por_contrato']);
    Route::post('certidao', [CertidaoController::class, 'store']);
    Route::get('certidao/{id}', [CertidaoController::class, 'show']);
    Route::put('certidao/{id}', [CertidaoController::class, 'update']);
    Route::delete('certidao/{id}', [CertidaoController::class, 'destroy']);
    
    Route::get('distritos', [DistritoController::class, 'index']);
    Route::get('distritos/{id}', [DistritoController::class, 'listar_por_subprefeitura']);
    Route::post('distrito', [DistritoController::class, 'store']);
    Route::get('distrito/{id}', [DistritoController::class, 'show']);
    Route::put('distrito/{id}', [DistritoController::class, 'update']);
    Route::delete('distrito/{id}', [DistritoController::class, 'destroy']);
    
    Route::get('dotacoes', [DotacaoController::class, 'index']);
    Route::get('dotacoes/{id}', [DotacaoController::class, 'listar_por_contrato']);
    Route::post('dotacao', [DotacaoController::class, 'store']);
    Route::get('dotacao/{id}', [DotacaoController::class, 'show']);
    Route::put('dotacao/{id}', [DotacaoController::class, 'update']);
    Route::delete('dotacao/{id}', [DotacaoController::class, 'destroy']);
    
    Route::get('dotacao_recursos', [DotacaoRecursoController::class, 'index']);
    Route::post('dotacao_recurso', [DotacaoRecursoController::class, 'store']);
    Route::get('dotacao_recurso/{id}', [DotacaoRecursoController::class, 'show']);
    Route::put('dotacao_recurso/{id}', [DotacaoRecursoController::class, 'update']);
    Route::delete('dotacao_recurso/{id}', [DotacaoRecursoController::class, 'destroy']);
    Route::get('dotacao_recursos_origem/{id}', [DotacaoRecursoController::class, 'listar_recursos_dotacao']);
    
    Route::get('dotacao_tipos', [DotacaoTipoController::class, 'index']);
    Route::post('dotacao_tipo', [DotacaoTipoController::class, 'store']);
    Route::get('dotacao_tipo/{id}', [DotacaoTipoController::class, 'show']);
    Route::put('dotacao_tipo/{id}', [DotacaoTipoController::class, 'update']);
    Route::delete('dotacao_tipo/{id}', [DotacaoTipoController::class, 'destroy']);
    
    Route::get('empresas', [EmpresaController::class, 'index']);
    
    Route::get('garantias', [GarantiaController::class, 'index']);
    Route::get('garantias/{id}', [GarantiaController::class, 'listar_por_contrato']);
    Route::post('garantia', [GarantiaController::class, 'store']);
    Route::get('garantia/{id}', [Garantiacontroller::class, 'show']);
    Route::put('garantia/{id}', [GarantiaController::class, 'update']);
    Route::delete('garantia/{id}', [GarantiaController::class, 'destroy']);
    
    Route::get('gestaofiscalizacoes', [GestaoFiscalizacaoController::class, 'index']);
    Route::get('gestaofiscalizacoes/{id}', [GestaoFiscalizacaoController::class, 'listar_por_contrato']);
    Route::post('gestaofiscalizacao', [GestaoFiscalizacaoController::class, 'store']);
    Route::get('gestaofiscalizacao/{id}', [GestaoFiscalizacaoController::class, 'show']);
    Route::put('gestaofiscalizacao/{id}', [GestaoFiscalizacaoController::class, 'update']);
    Route::delete('gestaofiscalizacao/{id}', [GestaoFiscalizacaoController::class, 'destroy']);
    
    Route::get('empenho_notas', [EmpenhoNotaController::class, 'index']);
    Route::get('empenho_notas/{id}', [EmpenhoNotaController::class, 'listar_por_contrato']);
    Route::post('empenho_nota', [EmpenhoNotaController::class, 'store']);
    Route::get('empenho_nota/{id}', [EmpenhoNotaController::class, 'show']);
    Route::put('empenho_nota/{id}', [EmpenhoNotaController::class, 'update']);
    Route::delete('empenho_nota/{id}', [EmpenhoNotaController::class, 'destroy']);
    
    Route::get('execucoes_financeiras', [ExecucaoFinanceiraController::class, 'index']);
    Route::get('execucoes_financeiras/{id}', [ExecucaoFinanceiraController::class, 'listar_por_contrato']);
    Route::post('execucao_financeira', [ExecucaoFinanceiraController::class, 'store']);
    Route::get('execucao_financeira/{id}', [ExecucaoFinanceiraController::class, 'show']);
    Route::put('execucao_financeira/{id}', [ExecucaoFinanceiraController::class, 'update']);
    Route::delete('execucao_financeira/{id}', [ExecucaoFinanceiraController::class, 'destroy']);
    
    Route::get('origem_recursos', [OrigemRecursoController::class, 'index']);
    Route::post('origem_recurso', [OrigemRecursoController::class, 'store']);
    Route::get('origem_recurso/{id}', [OrigemRecursoController::class, 'show']);
    Route::put('origem_recurso/{id}', [OrigemRecursoController::class, 'update']);
    Route::delete('origem_recurso/{id}', [OrigemRecursoController::class, 'destroy']);
    
    Route::get('servicoslocais', [ServicoLocalController::class, 'index']);
    Route::get('servicoslocais/{id}', [ServicoLocalController::class, 'listar_por_contrato']);
    Route::post('servicolocal', [ServicoLocalController::class, 'store']);
    Route::get('servicolocal/{id}', [ServicoLocalController::class, 'show']);
    Route::put('servicolocal/{id}', [ServicoLocalController::class, 'update']);
    Route::delete('servicolocal/{id}', [ServicoLocalController::class, 'destroy']);
    
    Route::get('subprefeituras', [SubprefeituraController::class, 'index']);
    Route::get('subprefeituras/{regiao}', [SubprefeituraController::class, 'listar_por_regiao']);
    Route::get('regioes', [SubprefeituraController::class, 'listar_regioes']);
    Route::post('subprefeitura', [SubprefeituraController::class, 'store']);
    Route::get('subprefeitura/{id}', [SubprefeituraController::class, 'show']);
    Route::put('subprefeitura/{id}', [SubprefeituraController::class, 'update']);
    Route::delete('subprefeitura/{id}', [SubprefeituraController::class, 'destroy']);
    
    Route::get('estados',[EstadoController::class, 'index']);
    
    Route::get('licitacaomodelos',[LicitacaoModeloController::class, 'index']);
    Route::post('licitacaomodelo', [LicitacaoModeloController::class, 'store']);
    Route::get('licitacaomodelo/{id}', [LicitacaoModeloController::class, 'show']);
    Route::put('licitacaomodelo/{id}', [LicitacaoModeloController::class, 'update']);
    Route::delete('licitacaomodelo/{id}', [LicitacaoModeloController::class, 'destroy']);
    
    Route::get('reajustes', [ReajusteController::class, 'index']);
    Route::get('reajustes/{id}', [ReajusteController::class, 'listar_por_contrato']);
    Route::post('reajuste', [ReajusteController::class, 'store']);
    Route::get('reajuste/{id}', [ReajusteController::class, 'show']);
    Route::put('reajuste/{id}', [ReajusteController::class, 'update']);
    Route::delete('reajuste/{id}', [ReajusteController::class, 'destroy']);
    
    Route::get('exec_financeira_ano/{id}', [ExecFinanceiraController::class, 'indexAnoExec']);
    Route::post('exec_financeira_ano', [ExecFinanceiraController::class, 'createAnoExec']);
    Route::delete('exec_financeira/{id}', [ExecFinanceiraController::class, 'deleteAnoExec']);
    Route::get('exec_valores_meses/{id}', [ExecFinanceiraController::class, 'indexValoresMesesAno']);
    Route::get('exec_mes/{id}', [ExecFinanceiraController::class, 'indexMesExec']);
    Route::post('exec_mes', [ExecFinanceiraController::class, 'createMesExec']);

    Route::get('notas_reserva/{id}', [NotasDeReservaController::class, 'index']);
    Route::post('nota_reserva', [NotasDeReservaController::class, 'create']);
    Route::get('nota_reserva/{id}', [NotasDeReservaController::class, 'show']);
    Route::put('nota_reserva/{id}', [NotasDeReservaController::class, 'edit']);
    Route::delete('nota_reserva/{id}', [NotasDeReservaController::class, 'delete']);

    Route::get('notas_liquidacao/{id}', [NotasLiquidacaoController::class, 'index']);
    Route::post('nota_liquidacao', [NotasLiquidacaoController::class, 'create']);
    Route::get('nota_liquidacao/{id}', [NotasLiquidacaoController::class, 'show']);
    Route::put('nota_liquidacao/{id}', [NotasLiquidacaoController::class, 'edit']);
    Route::delete('nota_liquidacao/{id}', [NotasLiquidacaoController::class, 'delete']);
    