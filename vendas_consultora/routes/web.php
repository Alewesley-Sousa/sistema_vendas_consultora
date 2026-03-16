<?php

use App\Http\Controllers\Auth\AutenticacaoController;
use App\Http\Controllers\Auth\ResetarSenhaController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/login', [AutenticacaoController::class, 'showLogin'])->name('login');
Route::post('/login', [AutenticacaoController::class, 'login']);
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
