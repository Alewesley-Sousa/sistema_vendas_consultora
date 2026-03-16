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
            // Devolução 9 (pedido 1, parcial)
            [
                'item_pedido_id' => 1,
                'devolucao_id' => 9,
                'quantidade' => 1,
                'subtotal' => 39.90
            ],
            [
                'item_pedido_id' => 2,
                'devolucao_id' => 9,
                'quantidade' => 1,
                'subtotal' => 59.90
            ],

            // Devolução 10 (pedido 2, total)
            [
                'item_pedido_id' => 3,
                'devolucao_id' => 10,
                'quantidade' => 1,
                'subtotal' => 89.90
            ],

            // Devolução 11 (pedido 3, parcial)
            [
                'item_pedido_id' => 4,
                'devolucao_id' => 11,
                'quantidade' => 1,
                'subtotal' => 79.90
            ],
            [
                'item_pedido_id' => 5,
                'devolucao_id' => 11,
                'quantidade' => 1,
                'subtotal' => 69.90
            ],

            // Devolução 12 (pedido 4, total)
            [
                'item_pedido_id' => 6,
                'devolucao_id' => 12,
                'quantidade' => 1,
                'subtotal' => 45.90
            ],
            [
                'item_pedido_id' => 7,
                'devolucao_id' => 12,
                'quantidade' => 1,
                'subtotal' => 129.90
            ],

            // Devolução 13 (pedido 5, parcial)
            [
                'item_pedido_id' => 8,
                'devolucao_id' => 13,
                'quantidade' => 1,
                'subtotal' => 139.90
            ],

            // Devolução 14 (pedido 6, total)
            [
                'item_pedido_id' => 9,
                'devolucao_id' => 14,
                'quantidade' => 1,
                'subtotal' => 34.90
            ],
            [
                'item_pedido_id' => 10,
                'devolucao_id' => 14,
                'quantidade' => 1,
                'subtotal' => 36.90
            ],

            // Devolução 15 (pedido 7, parcial)
            [
                'item_pedido_id' => 11,
                'devolucao_id' => 15,
                'quantidade' => 1,
                'subtotal' => 49.90
            ],

            // Devolução 16 (pedido 9, total)
            [
                'item_pedido_id' => 12,
                'devolucao_id' => 16,
                'quantidade' => 1,
                'subtotal' => 38.70
            ]
        ];

        foreach ($itens as $item) {
            itens_devolucao::create($item);
        }
    }
}
