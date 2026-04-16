@extends('layouts.app')

@section('title', 'Login - Sistema de Vendas')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
<style>
    .login-container-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 80vh;
    }
    .form-group input { text-align: center; }
    .form-group label { width: 100%; text-align: center; }
</style>
@endpush

@section('content')
<div class="login-container-wrapper">
    <div class="login-container">
        <div class="login-header">
            <h1>Sistema de Vendas</h1>
            <p>Consultora e vendas</p>
        </div>

        <form id="loginForm" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <input type="email" id="email" name="email" required placeholder=" ">
                <label for="email">E-mail</label>
            </div>

            <div class="form-group">
                <input type="password" id="password" name="password" required placeholder=" ">
                <label for="password">Senha</label>
            </div>

            <button type="submit" class="btn-login" id="btnLogin">
                Entrar
            </button>
        </form>

        <div class="auth-links">
            <a href="{{ url('dev/cadastro-consultora') }}" id="registerLink">Criar nova conta</a>
            <span class="separator">|</span>
            <a href="#" id="forgotLink">Esqueceu sua senha?</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/java.js') }}"></script>
@endpush