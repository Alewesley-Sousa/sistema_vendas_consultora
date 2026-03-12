<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



class AutenticacaoController extends Controller
{
    public function showLogin(Request $request)
    {
        return view('login');

    }
    
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redireciona conforme o cargo já existente na tabela
            switch ($user->cargo) {
                case 'distribuidora':
                    return redirect()->route('distribuidora.dashboard');
                case 'lider':
                    return redirect()->route('lider.dashboard');
                case 'consultora':
                    return redirect()->route('consultora.dashboard');
            default:
                // Se não tiver cargo válido, faz logout e mostra erro
                Auth::logout();
                return back()->withErrors([
                    'cargo' => 'Seu usuário não possui permissão para acessar o sistema.',
                ]);
            }
        }

        return back()->withErrors([
            'email' => 'Credenciais inválidas.',
        ]);

    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');

    }

}
