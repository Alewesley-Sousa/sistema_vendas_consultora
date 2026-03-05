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
                'consultora_id' => 1,
                'data_validacao' => '2025-02-21',
                'data_referencia' => '2025-02-15',
                'total_vendas' => 12345.21,
                'total_recrutas_ativos' => 3,
                'status' => 'promovido'
            ]
        ];

        foreach ($qualificacoes as $qualificacao) {
            qualificacao_profissional::forceCreate($qualificacao);
        }
    }
}
