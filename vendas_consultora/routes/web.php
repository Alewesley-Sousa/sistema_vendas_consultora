<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AutenticacaoController;

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

