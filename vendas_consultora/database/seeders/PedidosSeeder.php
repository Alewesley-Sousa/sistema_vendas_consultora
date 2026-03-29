<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\pedidos;

class PedidosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pedidos = [
            ['usuario_id' => 2, 'cliente_id' => 1, 'link' => 'https://loja.com/pedido/1001', 'valor_total' => 199.90, 'tipo_pagamento' => 'credito', 'status_id' => 6],
            ['usuario_id' => 3, 'cliente_id' => 2, 'link' => 'https://loja.com/pedido/1002', 'valor_total' => 89.90, 'tipo_pagamento' => 'pix', 'status_id' => 3],
            ['usuario_id' => 4, 'cliente_id' => 3, 'link' => 'https://loja.com/pedido/1003', 'valor_total' => 59.90, 'tipo_pagamento' => 'debito', 'status_id' => 1],
            ['usuario_id' => 5, 'cliente_id' => 4, 'link' => 'https://loja.com/pedido/1004', 'valor_total' => 149.90, 'tipo_pagamento' => 'credito', 'status_id' => 5],
            ['usuario_id' => 6, 'cliente_id' => 5, 'link' => 'https://loja.com/pedido/1005', 'valor_total' => 79.90, 'tipo_pagamento' => 'pix', 'status_id' => 2],
            ['usuario_id' => 7, 'cliente_id' => 6, 'link' => 'https://loja.com/pedido/1006', 'valor_total' => 129.90, 'tipo_pagamento' => 'debito', 'status_id' => 4],
            ['usuario_id' => 8, 'cliente_id' => 7, 'link' => 'https://loja.com/pedido/1007', 'valor_total' => 39.90, 'tipo_pagamento' => 'credito', 'status_id' => 1],
            ['usuario_id' => 9, 'cliente_id' => 8, 'link' => 'https://loja.com/pedido/1008', 'valor_total' => 249.90, 'tipo_pagamento' => 'pix', 'status_id' => 3],
            ['usuario_id' => 10, 'cliente_id' => 9, 'link' => 'https://loja.com/pedido/1009', 'valor_total' => 99.90, 'tipo_pagamento' => 'debito', 'status_id' => 5],
            ['usuario_id' => 11, 'cliente_id' => 10, 'link' => 'https://loja.com/pedido/1010', 'valor_total' => 59.90, 'tipo_pagamento' => 'credito', 'status_id' => 2],
            ['usuario_id' => 12, 'cliente_id' => 11, 'link' => 'https://loja.com/pedido/1011', 'valor_total' => 179.90, 'tipo_pagamento' => 'pix', 'status_id' => 4],
            ['usuario_id' => 13, 'cliente_id' => 12, 'link' => 'https://loja.com/pedido/1012', 'valor_total' => 119.90, 'tipo_pagamento' => 'debito', 'status_id' => 6],
            ['usuario_id' => 14, 'cliente_id' => 13, 'link' => 'https://loja.com/pedido/1013', 'valor_total' => 89.90, 'tipo_pagamento' => 'credito', 'status_id' => 3],
            ['usuario_id' => 15, 'cliente_id' => 1, 'link' => 'https://loja.com/pedido/1014', 'valor_total' => 139.90, 'tipo_pagamento' => 'pix', 'status_id' => 5],
            ['usuario_id' => 16, 'cliente_id' => 2, 'link' => 'https://loja.com/pedido/1015', 'valor_total' => 49.90, 'tipo_pagamento' => 'debito', 'status_id' => 3],
            ['usuario_id' => 2, 'cliente_id' => 3, 'link' => 'https://loja.com/pedido/1016', 'valor_total' => 229.90, 'tipo_pagamento' => 'credito', 'status_id' => 6],
            ['usuario_id' => 3, 'cliente_id' => 4, 'link' => 'https://loja.com/pedido/1017', 'valor_total' => 109.90, 'tipo_pagamento' => 'pix', 'status_id' => 2],
            ['usuario_id' => 4, 'cliente_id' => 5, 'link' => 'https://loja.com/pedido/1018', 'valor_total' => 69.90, 'tipo_pagamento' => 'debito', 'status_id' => 4],
            ['usuario_id' => 5, 'cliente_id' => 6, 'link' => 'https://loja.com/pedido/1019', 'valor_total' => 199.90, 'tipo_pagamento' => 'credito', 'status_id' => 1],
            ['usuario_id' => 6, 'cliente_id' => 7, 'link' => 'https://loja.com/pedido/1020', 'valor_total' => 159.90, 'tipo_pagamento' => 'pix', 'status_id' => 5],
        ];

        foreach ($pedidos as $pedido) {
            pedidos::create($pedido);
        }
    }
}
