<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\usuarios;
use App\Http\Controllers\Controller;

class ResetarSenhaController extends Controller
{
    public function formularioRecuperacao() {
        return view('recuperar-senha');
    }

    // Enviar o link
    public function enviarLinkResetar(Request $request) {
        $request->validate(['email' => 'required|email']);

        $token = Str::random(60);
        DB::table('resetar_senha_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);

        $link = url('/resetar-senha/'.$token.'?email='.urlencode($request->email));

        Mail::raw("Clique aqui para resetar sua senha: $link", function($message) use ($request) {
            $message->to($request->email)->subject('Recuperação de senha');
        });

        // RETORNO AJAX
        return response()->json(['message' => 'Link de recuperação enviado com sucesso!']);
    }


    public function formularioAtualizarSenha($token) {
        return view('atualizar-senha', [
            'token' => $token,
            'email' => request()->query('email'),
        ]);
    }

    // Atualizar a senha
    public function atualizarSenha(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required'
        ]);

        $reset = DB::table('resetar_senha_tokens')->where([
            'email' => $request->email,
            'token' => $request->token
        ])->first();

        if (!$reset) {
            return response()->json(['message' => 'Token inválido ou expirado.'], 422);
        }

        // Usando seu modelo "usuarios" conforme o User Summary
        usuarios::where('email', $request->email)->update([
            'senha' => Hash::make($request->password)
        ]);

        DB::table('resetar_senha_tokens')->where(['email' => $request->email])->delete();

        return response()->json(['message' => 'Senha alterada com sucesso!', 'redirect' => '/login']);
    }
}

?>