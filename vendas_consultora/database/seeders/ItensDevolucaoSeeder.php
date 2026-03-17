<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\itens_devolucao;

class ItensDevolucaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $itensDevolucao = [
            // Devolução 1 (pedido 1, parcial) — devolveu 1 unidade do item_pedido_id 1
            [
                'item_pedido_id' => 1,
                'devolucao_id' => 1,
                'quantidade' => 1,
                'subtotal' => 39.90
            ],

            // Devolução 2 (pedido 2, total)
            [
                'item_pedido_id' => 3,
                'devolucao_id' => 2,
                'quantidade' => 1,
                'subtotal' => 89.90
            ],

            // Devolução 3 (pedido 3, parcial) — devolveu o item_pedido_id 4
            [
                'item_pedido_id' => 4,
                'devolucao_id' => 3,
                'quantidade' => 1,
                'subtotal' => 79.90
            ],

            // Devolução 4 (pedido 4, total) — devolveu ambos os itens do pedido 4
            [
                'item_pedido_id' => 6,
                'devolucao_id' => 4,
                'quantidade' => 1,
                'subtotal' => 45.90
            ],
            [
                'item_pedido_id' => 7,
                'devolucao_id' => 4,
                'quantidade' => 1,
                'subtotal' => 129.90
            ],

            // Devolução 5 (pedido 5, parcial)
            [
                'item_pedido_id' => 8,
                'devolucao_id' => 5,
                'quantidade' => 1,
                'subtotal' => 139.90
            ],

            // Devolução 6 (pedido 6, total) — devolveu todos os itens do pedido 6
            [
                'item_pedido_id' => 9,
                'devolucao_id' => 6,
                'quantidade' => 2,
                'subtotal' => 69.80
            ],
            [
                'item_pedido_id' => 10,
                'devolucao_id' => 6,
                'quantidade' => 1,
                'subtotal' => 36.90
            ],

            // Devolução 7 (pedido 7, parcial)
            [
                'item_pedido_id' => 11,
                'devolucao_id' => 7,
                'quantidade' => 1,
                'subtotal' => 49.90
            ],

            // Devolução 8 (pedido 9, total)
            [
                'item_pedido_id' => 14,
                'devolucao_id' => 8,
                'quantidade' => 2,
                'subtotal' => 49.80
            ],
        ];

        foreach ($itensDevolucao as $item) {
            itens_devolucao::create($item);
        }
    }
}
