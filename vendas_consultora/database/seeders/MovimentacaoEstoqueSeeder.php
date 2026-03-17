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
            // MOVIMENTAÇÕES DE SAÍDA POR PEDIDOS (baseado nos itens_pedido)
            ['produto_id' => 1, 'quantidade' => -2, 'origem_tipo' => 'pedido', 'origem_id' => 1, 'tipo_movimentacao_id' => 2, 'usuario_responsavel' => 1],
            ['produto_id' => 2, 'quantidade' => -1, 'origem_tipo' => 'pedido', 'origem_id' => 1, 'tipo_movimentacao_id' => 2, 'usuario_responsavel' => 1],
            ['produto_id' => 3, 'quantidade' => -1, 'origem_tipo' => 'pedido', 'origem_id' => 2, 'tipo_movimentacao_id' => 2, 'usuario_responsavel' => 1],
            ['produto_id' => 4, 'quantidade' => -1, 'origem_tipo' => 'pedido', 'origem_id' => 3, 'tipo_movimentacao_id' => 2, 'usuario_responsavel' => 1],
            ['produto_id' => 5, 'quantidade' => -2, 'origem_tipo' => 'pedido', 'origem_id' => 3, 'tipo_movimentacao_id' => 2, 'usuario_responsavel' => 1],
            ['produto_id' => 6, 'quantidade' => -1, 'origem_tipo' => 'pedido', 'origem_id' => 4, 'tipo_movimentacao_id' => 2, 'usuario_responsavel' => 1],
            ['produto_id' => 7, 'quantidade' => -1, 'origem_tipo' => 'pedido', 'origem_id' => 4, 'tipo_movimentacao_id' => 2, 'usuario_responsavel' => 1],
            ['produto_id' => 8, 'quantidade' => -1, 'origem_tipo' => 'pedido', 'origem_id' => 5, 'tipo_movimentacao_id' => 2, 'usuario_responsavel' => 1],
            ['produto_id' => 9, 'quantidade' => -2, 'origem_tipo' => 'pedido', 'origem_id' => 6, 'tipo_movimentacao_id' => 2, 'usuario_responsavel' => 1],
            ['produto_id' => 10, 'quantidade' => -1, 'origem_tipo' => 'pedido', 'origem_id' => 6, 'tipo_movimentacao_id' => 2, 'usuario_responsavel' => 1],
            ['produto_id' => 11, 'quantidade' => -1, 'origem_tipo' => 'pedido', 'origem_id' => 7, 'tipo_movimentacao_id' => 2, 'usuario_responsavel' => 1],
            ['produto_id' => 12, 'quantidade' => -3, 'origem_tipo' => 'pedido', 'origem_id' => 8, 'tipo_movimentacao_id' => 2, 'usuario_responsavel' => 1],
            ['produto_id' => 13, 'quantidade' => -1, 'origem_tipo' => 'pedido', 'origem_id' => 8, 'tipo_movimentacao_id' => 2, 'usuario_responsavel' => 1],
            ['produto_id' => 14, 'quantidade' => -2, 'origem_tipo' => 'pedido', 'origem_id' => 9, 'tipo_movimentacao_id' => 2, 'usuario_responsavel' => 1],
            ['produto_id' => 15, 'quantidade' => -1, 'origem_tipo' => 'pedido', 'origem_id' => 10, 'tipo_movimentacao_id' => 2, 'usuario_responsavel' => 1],
            ['produto_id' => 16, 'quantidade' => -1, 'origem_tipo' => 'pedido', 'origem_id' => 10, 'tipo_movimentacao_id' => 2, 'usuario_responsavel' => 1],
            ['produto_id' => 17, 'quantidade' => -1, 'origem_tipo' => 'pedido', 'origem_id' => 11, 'tipo_movimentacao_id' => 2, 'usuario_responsavel' => 1],
            ['produto_id' => 18, 'quantidade' => -1, 'origem_tipo' => 'pedido', 'origem_id' => 12, 'tipo_movimentacao_id' => 2, 'usuario_responsavel' => 1],
            ['produto_id' => 19, 'quantidade' => -2, 'origem_tipo' => 'pedido', 'origem_id' => 13, 'tipo_movimentacao_id' => 2, 'usuario_responsavel' => 1],
            ['produto_id' => 20, 'quantidade' => -1, 'origem_tipo' => 'pedido', 'origem_id' => 14, 'tipo_movimentacao_id' => 2, 'usuario_responsavel' => 1],
            ['produto_id' => 1, 'quantidade' => -1, 'origem_tipo' => 'pedido', 'origem_id' => 15, 'tipo_movimentacao_id' => 2, 'usuario_responsavel' => 1],
            ['produto_id' => 2, 'quantidade' => -1, 'origem_tipo' => 'pedido', 'origem_id' => 15, 'tipo_movimentacao_id' => 2, 'usuario_responsavel' => 1],
            ['produto_id' => 3, 'quantidade' => -2, 'origem_tipo' => 'pedido', 'origem_id' => 16, 'tipo_movimentacao_id' => 2, 'usuario_responsavel' => 1],
            ['produto_id' => 4, 'quantidade' => -1, 'origem_tipo' => 'pedido', 'origem_id' => 17, 'tipo_movimentacao_id' => 2, 'usuario_responsavel' => 1],
            ['produto_id' => 5, 'quantidade' => -1, 'origem_tipo' => 'pedido', 'origem_id' => 17, 'tipo_movimentacao_id' => 2, 'usuario_responsavel' => 1],
            ['produto_id' => 6, 'quantidade' => -1, 'origem_tipo' => 'pedido', 'origem_id' => 18, 'tipo_movimentacao_id' => 2, 'usuario_responsavel' => 1],
            ['produto_id' => 7, 'quantidade' => -1, 'origem_tipo' => 'pedido', 'origem_id' => 18, 'tipo_movimentacao_id' => 2, 'usuario_responsavel' => 1],
            ['produto_id' => 8, 'quantidade' => -1, 'origem_tipo' => 'pedido', 'origem_id' => 19, 'tipo_movimentacao_id' => 2, 'usuario_responsavel' => 1],
            ['produto_id' => 9, 'quantidade' => -1, 'origem_tipo' => 'pedido', 'origem_id' => 19, 'tipo_movimentacao_id' => 2, 'usuario_responsavel' => 1],
            ['produto_id' => 10, 'quantidade' => -1, 'origem_tipo' => 'pedido', 'origem_id' => 20, 'tipo_movimentacao_id' => 2, 'usuario_responsavel' => 1],
            ['produto_id' => 11, 'quantidade' => -2, 'origem_tipo' => 'pedido', 'origem_id' => 20, 'tipo_movimentacao_id' => 2, 'usuario_responsavel' => 1],
            
            // MOVIMENTAÇÕES DE ENTRADA POR DEVOLUÇÕES (itens_devolucao)
            // Devolução 9 (pedido 1, parcial)
            ['produto_id' => 1, 'quantidade' => 1, 'origem_tipo' => 'devolucao', 'origem_id' => 9, 'tipo_movimentacao_id' => 1, 'usuario_responsavel' => 1],
            ['produto_id' => 2, 'quantidade' => 1, 'origem_tipo' => 'devolucao', 'origem_id' => 9, 'tipo_movimentacao_id' => 1, 'usuario_responsavel' => 1],
            
            // Devolução 10 (pedido 2, total)
            ['produto_id' => 3, 'quantidade' => 1, 'origem_tipo' => 'devolucao', 'origem_id' => 10, 'tipo_movimentacao_id' => 1, 'usuario_responsavel' => 1],
            
            // Devolução 11 (pedido 3, parcial)
            ['produto_id' => 4, 'quantidade' => 1, 'origem_tipo' => 'devolucao', 'origem_id' => 11, 'tipo_movimentacao_id' => 1, 'usuario_responsavel' => 1],
            ['produto_id' => 5, 'quantidade' => 1, 'origem_tipo' => 'devolucao', 'origem_id' => 11, 'tipo_movimentacao_id' => 1, 'usuario_responsavel' => 1],
            
            // Devolução 12 (pedido 4, total)
            ['produto_id' => 6, 'quantidade' => 1, 'origem_tipo' => 'devolucao', 'origem_id' => 12, 'tipo_movimentacao_id' => 1, 'usuario_responsavel' => 1],
            ['produto_id' => 7, 'quantidade' => 1, 'origem_tipo' => 'devolucao', 'origem_id' => 12, 'tipo_movimentacao_id' => 1, 'usuario_responsavel' => 1],
            
            // Devolução 13 (pedido 5, parcial)
            ['produto_id' => 8, 'quantidade' => 1, 'origem_tipo' => 'devolucao', 'origem_id' => 13, 'tipo_movimentacao_id' => 1, 'usuario_responsavel' => 1],
            
            // Devolução 14 (pedido 6, total)
            ['produto_id' => 9, 'quantidade' => 1, 'origem_tipo' => 'devolucao', 'origem_id' => 14, 'tipo_movimentacao_id' => 1, 'usuario_responsavel' => 1],
            ['produto_id' => 10, 'quantidade' => 1, 'origem_tipo' => 'devolucao', 'origem_id' => 14, 'tipo_movimentacao_id' => 1, 'usuario_responsavel' => 1],
            
            // Devolução 15 (pedido 7, parcial)
            ['produto_id' => 11, 'quantidade' => 1, 'origem_tipo' => 'devolucao', 'origem_id' => 15, 'tipo_movimentacao_id' => 1, 'usuario_responsavel' => 1],
            
            // Devolução 16 (pedido 9, total)
            ['produto_id' => 12, 'quantidade' => 1, 'origem_tipo' => 'devolucao', 'origem_id' => 16, 'tipo_movimentacao_id' => 1, 'usuario_responsavel' => 1],
        ];

        foreach ($movimentacoes as $movimentacao) {
            movimentacao_estoque::create($movimentacao);
        }
    }
}
