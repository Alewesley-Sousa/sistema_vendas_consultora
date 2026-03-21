<?php

use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ComissoesController;
use App\Http\Controllers\HistoricoComissoesController;
use App\Http\Controllers\MetasController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\UsuariosController;
// agrupa todos que usam a autenticação com token
Route::middleware('auth:sanctum')->group(function () {
    // Pegar comissao atual do usuario autenticado
    Route::get('/comissao', [ComissoesController::class, 'visualizar']);

    //pegar meta atual do usuario autenticado
    Route::get('/meta', [MetasController::class, 'metaAtual']);

    // pegar progresso atual da meta do usuario autenticado
    Route::get('/meta/progresso', [MetasController::class, 'progressoMeta']);

    // pegar historico de comissoes do usuarioa autenticado
    Route::get('/comissao/historico', [HistoricoComissoesController::class, 'visualizarHistorico']);

    // solicitar o saque da comissão do usuario
    Route::get('/comissao/solicitar', [ComissoesController::class, 'solicitarComissao']);
    
    // cadastrar cliente
    Route::post('/cliente', [ClientesController::class, 'cadastrarCliente']);

    // atualzar dados do cliente
    Route::put('/cliente/{cliente}', [ClientesController::class, 'atualizarDados']);

    // exibir um cliente
    Route::get('/cliente/{cliente}', [ClientesController::class, 'exibir']);
});