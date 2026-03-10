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
                'consultora_id' => 1,
                'qualificacao_profissional_id' => 1,
                'cargo_anterior' => 'consultora',
                'cargo_novo' => 'lider',
                'data_mudanca' => '2026-04-22'
            ]
        ];

        foreach ($historicos as $historico) {
            historico_cargo::forceCreate($historico);
        }
    }
}
