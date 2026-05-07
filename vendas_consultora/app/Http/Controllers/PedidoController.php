<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

/**
 * Autor: Gemini Code Assist
 * Data: 01/04/2026
 * Descrição: Controller responsável pela gestão de pedidos de clientes.
 */
class PedidoController extends Controller
{
    public function create()
    {
        // Busca apenas produtos ativos (status_id = 1 conforme estrutura-banco-de-dados.sql)
        $produtos = Produto::where('status_id', 1)->get();

        return view('em-dev-front.pedidos-clientes', compact('produtos'));
    }
}