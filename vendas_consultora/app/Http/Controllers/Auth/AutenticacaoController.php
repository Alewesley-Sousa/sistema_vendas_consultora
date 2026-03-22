<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\usuarios;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

            // url de destino
            $redirectUrl = match ($user->cargo) {
                'distribuidora' => route('distribuidora.dashboard'),
                'lider'         => route('lider.dashboard'),
                'consultora'    => route('consultora.dashboard'),
                default         => null,
            };

            if (!$redirectUrl) {
                Auth::logout();
                return response()->json(['message' => 'Usuário sem permissão.'], 403);
            }

            if ($user->status_id === 3) {
                Auth::logout();
                return response()->json(['message' => 'Usuario não cadastrado'], 403);
            }

            // Criamos o token no mesmo momento do login para o Axios guardar
            $token = $user->createToken('web-acesso')->plainTextToken;

            return response()->json([
                'redirect' => $redirectUrl,
                'token'    => $token,
                'user'     => $user->name
            ]);
        }

        // Se falhar, retornamos erro JSON
        return response()->json(['message' => 'Credenciais inválidas.'], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');

    }

}
