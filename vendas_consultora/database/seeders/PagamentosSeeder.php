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
                'valor' => 199.90,
                'status' => 'aprovado',
                'codigo_transacao' => 'TX1001ABC',
                'data_solicitacao' => '2026-02-24 19:18:18',
                'data_confirmacao' => '2026-02-24 19:20:00',
                'usuario_responsavel' => 1
            ],
            [
                'pedido_id' => 2,
                'tipo_pagamento' => 'pix',
                'valor' => 89.90,
                'status' => 'pendente',
                'codigo_transacao' => 'TX1002DEF',
                'data_solicitacao' => '2026-02-24 19:18:18',
                'data_confirmacao' => null,
                'usuario_responsavel' => 1
            ],
            [
                'pedido_id' => 3,
                'tipo_pagamento' => 'debito',
                'valor' => 59.90,
                'status' => 'aprovado',
                'codigo_transacao' => 'TX1003GHI',
                'data_solicitacao' => '2026-02-24 19:18:18',
                'data_confirmacao' => '2026-02-24 19:19:30',
                'usuario_responsavel' => 1
            ],
            [
                'pedido_id' => 4,
                'tipo_pagamento' => 'credito',
                'valor' => 149.90,
                'status' => 'recusado',
                'codigo_transacao' => 'TX1004JKL',
                'data_solicitacao' => '2026-02-24 19:18:18',
                'data_confirmacao' => null,
                'usuario_responsavel' => 1
            ],
            [
                'pedido_id' => 5,
                'tipo_pagamento' => 'pix',
                'valor' => 79.90,
                'status' => 'aprovado',
                'codigo_transacao' => 'TX1005MNO',
                'data_solicitacao' => '2026-02-24 19:18:18',
                'data_confirmacao' => '2026-02-24 19:21:00',
                'usuario_responsavel' => 1
            ],
            [
                'pedido_id' => 6,
                'tipo_pagamento' => 'debito',
                'valor' => 129.90,
                'status' => 'em_analise',
                'codigo_transacao' => 'TX1006PQR',
                'data_solicitacao' => '2026-02-24 19:18:18',
                'data_confirmacao' => null,
                'usuario_responsavel' => 1
            ],
            [
                'pedido_id' => 7,
                'tipo_pagamento' => 'credito',
                'valor' => 39.90,
                'status' => 'aprovado',
                'codigo_transacao' => 'TX1007STU',
                'data_solicitacao' => '2026-02-24 19:18:18',
                'data_confirmacao' => '2026-02-24 19:19:50',
                'usuario_responsavel' => 1
            ],
            [
                'pedido_id' => 8,
                'tipo_pagamento' => 'pix',
                'valor' => 249.90,
                'status' => 'pendente',
                'codigo_transacao' => 'TX1008VWX',
                'data_solicitacao' => '2026-02-24 19:18:18',
                'data_confirmacao' => null,
                'usuario_responsavel' => 1
            ],
            [
                'pedido_id' => 9,
                'tipo_pagamento' => 'debito',
                'valor' => 99.90,
                'status' => 'aprovado',
                'codigo_transacao' => 'TX1009YZA',
                'data_solicitacao' => '2026-02-24 19:18:18',
                'data_confirmacao' => '2026-02-24 19:20:10',
                'usuario_responsavel' => 1
            ],
            [
                'pedido_id' => 10,
                'tipo_pagamento' => 'credito',
                'valor' => 59.90,
                'status' => 'estornado',
                'codigo_transacao' => 'TX1010BCD',
                'data_solicitacao' => '2026-02-24 19:18:18',
                'data_confirmacao' => '2026-02-25 10:00:00',
                'usuario_responsavel' => 1
            ],
            [
                'pedido_id' => 11,
                'tipo_pagamento' => 'pix',
                'valor' => 179.90,
                'status' => 'aprovado',
                'codigo_transacao' => 'TX1011EFG',
                'data_solicitacao' => '2026-02-24 19:18:18',
                'data_confirmacao' => '2026-02-24 19:22:00',
                'usuario_responsavel' => 1
            ],
            [
                'pedido_id' => 12,
                'tipo_pagamento' => 'debito',
                'valor' => 119.90,
                'status' => 'pendente',
                'codigo_transacao' => 'TX1012HIJ',
                'data_solicitacao' => '2026-02-24 19:18:18',
                'data_confirmacao' => null,
                'usuario_responsavel' => 1
            ],
            [
                'pedido_id' => 13,
                'tipo_pagamento' => 'credito',
                'valor' => 89.90,
                'status' => 'aprovado',
                'codigo_transacao' => 'TX1013KLM',
                'data_solicitacao' => '2026-02-24 19:18:18',
                'data_confirmacao' => '2026-02-24 19:20:40',
                'usuario_responsavel' => 1
            ],
            [
                'pedido_id' => 14,
                'tipo_pagamento' => 'pix',
                'valor' => 139.90,
                'status' => 'recusado',
                'codigo_transacao' => 'TX1014NOP',
                'data_solicitacao' => '2026-02-24 19:18:18',
                'data_confirmacao' => null,
                'usuario_responsavel' => 1
            ],
            [
                'pedido_id' => 15,
                'tipo_pagamento' => 'debito',
                'valor' => 49.90,
                'status' => 'aprovado',
                'codigo_transacao' => 'TX1015QRS',
                'data_solicitacao' => '2026-02-24 19:18:18',
                'data_confirmacao' => '2026-02-24 19:19:10',
                'usuario_responsavel' => 1
            ],
            [
                'pedido_id' => 16,
                'tipo_pagamento' => 'credito',
                'valor' => 229.90,
                'status' => 'em_analise',
                'codigo_transacao' => 'TX1016TUV',
                'data_solicitacao' => '2026-02-24 19:18:18',
                'data_confirmacao' => null,
                'usuario_responsavel' => 1
            ],
            [
                'pedido_id' => 17,
                'tipo_pagamento' => 'pix',
                'valor' => 109.90,
                'status' => 'aprovado',
                'codigo_transacao' => 'TX1017WXY',
                'data_solicitacao' => '2026-02-24 19:18:18',
                'data_confirmacao' => '2026-02-24 19:21:30',
                'usuario_responsavel' => 1
            ],
            [
                'pedido_id' => 18,
                'tipo_pagamento' => 'debito',
                'valor' => 69.90,
                'status' => 'pendente',
                'codigo_transacao' => 'TX1018ZAB',
                'data_solicitacao' => '2026-02-24 19:18:18',
                'data_confirmacao' => null,
                'usuario_responsavel' => 1
            ],
            [
                'pedido_id' => 19,
                'tipo_pagamento' => 'credito',
                'valor' => 199.90,
                'status' => 'aprovado',
                'codigo_transacao' => 'TX1019CDE',
                'data_solicitacao' => '2026-02-24 19:18:18',
                'data_confirmacao' => '2026-02-24 19:22:15',
                'usuario_responsavel' => 1
            ],
            [
                'pedido_id' => 20,
                'tipo_pagamento' => 'pix',
                'valor' => 159.90,
                'status' => 'aprovado',
                'codigo_transacao' => 'TX1020FGH',
                'data_solicitacao' => '2026-02-24 19:18:18',
                'data_confirmacao' => '2026-02-24 19:23:00',
                'usuario_responsavel' => 1
            ]
        ];

        foreach ($pagamentos as $pagamento) {
            pagamentos::forceCreate($pagamento);
        }
    }
}
