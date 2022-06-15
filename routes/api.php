<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AditamentoController;
use App\Http\Controllers\CertidaoController;
use App\Http\Controllers\ContratoController;
use App\Http\Controllers\DevolucaoController;
use App\Http\Controllers\DistritoController;
use App\Http\Controllers\ExecutadaController;
use App\Http\Controllers\GarantiaController;
use App\Http\Controllers\GestaoFiscalizacaoController;
use App\Http\Controllers\PlanejadaController;
use App\Http\Controllers\ServicoLocalController;
use App\Http\Controllers\SubprefeituraController;
use App\Http\Controllers\TipoContratacaoController;

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

Route::get('gestaofiscalizacoes', [GestaoFiscalizacaoController::class, 'index']);
Route::get('gestaofiscalizacoes/{id}', [GestaoFiscalizacaoController::class, 'listar_por_contrato']);
Route::post('gestaofiscalizacao', [GestaoFiscalizacaoController::class, 'store']);
Route::get('gestaofiscalizacao/{id}', [GestaoFiscalizacaoController::class, 'show']);
Route::put('gestaofiscalizacao/{id}', [GestaoFiscalizacaoController::class, 'update']);
Route::delete('gestaofiscalizacao/{id}', [GestaoFiscalizacaoController::class, 'destroy']);

Route::get('devolucoes', [DevolucaoController::class, 'index']);
Route::get('devolucoes/{id}', [DevolucaoController::class, 'listar_por_contrato']);
Route::post('devolucao', [DevolucaoController::class, 'store']);
Route::get('devolucao/{id}', [DevolucaoController::class, 'show']);
Route::put('devolucao/{id}', [DevolucaoController::class, 'update']);
Route::delete('devolucao/{id}', [DevolucaoController::class, 'destroy']);

Route::get('executadas', [ExecutadaController::class, 'index']);
Route::get('executadas/{id}', [ExecutadaController::class, 'listar_por_contrato']);
Route::post('executada', [ExecutadaController::class, 'store']);
Route::get('executada/{id}', [ExecutadaController::class, 'show']);
Route::put('executada/{id}', [ExecutadaController::class, 'update']);
Route::delete('executada/{id}', [ExecutadaController::class, 'destroy']);

Route::get('planejadas', [PlanejadaController::class, 'index']);
Route::get('planejadas/{id}', [PlanejadaController::class, 'listar_por_contrato']);
Route::post('planejada', [PlanejadaController::class, 'store']);
Route::get('planejada/{id}', [PlanejadaController::class, 'show']);
Route::put('planejada/{id}', [PlanejadaController::class, 'update']);
Route::delete('planejada/{id}', [PlanejadaController::class, 'destroy']);

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

Route::get('tipocontratacoes',[TipoContratacaoController::class, 'index']);
Route::post('tipocontratacao', [TipoContratacaoController::class, 'store']);
Route::get('tipocontratacao/{id}', [TipoContratacaoController::class, 'show']);
Route::put('tipocontratacao/{id}', [TipoContratacaoController::class, 'update']);
Route::delete('tipocontratacao/{id}', [TipoContratacaoController::class, 'destroy']);
