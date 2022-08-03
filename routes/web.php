<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix(env('APP_FOLDER', 'contratos'))->group(function () { //considerando que o projeto estará em subdiretório em homol/prod (TODO: testar uso de env('APP_FOLDER', 'ndtic'))
    //Custom Login
    Route::get('/entrar', [App\Http\Controllers\Auth\LoginController::class, 'index'])->name('entrar');
    Route::post('/entrar', [App\Http\Controllers\Auth\LoginController::class, 'entrar']);
    Route::get('/trocasenha', [App\Http\Controllers\UserController::class, 'trocasenha'])->name('trocasenha')->middleware('autenticador');
    Route::post('/trocasenha', [App\Http\Controllers\UserController::class, 'alterarsenha'])->middleware('autenticador');
    // Route::get('/trocasenha', [App\Http\Controllers\Auth\RegisterController::class, 'criar'])->middleware('autenticador');
    // Route::post('/registrar', [App\Http\Controllers\Auth\RegisterController::class, 'create'])->middleware('autenticador');
    Route::get('/sair', function () {
        Auth::logout();
        return redirect('/'.env('APP_FOLDER', 'contratos'));
    })->name('sair');

	Route::get('/', function () {
		return view('welcome');
	})->name('welcome');

    Route::group(['middleware' => ['autenticador']], function() {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');

        //Cadastros auxiliares
        Route::get('/cadaux', [App\Http\Controllers\HomeController::class, 'cadaux'])->name('cadaux');
        Route::get('/origem_recursos', [App\Http\Controllers\OrigemRecursoController::class, 'index'])->name('cadaux-origem_recursos');
        Route::post('/origem_recursos', [App\Http\Controllers\OrigemRecursoController::class, 'store'])->name('cadaux-origem_recursos-store');
        Route::post('/origem_recursos/{id}', [App\Http\Controllers\OrigemRecursoController::class, 'update'])->name('cadaux-origem_recursos-update');
        Route::get('/licitacao_modelos', [App\Http\Controllers\LicitacaoModeloController::class, 'index'])->name('cadaux-licitacao_modelos');
        Route::post('/licitacao_modelos', [App\Http\Controllers\LicitacaoModeloController::class, 'store'])->name('cadaux-licitacao_modelos-store');
        Route::post('/licitacao_modelos/{id}', [App\Http\Controllers\LicitacaoModeloController::class, 'update'])->name('cadaux-licitacao_modelos-update');
        Route::get('/dotacao_tipos', [App\Http\Controllers\DotacaoTipoController::class, 'index'])->name('cadaux-dotacao_tipos'); //->middleware('permission:cadaux')
        Route::get('/dotacao_tipos/criar', [App\Http\Controllers\DotacaoTipoController::class, 'create'])->name('cadaux-dotacao_tipos-create');
        Route::post('/dotacao_tipos/criar', [App\Http\Controllers\DotacaoTipoController::class, 'store'])->name('cadaux-dotacao_tipos-store');
        Route::get('/dotacao_tipos/{id}/ver', [App\Http\Controllers\DotacaoTipoController::class, 'show'])->name('cadaux-dotacao_tipos-show');
        Route::get('/dotacao_tipos/{id}/editar', [App\Http\Controllers\DotacaoTipoController::class, 'edit'])->name('cadaux-dotacao_tipos-edit');
        Route::post('/dotacao_tipos/{id}/editar', [App\Http\Controllers\DotacaoTipoController::class, 'update'])->name('cadaux-dotacao_tipos-update');
        Route::get('/subprefeituras', [App\Http\Controllers\SubprefeituraController::class, 'index'])->name('cadaux-subprefeituras'); //->middleware('permission:cadaux')
        Route::get('/subprefeituras/criar', [App\Http\Controllers\SubprefeituraController::class, 'create'])->name('cadaux-subprefeituras-create');
        Route::post('/subprefeituras/criar', [App\Http\Controllers\SubprefeituraController::class, 'store'])->name('cadaux-subprefeituras-store');
        Route::get('/subprefeituras/{id}/ver', [App\Http\Controllers\SubprefeituraController::class, 'show'])->name('cadaux-subprefeituras-show');
        Route::get('/subprefeituras/{id}/editar', [App\Http\Controllers\SubprefeituraController::class, 'edit'])->name('cadaux-subprefeituras-edit');
        Route::post('/subprefeituras/{id}/editar', [App\Http\Controllers\SubprefeituraController::class, 'update'])->name('cadaux-subprefeituras-update');
        Route::get('/distritos', [App\Http\Controllers\DistritoController::class, 'index'])->name('cadaux-distritos'); //->middleware('permission:cadaux')
        Route::get('/distritos/criar', [App\Http\Controllers\DistritoController::class, 'create'])->name('cadaux-distritos-create');
        Route::post('/distritos/criar', [App\Http\Controllers\DistritoController::class, 'store'])->name('cadaux-distritos-store');
        Route::get('/distritos/{id}/ver', [App\Http\Controllers\DistritoController::class, 'show'])->name('cadaux-distritos-show');
        Route::get('/distritos/{id}/editar', [App\Http\Controllers\DistritoController::class, 'edit'])->name('cadaux-distritos-edit');
        Route::post('/distritos/{id}/editar', [App\Http\Controllers\DistritoController::class, 'update'])->name('cadaux-distritos-update');

		//Gestão de Usuários e Permissões
        Route::resource('users', App\Http\Controllers\UserController::class)->middleware('permission:user-list');
        Route::resource('roles', App\Http\Controllers\RoleController::class)->middleware('permission:role-list');
        Route::resource('permissions', App\Http\Controllers\PermissionController::class)->middleware('permission:permission-list');
    });
});
