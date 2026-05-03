<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\produtos;
use App\Models\clientes;
use App\Models\pedidos;

class ConsultoraController extends Controller
{
    public function dashboard()
    {
        return view('consultora.dashboard');
    }

    public function stats()
    {
        $user = Auth::user();

        // Estatísticas para consultora
        $stats = [
            'total_produtos' => produtos::where('usuario_id', $user->id)->count(),
            'total_clientes' => clientes::where('consultora_id', $user->id)->count(),
            'total_pedidos' => pedidos::where('usuario_id', $user->id)->count(),
            'receita_total' => pedidos::where('usuario_id', $user->id)->sum('valor_total'),
        ];

        return response()->json([
            'status' => 'success',
            'dados' => $stats
        ]);
    }

    public function listarProdutos()
    {
        $user = Auth::user();
        $produtos = produtos::where('usuario_id', $user->id)->with(['categoria', 'status'])->get();

        return view('consultora.produtos', compact('produtos'));
    }

    public function listarClientes()
    {
        $user = Auth::user();
        $clientes = clientes::where('consultora_id', $user->id)->get();

        return view('consultora.clientes', compact('clientes'));
    }
}