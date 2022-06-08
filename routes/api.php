<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AditamentoController;
use App\Http\Controllers\CertidaoController;
use App\Http\Controllers\ContratoController;
use App\Http\Controllers\DistritoController;
use App\Http\Controllers\GarantiaController;
use App\Http\Controllers\GestaoContratoController;
use App\Http\Controllers\GestaoFiscalizacaoController;
use App\Http\Controllers\RecursoOrcamentarioController;
use App\Http\Controllers\ServicoLocalController;
use App\Http\Controllers\SubprefeituraController;

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
    Route::post('contrato', [ContratoController::class, 'store']);
    Route::get('contrato/{id}', [ContratoController::class, 'show']);
    Route::put('contrato/{id}', [ContratoController::class, 'update']);
    Route::delete('contrato/{id}', [ContratoController::class, 'destroy']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('aditamentos', [AditamentoController::class, 'index']);
Route::get('aditamentos/{id}', [AditamentoController::class, 'listar_por_contrato']);
Route::post('aditamento', [AditamentoController::class, 'store']);
Route::get('aditamento/{id}', [AditamentoController::class, 'show']);
Route::put('aditamento/{id}', [AditamentoController::class, 'update']);
Route::delete('aditamento/{id}', [AditamentoController::class, 'destroy']);

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

Route::get('garantias', [GarantiaController::class, 'index']);
Route::get('garantias/{id}', [GarantiaController::class, 'listar_por_contrato']);
Route::post('garantia', [GarantiaController::class, 'store']);
Route::get('garantia/{id}', [Garantiacontroller::class, 'show']);
Route::put('garantia/{id}', [GarantiaController::class, 'update']);
Route::delete('garantia/{id}', [GarantiaController::class, 'destroy']);

Route::get('gestaocontratos', [GestaoContratoController::class, 'index']);
Route::get('gestaocontratos/{id}', [GestaoContratoController::class, 'listar_por_contrato']);
Route::post('gestaocontrato', [GestaoContratoController::class, 'store']);
Route::get('gestaocontrato/{id}', [GestaoContratoController::class, 'show']);
Route::put('gestaocontrato/{id}', [GestaoContratoController::class, 'update']);
Route::delete('gestaocontrato/{id}', [GestaoContratoController::class, 'destroy']);

Route::get('gestaofiscalizacoes', [GestaoFiscalizacaoController::class, 'index']);
Route::get('gestaofiscalizacoes/{id}', [GestaoFiscalizacaoController::class, 'listar_por_contrato']);
Route::post('gestaofiscalizacao', [GestaoFiscalizacaoController::class, 'store']);
Route::get('gestaofiscalizacao/{id}', [GestaoFiscalizacaoController::class, 'show']);
Route::put('gestaofiscalizacao/{id}', [GestaoFiscalizacaoController::class, 'update']);
Route::delete('gestaofiscalizacao/{id}', [GestaoFiscalizacaoController::class, 'destroy']);

Route::get('recursoorcamentarios', [RecursoOrcamentarioController::class, 'index']);
Route::get('recursoorcamentarios/{id}', [RecursoOrcamentarioController::class, 'listar_por_contrato']);
Route::post('recursoorcamentario', [RecursoOrcamentarioController::class, 'store']);
Route::get('recursoorcamentario/{id}', [RecursoOrcamentarioController::class, 'show']);
Route::put('recursoorcamentario/{id}', [RecursoOrcamentarioController::class, 'update']);
Route::delete('recursoorcamentario/{id}', [RecursoOrcamentarioController::class, 'destroy']);

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
