<?php

use App\Http\Controllers\ComissoesController;
use App\Http\Controllers\MetasController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\UsuariosController;

Route::get('/usr', [UsuariosController::class, 'index']);
// Pegar comissao atual do usuario autenticado
Route::get('/comissao', [ComissoesController::class, 'visualizar'])->middleware('auth:sanctum');

//pegar meta atual do usuario autenticado
Route::get('/meta', [MetasController::class, 'metaAtual'])->middleware('auth:sanctum');

// pegar progresso atual da meta do usuario autenticado
Route::get('/meta/progresso', [MetasController::class, 'progressoMeta'])->middleware('auth:sanctum');