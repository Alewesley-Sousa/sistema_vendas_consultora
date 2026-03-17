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

    public function enviarLinkResetar(Request $request) {
        $request->validate(['email' => 'required|email']);

        $token = Str::random(60);
        DB::table('resetar_senha_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);

         $link = url('/reset-password/'.$token.'?email='.urlencode($request->email));


        // Enviar email
        Mail::raw("Clique aqui para resetar sua senha: $link", function($message) use ($request, $link) {
            $message->to($request->email)->subject('Recuperação de senha');
        });


        return back()->with('status', 'Link de recuperação enviado!');
    }

    public function formularioAtualizarSenha($token) {
        return view('atualizarSenha', [
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
            'senha' => Hash::make($request->password)
        ]);

        DB::table('resetar_senha_tokens')->where(['email' => $request->email])->delete();

        return redirect('/login')->with('status', 'Senha alterada com sucesso!');
    }
}

?>