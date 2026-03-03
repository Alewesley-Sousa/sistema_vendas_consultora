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
        $itens = [
            // Devolução 9 (pedido 1, parcial)
            ['item_pedido_id' => null, 'devolucao_id' => null, 'quantidade' => 1, 'subtotal' => 39.90],
            ['item_pedido_id' => null, 'devolucao_id' => null, 'quantidade' => 1, 'subtotal' => 59.90],

            // Devolução 10 (pedido 2, total)
            ['item_pedido_id' => null, 'devolucao_id' => null, 'quantidade' => 1, 'subtotal' => 89.90],

            // Devolução 11 (pedido 3, parcial)
            ['item_pedido_id' => null, 'devolucao_id' => null, 'quantidade' => 1, 'subtotal' => 79.90],
            ['item_pedido_id' => null, 'devolucao_id' => null, 'quantidade' => 1, 'subtotal' => 69.90],

            // Devolução 12 (pedido 4, total)
            ['item_pedido_id' => null, 'devolucao_id' => null, 'quantidade' => 1, 'subtotal' => 45.90],
            ['item_pedido_id' => null, 'devolucao_id' => null, 'quantidade' => 1, 'subtotal' => 129.90],

            // Devolução 13 (pedido 5, parcial)
            ['item_pedido_id' => null, 'devolucao_id' => null, 'quantidade' => 1, 'subtotal' => 139.90],

            // Devolução 14 (pedido 6, total)
            ['item_pedido_id' => null, 'devolucao_id' => null, 'quantidade' => 1, 'subtotal' => 34.90],
            ['item_pedido_id' => null, 'devolucao_id' => null, 'quantidade' => 1, 'subtotal' => 36.90]
        ];

        foreach ($itens as $item) {
            itens_devolucao::create($item);
        }
    }
}
