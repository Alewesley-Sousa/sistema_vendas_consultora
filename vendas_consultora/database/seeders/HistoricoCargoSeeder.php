<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\historico_cargo;
class HistoricoCargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $historicos = [
            [
                'consultora_id' => 2,
                'qualificacao_profissional_id' => 1,
                'cargo_anterior' => 'consultora',
                'cargo_novo' => 'lider',
                'data_mudanca' => '2026-01-31 10:00:00'
            ],
            [
                'consultora_id' => 3,
                'qualificacao_profissional_id' => 2,
                'cargo_anterior' => 'consultora',
                'cargo_novo' => 'consultora',
                'data_mudanca' => '2026-01-31 11:15:00'
            ],
            [
                'consultora_id' => 4,
                'qualificacao_profissional_id' => 3,
                'cargo_anterior' => 'consultora',
                'cargo_novo' => 'lider',
                'data_mudanca' => '2026-02-28 09:30:00'
            ],
            [
                'consultora_id' => 5,
                'qualificacao_profissional_id' => 4,
                'cargo_anterior' => 'lider',
                'cargo_novo' => 'consultora',
                'data_mudanca' => '2026-02-28 14:45:00'
            ],
            [
                'consultora_id' => 6,
                'qualificacao_profissional_id' => 5,
                'cargo_anterior' => 'consultora',
                'cargo_novo' => 'consultora',
                'data_mudanca' => '2026-03-31 16:20:00'
            ],
            [
                'consultora_id' => 7,
                'qualificacao_profissional_id' => 6,
                'cargo_anterior' => 'lider',
                'cargo_novo' => 'lider',
                'data_mudanca' => '2026-03-31 17:00:00'
            ],
            [
                'consultora_id' => 8,
                'qualificacao_profissional_id' => 7,
                'cargo_anterior' => 'consultora',
                'cargo_novo' => 'lider',
                'data_mudanca' => '2026-04-30 12:10:00'
            ],
            [
                'consultora_id' => 9,
                'qualificacao_profissional_id' => 8,
                'cargo_anterior' => 'lider',
                'cargo_novo' => 'consultora',
                'data_mudanca' => '2026-04-30 13:25:00'
            ],
            [
                'consultora_id' => 10,
                'qualificacao_profissional_id' => 9,
                'cargo_anterior' => 'consultora',
                'cargo_novo' => 'lider',
                'data_mudanca' => '2026-05-31 09:50:00'
            ],
            [
                'consultora_id' => 11,
                'qualificacao_profissional_id' => 10,
                'cargo_anterior' => 'consultora',
                'cargo_novo' => 'consultora',
                'data_mudanca' => '2026-05-31 15:40:00'
            ],
            [
                'consultora_id' => 12,
                'qualificacao_profissional_id' => 11,
                'cargo_anterior' => 'lider',
                'cargo_novo' => 'consultora',
                'data_mudanca' => '2026-06-30 10:20:00'
            ],
            [
                'consultora_id' => 13,
                'qualificacao_profissional_id' => 12,
                'cargo_anterior' => 'consultora',
                'cargo_novo' => 'lider',
                'data_mudanca' => '2026-06-30 11:45:00'
            ]
        ];

        foreach ($historicos as $historico) {
            historico_cargo::forceCreate($historico);
        }
    }
}
