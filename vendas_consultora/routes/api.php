<?php

use App\Http\Controllers\CatalogosController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ComissoesController;
use App\Http\Controllers\HistoricoComissoesController;
use App\Http\Controllers\ItensCatalogoController;
use App\Http\Controllers\MetasController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\UsuariosController;
// agrupa todos que usam a autenticação com token
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('/comissao')->group( function () {

        // Pegar comissao atual do usuario autenticado
        Route::get('/', [ComissoesController::class, 'visualizar']);
    
        // pegar historico de comissoes do usuarioa autenticado
        Route::get('/historico', [HistoricoComissoesController::class, 'visualizarHistorico']);
    
        // solicitar o saque da comissão do usuario
        Route::get('/solicitar', [ComissoesController::class, 'solicitarComissao']);
    });

    Route::prefix('/meta')->group(function () {
        //pegar meta atual do usuario autenticado
        Route::get('/', [MetasController::class, 'metaAtual']);

        // pegar progresso atual da meta do usuario autenticado
        Route::get('/progresso', [MetasController::class, 'progressoMeta']);
    });

    Route::prefix('/cliente')->group(function () {
        // cadastrar cliente
        Route::post('/', [ClientesController::class, 'cadastrarCliente']);
    
        // atualzar dados do cliente
        Route::put('/{cliente}', [ClientesController::class, 'atualizarDados']);
    
        // exibir um cliente
        Route::get('/{cliente}', [ClientesController::class, 'exibir']);

        // Rota de Ação (API)
        Route::delete('/{id}', [ClientesController::class, 'destroy']);
    });

    Route::prefix('/usuario')->group(function () {
        // cadastrar usuario
        Route::post('/', [UsuariosController::class, 'cadastrarUsuario']);

        // atualzar dados do usuario
        Route::put('/{usuario}', [UsuariosController::class, 'atualizarUsuario']);
        
        // exibir um usuario
        Route::get('/{usuario}', [UsuariosController::class, 'exibirUsuario']);
    });

    Route::prefix('/catalogo')->group(function () {
        //visualiza os catalogos ativos
        Route::get('/', [CatalogosController::class, 'visualizarCatalogo']);

        //visualiza os itens do catalogo selecionado
        Route::get('/itens/{id}', [ItensCatalogoController::class, 'visualizarItensCatalogo']);
    });

    //exibir itens selecionados
    Route::get('/itens/{id}', [ItensCatalogoController::class, 'visualizarItens']);

});