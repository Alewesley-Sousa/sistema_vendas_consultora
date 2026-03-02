<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\movimentacao_estoque;

class MovimentacaoEstoqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $movimentacoes = [
            [
                'produto_id' => 1, 
                'quantidade' => 10, 
                'origem_tipo' => 'pedidos', 
                'tipo_movimentacao_id' => 1,
                'usuario_responsavel' => 1
            ],
            [
                'produto_id' => 2, 
                'quantidade' => -10, 
                'origem_tipo' => 'pedidos', 
                'tipo_movimentacao_id' => 2,
                'usuario_responsavel' => 1
            ],
        ];

        foreach ($movimentacoes as $movimentacao) {
            movimentacao_estoque::create($movimentacao);
        }
    }
}
