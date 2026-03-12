<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\usuario;
use App\Models\usuarios;

class ResetarSenhaController extends Controller
{
    public function formularioRecuperacao() {
        return view('recuperar-senha');
    }

    public function enviarLinkResetar(Request $request) {
        $request->validate(['email' => 'required|email']);

        $token = Str::random(60);
        DB::table('resetar_senha_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);

        $link = url('/reset-password/'.$token);

        // Enviar email
        Mail::raw("Clique aqui para resetar sua senha: $link", function($message) use ($request) {
            $message->to($request->email)->subject('Recuperação de senha');
        });

        return back()->with('status', 'Link de recuperação enviado!');
    }

    public function formularioAtualizarSenha($token) {
        return view('senha.atualizar', [
            'token' => $token,
            'email' => request()->query('email'),
        ]);
    }

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
            return back()->withErrors(['email' => 'Token inválido ou expirado']);
        }

        usuarios::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        DB::table('resetar_senha_tokens')->where(['email' => $request->email])->delete();

        return redirect('/login')->with('status', 'Senha alterada com sucesso!');
    }
}

?>