<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\metas;

class MetasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $metas = [
            [
                'consultora_id' => 2,
                'lider_id' => 17,
                'valor_meta' => 1500.00,
                'data_referencia' => '2026-01-31',
                'status_id' => 2
            ],
            [
                'consultora_id' => 3,
                'lider_id' => 17,
                'valor_meta' => 2000.00,
                'data_referencia' => '2026-01-31',
                'status_id' => 2
            ],
            [
                'consultora_id' => 4,
                'lider_id' => 18,
                'valor_meta' => 1800.00,
                'data_referencia' => '2026-02-28',
                'status_id' => 3
            ],
            [
                'consultora_id' => 5,
                'lider_id' => 18,
                'valor_meta' => 2200.00,
                'data_referencia' => '2026-02-28',
                'status_id' => 1
            ],
            [
                'consultora_id' => 6,
                'lider_id' => 19,
                'valor_meta' => 2500.00,
                'data_referencia' => '2026-03-31',
                'status_id' => 2
            ],
            [
                'consultora_id' => 7,
                'lider_id' => 19,
                'valor_meta' => 1200.00,
                'data_referencia' => '2026-03-31',
                'status_id' => 1
            ],
            [
                'consultora_id' => 8,
                'lider_id' => 20,
                'valor_meta' => 3000.00,
                'data_referencia' => '2026-04-30',
                'status_id' => 3
            ],
            [
                'consultora_id' => 9,
                'lider_id' => 20,
                'valor_meta' => 1700.00,
                'data_referencia' => '2026-04-30',
                'status_id' => 2
            ],
            [
                'consultora_id' => 10,
                'lider_id' => 17,
                'valor_meta' => 900.00,
                'data_referencia' => '2026-05-31',
                'status_id' => 1
            ],
            [
                'consultora_id' => 11,
                'lider_id' => 18,
                'valor_meta' => 1300.00,
                'data_referencia' => '2026-05-31',
                'status_id' => 3
            ],
            [
                'consultora_id' => 12,
                'lider_id' => 19,
                'valor_meta' => 2100.00,
                'data_referencia' => '2026-06-30',
                'status_id' => 2
            ],
            [
                'consultora_id' => 13,
                'lider_id' => 20,
                'valor_meta' => 1600.00,
                'data_referencia' => '2026-06-30',
                'status_id' => 1
            ],
            [
                'consultora_id' => 14,
                'lider_id' => 17,
                'valor_meta' => 2800.00,
                'data_referencia' => '2026-07-31',
                'status_id' => 3
            ],
            [
                'consultora_id' => 15,
                'lider_id' => 18,
                'valor_meta' => 1900.00,
                'data_referencia' => '2026-07-31',
                'status_id' => 2
            ],
            [
                'consultora_id' => 16,
                'lider_id' => 19,
                'valor_meta' => 2400.00,
                'data_referencia' => '2026-08-31',
                'status_id' => 1
            ]
        ];

        foreach ($metas as $meta) {
            metas::forceCreate($meta);
        }
    }
}
