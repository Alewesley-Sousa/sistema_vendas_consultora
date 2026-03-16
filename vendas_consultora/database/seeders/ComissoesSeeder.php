<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\comissoes;

class ComissoesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comissoes = [
            ['consultora_id' => 1, 'saldo_liquido' => 250.75],
            ['consultora_id' => 2, 'saldo_liquido' => 320.50],
            ['consultora_id' => 3, 'saldo_liquido' => 150.00],
            ['consultora_id' => 4, 'saldo_liquido' => 410.20],
            ['consultora_id' => 5, 'saldo_liquido' => 275.90],
            ['consultora_id' => 6, 'saldo_liquido' => 360.00],
            ['consultora_id' => 7, 'saldo_liquido' => 198.45],
            ['consultora_id' => 8, 'saldo_liquido' => 420.80],
            ['consultora_id' => 9, 'saldo_liquido' => 305.60],
            ['consultora_id' => 10, 'saldo_liquido' => 289.99],
            ['consultora_id' => 11, 'saldo_liquido' => 512.30],
            ['consultora_id' => 12, 'saldo_liquido' => 333.33],
            ['consultora_id' => 13, 'saldo_liquido' => 278.40],
            ['consultora_id' => 14, 'saldo_liquido' => 450.00],
            ['consultora_id' => 15, 'saldo_liquido' => 390.10],
            ['consultora_id' => 16, 'saldo_liquido' => 210.25],
            ['consultora_id' => 17, 'saldo_liquido' => 365.75],
            ['consultora_id' => 18, 'saldo_liquido' => 480.90],
            ['consultora_id' => 19, 'saldo_liquido' => 299.99],
            ['consultora_id' => 20, 'saldo_liquido' => 530.50]
        ];

        foreach ($comissoes as $comissao) {
            Comissoes::forceCreate($comissao);
        }
    }
}
