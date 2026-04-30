<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\qualificacao_profissional;

class QualificacaoProfissionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $qualificacoes = [
            [
                'consultora_id' => 2,
                'data_validacao' => '2026-01-31',
                'data_referencia' => '2026-01-31',
                'total_vendas' => 2500.00,
                'total_recrutas_ativos' => 3,
                'status' => 'promovido'
            ],
            [
                'consultora_id' => 3,
                'data_validacao' => '2026-01-31',
                'data_referencia' => '2026-01-31',
                'total_vendas' => 1800.00,
                'total_recrutas_ativos' => 2,
                'status' => 'mantido'
            ],
            [
                'consultora_id' => 4,
                'data_validacao' => '2026-02-28',
                'data_referencia' => '2026-02-28',
                'total_vendas' => 3200.00,
                'total_recrutas_ativos' => 4,
                'status' => 'promovido'
            ],
            [
                'consultora_id' => 5,
                'data_validacao' => '2026-02-28',
                'data_referencia' => '2026-02-28',
                'total_vendas' => 900.00,
                'total_recrutas_ativos' => 1,
                'status' => 'rebaixado'
            ],
            [
                'consultora_id' => 6,
                'data_validacao' => '2026-03-31',
                'data_referencia' => '2026-03-31',
                'total_vendas' => 1500.00,
                'total_recrutas_ativos' => 0,
                'status' => 'pendente'
            ],
            [
                'consultora_id' => 7,
                'data_validacao' => '2026-03-31',
                'data_referencia' => '2026-03-31',
                'total_vendas' => 2800.00,
                'total_recrutas_ativos' => 5,
                'status' => 'mantido'
            ],
            [
                'consultora_id' => 8,
                'data_validacao' => '2026-04-30',
                'data_referencia' => '2026-04-30',
                'total_vendas' => 4100.00,
                'total_recrutas_ativos' => 6,
                'status' => 'promovido'
            ],
            [
                'consultora_id' => 9,
                'data_validacao' => '2026-04-30',
                'data_referencia' => '2026-04-30',
                'total_vendas' => 1200.00,
                'total_recrutas_ativos' => 2,
                'status' => 'rebaixado'
            ],
            [
                'consultora_id' => 10,
                'data_validacao' => '2026-05-31',
                'data_referencia' => '2026-05-31',
                'total_vendas' => 2300.00,
                'total_recrutas_ativos' => 3,
                'status' => 'mantido'
            ],
            [
                'consultora_id' => 11,
                'data_validacao' => '2026-05-31',
                'data_referencia' => '2026-05-31',
                'total_vendas' => 800.00,
                'total_recrutas_ativos' => 1,
                'status' => 'pendente'
            ],
            [
                'consultora_id' => 12,
                'data_validacao' => '2026-06-30',
                'data_referencia' => '2026-06-30',
                'total_vendas' => 3500.00,
                'total_recrutas_ativos' => 7,
                'status' => 'promovido'
            ],
            [
                'consultora_id' => 13,
                'data_validacao' => '2026-06-30',
                'data_referencia' => '2026-06-30',
                'total_vendas' => 1700.00,
                'total_recrutas_ativos' => 2,
                'status' => 'mantido'
            ],
            [
                'consultora_id' => 14,
                'data_validacao' => '2026-07-31',
                'data_referencia' => '2026-07-31',
                'total_vendas' => 2600.00,
                'total_recrutas_ativos' => 4,
                'status' => 'promovido'
            ],
            [
                'consultora_id' => 15,
                'data_validacao' => '2026-07-31',
                'data_referencia' => '2026-07-31',
                'total_vendas' => 950.00,
                'total_recrutas_ativos' => 0,
                'status' => 'rebaixado'
            ],
            [
                'consultora_id' => 16,
                'data_validacao' => '2026-08-31',
                'data_referencia' => '2026-08-31',
                'total_vendas' => 4200.00,
                'total_recrutas_ativos' => 8,
                'status' => 'promovido'
            ]
        ];

                foreach ($qualificacoes as $qualificacao) {
            // Verifica se a consultora existe antes de tentar inserir a qualificação
            if (\App\Models\usuarios::where('id', $qualificacao['consultora_id'])->exists()) {
                qualificacao_profissional::forceCreate($qualificacao);
            }
        }

    }
}
