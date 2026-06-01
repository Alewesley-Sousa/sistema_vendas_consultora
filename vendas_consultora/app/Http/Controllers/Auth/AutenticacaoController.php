<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia; // <--- Importação do Inertia

class AutenticacaoController extends Controller
{
    public function showLogin(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();

            return match ($user->cargo) {
                'distribuidora' => redirect()->route('distribuidora.dashboard'),
                'lider'         => redirect()->route('lider.dashboard'),
                'consultora'    => redirect()->route('consultora.dashboard'),
                default         => redirect()->route('login'),
            };
        }

        // Em vez de view('auth.login'), chamamos o componente Vue
        return Inertia::render('Auth/Login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Validação de status
            if ($user->status_id === 3) {
                Auth::logout();
                return back()->withErrors(['email' => 'Usuário não cadastrado ou inativo.']);
            }

            // Criamos o token (caso você use ele em chamadas paralelas de API com Axios)
            $token = $user->createToken('web-acesso')->plainTextToken;
            session(['api_token' => $token]); // Guarda na sessão se precisar recuperar no front depois

            // O Inertia rastreia este redirecionamento e atualiza a SPA automaticamente
            return match ($user->cargo) {
                'distribuidora' => redirect()->route('distribuidora.dashboard'),
                'lider'         => redirect()->route('lider.dashboard'),
                'consultora'    => redirect()->route('consultora.dashboard'),
                default         => redirect()->route('login'),
            };
        }

        // Se falhar, retorna o erro padrão mapeado para o formulário do Vue
        return back()->withErrors([
            'email' => 'As credenciais fornecidas não coincidem com nossos registros.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}