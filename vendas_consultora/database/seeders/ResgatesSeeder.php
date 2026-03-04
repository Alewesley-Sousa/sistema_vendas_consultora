<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\resgates;

class ResgatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resgates = [
            [
                'total_pontos' => 12343,
                'consultora_id' => 1,
                'catalogo_id' => 1,
                'status_id' => 1,
                'ususario_responsavel' => 1,
            ]
        ];

        foreach ($resgates as $resgate) {
            resgates::forceCreate($resgate);
        }
    }
}
