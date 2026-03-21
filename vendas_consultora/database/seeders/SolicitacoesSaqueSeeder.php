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
                'consultora_id' => 2,
                'valor_solicitado' => 150.00,
                'status_id' => 3,
                'data_decisao' => null
            ],
            [
                'consultora_id' => 3,
                'valor_solicitado' => 200.00,
                'status_id' => 2,
                'data_decisao' => now()
            ],
            [
                'consultora_id' => 4,
                'valor_solicitado' => 120.00,
                'status_id' => 3,
                'data_decisao' => now()
            ],
            [
                'consultora_id' => 5,
                'valor_solicitado' => 300.00,
                'status_id' => 2,
                'data_decisao' => now()
            ],
            [
                'consultora_id' => 6,
                'valor_solicitado' => 180.00,
                'status_id' => 1,
                'data_decisao' => null
            ],
            [
                'consultora_id' => 7,
                'valor_solicitado' => 250.00,
                'status_id' => 2,
                'data_decisao' => now()
            ],
            [
                'consultora_id' => 8,
                'valor_solicitado' => 90.00,
                'status_id' => 3,
                'data_decisao' => now()
            ],
            [
                'consultora_id' => 9,
                'valor_solicitado' => 400.00,
                'status_id' => 2,
                'data_decisao' => now()
            ],
            [
                'consultora_id' => 10,
                'valor_solicitado' => 220.00,
                'status_id' => 1,
                'data_decisao' => null
            ],
            [
                'consultora_id' => 11,
                'valor_solicitado' => 350.00,
                'status_id' => 2,
                'data_decisao' => now()
            ],
            [
                'consultora_id' => 12,
                'valor_solicitado' => 175.00,
                'status_id' => 3,
                'data_decisao' => now()
            ],
            [
                'consultora_id' => 13,
                'valor_solicitado' => 280.00,
                'status_id' => 2,
                'data_decisao' => now()
            ],
            [
                'consultora_id' => 14,
                'valor_solicitado' => 95.00,
                'status_id' => 1,
                'data_decisao' => null
            ],
            [
                'consultora_id' => 15,
                'valor_solicitado' => 310.00,
                'status_id' => 2,
                'data_decisao' => now()
            ],
            [
                'consultora_id' => 16,
                'valor_solicitado' => 140.00,
                'status_id' => 3,
                'data_decisao' => now()
            ],
            [
                'consultora_id' => 17,
                'valor_solicitado' => 260.00,
                'status_id' => 2,
                'data_decisao' => now()
            ],
            [
                'consultora_id' => 18,
                'valor_solicitado' => 330.00,
                'status_id' => 1,
                'data_decisao' => null
            ],
            [
                'consultora_id' => 19,
                'valor_solicitado' => 210.00,
                'status_id' => 2,
                'data_decisao' => now()
            ],
            [
                'consultora_id' => 20,
                'valor_solicitado' => 500.00,
                'status_id' => 2,
                'data_decisao' => now()
            ]
        ];

        foreach ($solicitacoes as $solicitacao) {
            solicitacoes_saque::forceCreate($solicitacao);
        }
    }
}
