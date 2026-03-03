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
        ['consultora_id' => 1, 'saldo_liquido' => 250.75]
        ];

        foreach ($comissoes as $comissao) {
            Comissoes::forceCreate($comissao);
        }
    }
}
