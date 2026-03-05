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
                'consultora_id' => 1,
                'lider_id' => 1,
                'status_id' => 1,
                'data_referencia' => '2026-03-12',
                'valor_meta' => 1123.0,
            ]
        ];

        foreach ($metas as $meta) {
            metas::forceCreate($meta);
        }
    }
}
