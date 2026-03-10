<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\pagamentos;

class PagamentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pagamentos = [
            [
                'pedido_id' => 1,
                'tipo_pagamento' => 'credito',
                'valor' => 10550.00,
                'status' => 'aprovado',
                'codigo_transacao' => 'asadas123432423edas1231dwqd2',
                'data_solicitacao' => '2026-02-10',
                'data_confirmacao' => '2026-02-12'
            ]
        ];

        foreach ($pagamentos as $pagamento) {
            pagamentos::forceCreate($pagamento);
        }
    }
}
