<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AutenticacaoController;
use App\Http\Controllers\ResetarSenhaController;

Route::get('/login', [AutenticacaoController::class, 'showLogin'])->name('login');
Route::post('/login', [AutenticacaoController::class, 'login']);
Route::post('/logout', [AutenticacaoController::class, 'logout'])->name('logout');

// Rotas protegidas por cargo
Route::get('/distribuidora/dashboard', fn() => view('distribuidora.dashboard')); 
   // ->middleware(['auth', 'cargo:distribuidora']);

Route::get('/lider/dashboard', fn() => view('lider.dashboard'));
    // ->middleware(['auth', 'cargo:lider']);

Route::get('/consultora/dashboard', fn() => view('consultora.dashboard'));
    // ->middleware(['auth', 'cargo:consultora']);

Route::get('/recuperar-senha', [ResetarSenhaController::class, 'formularioRecuperacao'])->name('senha-formulario');

Route::post('/recuperar-senha', [ResetarSenhaController::class, 'enviarLinkResetar'])->name('senha-email');

Route::get('/resetar-senha/{token}', [ResetarSenhaController::class, 'formularioAtualizarSenha'])->name('senha.resetar');

Route::post('/resetar-senha', [ResetarSenhaController::class, 'atualizarSenha'])->name('senha.update');
