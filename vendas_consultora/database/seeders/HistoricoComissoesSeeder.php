<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\historico_comissoes;

class HistoricoComissoesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $historicosComissoes = [
            // Vendas diretas (tipo_movimentacao_id = 1 - Crédito)
            [
                'consultora_id' => 2,
                'pedido_id' => 1,
                'tipo_comissao_id' => 1,
                'valor' => 59.97,
                'tipo_movimentacao_id' => 1,
                'data_movimentacao' => '2026-04-02 14:23:11',
                'usuario_responsavel' => 1
            ],
            [
                'consultora_id' => 3,
                'pedido_id' => 2,
                'tipo_comissao_id' => 1,
                'valor' => 26.97,
                'tipo_movimentacao_id' => 1,
                'data_movimentacao' => '2026-04-04 09:41:52',
                'usuario_responsavel' => 1
            ],
            [
                'consultora_id' => 4,
                'pedido_id' => 3,
                'tipo_comissao_id' => 1,
                'valor' => 17.97,
                'tipo_movimentacao_id' => 1,
                'data_movimentacao' => '2026-04-06 18:12:07',
                'usuario_responsavel' => 1
            ],
            [
                'consultora_id' => 5,
                'pedido_id' => 4,
                'tipo_comissao_id' => 1,
                'valor' => 44.97,
                'tipo_movimentacao_id' => 1,
                'data_movimentacao' => '2026-04-08 11:05:33',
                'usuario_responsavel' => 1
            ],
            [
                'consultora_id' => 6,
                'pedido_id' => 5,
                'tipo_comissao_id' => 1,
                'valor' => 23.97,
                'tipo_movimentacao_id' => 1,
                'data_movimentacao' => '2026-04-10 16:48:21',
                'usuario_responsavel' => 1
            ],
            [
                'consultora_id' => 7,
                'pedido_id' => 6,
                'tipo_comissao_id' => 1,
                'valor' => 38.97,
                'tipo_movimentacao_id' => 1,
                'data_movimentacao' => '2026-04-12 08:19:44',
                'usuario_responsavel' => 1
            ],
            [
                'consultora_id' => 8,
                'pedido_id' => 7,
                'tipo_comissao_id' => 1,
                'valor' => 11.97,
                'tipo_movimentacao_id' => 1,
                'data_movimentacao' => '2026-04-14 13:27:59',
                'usuario_responsavel' => 1
            ],
            [
                'consultora_id' => 9,
                'pedido_id' => 8,
                'tipo_comissao_id' => 1,
                'valor' => 74.97,
                'tipo_movimentacao_id' => 1,
                'data_movimentacao' => '2026-04-16 19:03:15',
                'usuario_responsavel' => 1
            ],
            [
                'consultora_id' => 10,
                'pedido_id' => 9,
                'tipo_comissao_id' => 1,
                'valor' => 29.97,
                'tipo_movimentacao_id' => 1,
                'data_movimentacao' => '2026-04-18 10:55:02',
                'usuario_responsavel' => 1
            ],
            [
                'consultora_id' => 11,
                'pedido_id' => 10,
                'tipo_comissao_id' => 1,
                'valor' => 17.97,
                'tipo_movimentacao_id' => 1,
                'data_movimentacao' => '2026-04-20 15:36:28',
                'usuario_responsavel' => 1
            ],

            // Estornos por devolução (tipo_movimentacao_id = 2 - Débito)
            [
                'consultora_id' => 2,
                'pedido_id' => 1,
                'tipo_comissao_id' => 1,
                'valor' => -39.90,
                'tipo_movimentacao_id' => 2,
                'data_movimentacao' => '2026-04-22 09:14:10',
                'usuario_responsavel' => 1
            ],
            [
                'consultora_id' => 3,
                'pedido_id' => 2,
                'tipo_comissao_id' => 1,
                'valor' => -89.90,
                'tipo_movimentacao_id' => 2,
                'data_movimentacao' => '2026-04-23 11:40:55',
                'usuario_responsavel' => 1
            ],
            [
                'consultora_id' => 4,
                'pedido_id' => 3,
                'tipo_comissao_id' => 1,
                'valor' => -59.90,
                'tipo_movimentacao_id' => 2,
                'data_movimentacao' => '2026-04-24 17:22:19',
                'usuario_responsavel' => 1
            ],
            [
                'consultora_id' => 5,
                'pedido_id' => 4,
                'tipo_comissao_id' => 1,
                'valor' => -149.90,
                'tipo_movimentacao_id' => 2,
                'data_movimentacao' => '2026-04-25 14:05:31',
                'usuario_responsavel' => 1
            ],
            [
                'consultora_id' => 6,
                'pedido_id' => 5,
                'tipo_comissao_id' => 1,
                'valor' => -79.90,
                'tipo_movimentacao_id' => 2,
                'data_movimentacao' => '2026-04-26 08:58:47',
                'usuario_responsavel' => 1
            ],
            [
                'consultora_id' => 7,
                'pedido_id' => 6,
                'tipo_comissao_id' => 1,
                'valor' => -129.90,
                'tipo_movimentacao_id' => 2,
                'data_movimentacao' => '2026-04-27 12:11:09',
                'usuario_responsavel' => 1
            ],
            [
                'consultora_id' => 8,
                'pedido_id' => 7,
                'tipo_comissao_id' => 1,
                'valor' => -39.90,
                'tipo_movimentacao_id' => 2,
                'data_movimentacao' => '2026-04-28 16:33:54',
                'usuario_responsavel' => 1
            ],
            [
                'consultora_id' => 10,
                'pedido_id' => 9,
                'tipo_comissao_id' => 1,
                'valor' => -99.90,
                'tipo_movimentacao_id' => 2,
                'data_movimentacao' => '2026-04-29 10:07:26',
                'usuario_responsavel' => 1
            ],

            // Saques (tipo_movimentacao_id = 3 - Saque, sem pedido vinculado)
            [
                'consultora_id' => 2,
                'pedido_id' => null,
                'tipo_comissao_id' => 3,
                'valor' => 100.00,
                'tipo_movimentacao_id' => 3,
                'data_movimentacao' => '2026-05-02 09:15:00',
                'usuario_responsavel' => 1
            ],
            [
                'consultora_id' => 3,
                'pedido_id' => null,
                'tipo_comissao_id' => 3,
                'valor' => 150.00,
                'tipo_movimentacao_id' => 3,
                'data_movimentacao' => '2026-05-04 11:45:00',
                'usuario_responsavel' => 1
            ]
        ];
        
        foreach ($historicosComissoes as $HC) {
            historico_comissoes::forceCreate($HC);
        }
    }
}
