<?php

use App\Http\Controllers\Auth\AutenticacaoController;
use App\Http\Controllers\Auth\ResetarSenhaController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect()->route('login');
});
// pagina de login
Route::get('/login', [AutenticacaoController::class, 'showLogin'])->name('login');

// Processa o login
Route::post('/login', [AutenticacaoController::class, 'login']);

// cria o token
Route::post('/login/token', [AutenticacaoController::class, 'geraToken']);

// Processa o logout
Route::post('/logout', [AutenticacaoController::class, 'logout'])->name('logout');

// Rotas protegidas por cargo
Route::get('/distribuidora/dashboard', fn() => view('distribuidora.dashboard'))
   ->middleware(['auth', 'cargo:distribuidora'])
   ->name('distribuidora.dashboard');

Route::get('/lider/dashboard', fn() => view('lider.dashboard'))
    ->middleware(['auth', 'cargo:lider'])
    ->name('lider.dashboard');

Route::get('/consultora/dashboard', fn() => view('consultora.dashboard'))
    ->middleware(['auth', 'cargo:consultora'])
    ->name('consultora.dashboard');

Route::get('/recuperar-senha', [ResetarSenhaController::class, 'formularioRecuperacao'])->name('senha-formulario');

Route::post('/recuperar-senha', [ResetarSenhaController::class, 'enviarLinkResetar'])->name('senha-email');

Route::get('/resetar-senha/{token}', [ResetarSenhaController::class, 'formularioAtualizarSenha'])->name('senha.resetar');

Route::post('/resetar-senha', [ResetarSenhaController::class, 'atualizarSenha'])->name('senha.atualizar');
