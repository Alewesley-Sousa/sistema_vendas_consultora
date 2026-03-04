<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\promocoes;

class PromocoesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $promocoes = [
            [
                'nome' => 'exemplo',
                'desconto' => 0.5,
                'descricao' => 'exemplo de texto',
                'tipo_promocao_id' => 1,
                'data_inicio' => '2026-05-12',
                'data_fim' => '2026-08-29',
                'status_id' => 1
           ]
        ];
    }
}
