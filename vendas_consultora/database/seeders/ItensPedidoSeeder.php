<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\itens_pedido;

class ItensPedidoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $itens = [
            // Pedido 1
            ['item_catalogo_id' => 1, 'pedido_id' => 1, 'quantidade' => 2, 'preco_unitario' => 39.90, 'subtotal' => 79.80],
            ['item_catalogo_id' => 2, 'pedido_id' => 1, 'quantidade' => 1, 'preco_unitario' => 59.90, 'subtotal' => 59.90],
            // Pedido 2
            ['item_catalogo_id' => 3, 'pedido_id' => 2, 'quantidade' => 1, 'preco_unitario' => 89.90, 'subtotal' => 89.90],
            // Pedido 3
            ['item_catalogo_id' => 4, 'pedido_id' => 3, 'quantidade' => 1, 'preco_unitario' => 79.90, 'subtotal' => 79.90],
            ['item_catalogo_id' => 5, 'pedido_id' => 3, 'quantidade' => 2, 'preco_unitario' => 69.90, 'subtotal' => 139.80],
            // Pedido 4
            ['item_catalogo_id' => 6, 'pedido_id' => 4, 'quantidade' => 1, 'preco_unitario' => 45.90, 'subtotal' => 45.90],
            ['item_catalogo_id' => 7, 'pedido_id' => 4, 'quantidade' => 1, 'preco_unitario' => 129.90, 'subtotal' => 129.90],
            // Pedido 5
            ['item_catalogo_id' => 8, 'pedido_id' => 5, 'quantidade' => 1, 'preco_unitario' => 139.90, 'subtotal' => 139.90],
            // Pedido 6
            ['item_catalogo_id' => 9, 'pedido_id' => 6, 'quantidade' => 2, 'preco_unitario' => 34.90, 'subtotal' => 69.80],
            ['item_catalogo_id' => 10, 'pedido_id' => 6, 'quantidade' => 1, 'preco_unitario' => 36.90, 'subtotal' => 36.90],
            // Pedido 7
            ['item_catalogo_id' => 11, 'pedido_id' => 7, 'quantidade' => 1, 'preco_unitario' => 49.90, 'subtotal' => 49.90],
            // Pedido 8
            ['item_catalogo_id' => 12, 'pedido_id' => 8, 'quantidade' => 3, 'preco_unitario' => 12.90, 'subtotal' => 38.70],
            // Pedido 9
            ['item_catalogo_id' => 6, 'pedido_id' => 9, 'quantidade' => 2, 'preco_unitario' => 24.90, 'subtotal' => 49.80],
            // Pedido 10
            ['item_catalogo_id' => 7, 'pedido_id' => 10, 'quantidade' => 1, 'preco_unitario' => 39.90, 'subtotal' => 39.90],
            ['item_catalogo_id' => 8, 'pedido_id' => 10, 'quantidade' => 1, 'preco_unitario' => 99.90, 'subtotal' => 99.90],
            // Pedido 11
            ['item_catalogo_id' => 9, 'pedido_id' => 11, 'quantidade' => 1, 'preco_unitario' => 119.90, 'subtotal' => 119.90],
            // Pedido 12
            ['item_catalogo_id' => 10, 'pedido_id' => 12, 'quantidade' => 1, 'preco_unitario' => 199.90, 'subtotal' => 199.90],
            // Pedido 13
            ['item_catalogo_id' => 11, 'pedido_id' => 13, 'quantidade' => 2, 'preco_unitario' => 59.90, 'subtotal' => 119.80],
            // Pedido 14
            ['item_catalogo_id' => 12, 'pedido_id' => 14, 'quantidade' => 1, 'preco_unitario' => 149.90, 'subtotal' => 149.90],
            // Pedido 15
            ['item_catalogo_id' => 1, 'pedido_id' => 15, 'quantidade' => 1, 'preco_unitario' => 39.90, 'subtotal' => 39.90],
            ['item_catalogo_id' => 2, 'pedido_id' => 15, 'quantidade' => 1, 'preco_unitario' => 59.90, 'subtotal' => 59.90],
            // Pedido 16
            ['item_catalogo_id' => 3, 'pedido_id' => 16, 'quantidade' => 2, 'preco_unitario' => 89.90, 'subtotal' => 179.80],
            // Pedido 17
            ['item_catalogo_id' => 4, 'pedido_id' => 17, 'quantidade' => 1, 'preco_unitario' => 79.90, 'subtotal' => 79.90],
            ['item_catalogo_id' => 5, 'pedido_id' => 17, 'quantidade' => 1, 'preco_unitario' => 69.90, 'subtotal' => 69.90],
            // Pedido 18
            ['item_catalogo_id' => 6, 'pedido_id' => 18, 'quantidade' => 1, 'preco_unitario' => 45.90, 'subtotal' => 45.90],
            ['item_catalogo_id' => 7, 'pedido_id' => 18, 'quantidade' => 1, 'preco_unitario' => 129.90, 'subtotal' => 129.90],
            // Pedido 19
            ['item_catalogo_id' => 8, 'pedido_id' => 19, 'quantidade' => 1, 'preco_unitario' => 139.90, 'subtotal' => 139.90],
            ['item_catalogo_id' => 9, 'pedido_id' => 19, 'quantidade' => 1, 'preco_unitario' => 34.90, 'subtotal' => 34.90],
            // Pedido 20
            ['item_catalogo_id' => 10, 'pedido_id' => 20, 'quantidade' => 1, 'preco_unitario' => 36.90, 'subtotal' => 36.90],
            ['item_catalogo_id' => 11, 'pedido_id' => 20, 'quantidade' => 2, 'preco_unitario' => 49.90, 'subtotal' => 99.80],
        ];

        DB::table('itens_pedido')->insert($itens);
    }
}
