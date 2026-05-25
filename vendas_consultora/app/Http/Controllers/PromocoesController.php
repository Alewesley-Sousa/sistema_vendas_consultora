<?php

namespace App\Http\Controllers;

use App\Models\promocoes;
use Illuminate\Http\Request;

class PromocoesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Exemplo de dados para teste
public function index() {
    $promocoes = [
        ['id' => 1, 'nome' => 'Verão Glow', 'status' => 'Ativa', 'data_inicio' => '2026-05-01', 'data_fim' => '2026-05-30'],
        ['id' => 2, 'nome' => 'Dia das Mães', 'status' => 'Expirada', 'data_inicio' => '2026-04-01', 'data_fim' => '2026-05-10'],
    ];
    return view('distribuidora.promocoes', compact('promocoes'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(promocoes $promocoes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(promocoes $promocoes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, promocoes $promocoes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(promocoes $promocoes)
    {
        //
    }
}
