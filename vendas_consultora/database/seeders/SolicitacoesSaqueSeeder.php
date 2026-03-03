<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\solicitacoes_saque;

class SolicitacoesSaqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $solicitacoes = [
            [
                'consultora_id' => 1,
                'valor_solicitado' => 10.0,
                'status_id' => 1,
                'data_decisao' => '2026-12-12 12:60:60'
            ]
        ];

        foreach ($solicitacoes as $solicitacao) {
            solicitacoes_saque::forceCreate($solicitacao);
        }
    }
}
