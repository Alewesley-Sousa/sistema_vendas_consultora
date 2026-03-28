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
        // PromocaoSeeder.php
        $promocoes = [
            [
                'nome' => 'Promoção Carnaval 2026',
                'descricao' => 'Desconto em maquiagem',
                'data_inicio' => '2026-02-01 00:00:00',
                'data_fim' => '2026-02-15 23:59:59',
                'status_id' => 1
            ],
            [
                'nome' => 'Semana da Beleza',
                'descricao' => 'Hidratantes faciais',
                'data_inicio' => '2026-03-01 00:00:00',
                'data_fim' => '2026-03-10 23:59:59',
                'status_id' => 1
            ],
            [
                'nome' => 'Brinde Dia das Mães',
                'descricao' => 'Campanha de Perfumes',
                'data_inicio' => '2026-04-20 00:00:00',
                'data_fim' => '2026-05-15 23:59:59',
                'status_id' => 2
            ],
            [
                'nome' => 'Frete Grátis Outono',
                'descricao' => 'Campanha de Frete',
                'data_inicio' => '2026-03-01 00:00:00',
                'data_fim' => '2026-03-31 23:59:59',
                'status_id' => 1
            ],
            [
                'nome' => 'Black Friday 2026',
                'descricao' => 'Ofertas Black Friday',
                'data_inicio' => '2026-11-01 00:00:00',
                'data_fim' => '2026-11-30 23:59:59',
                'status_id' => 3
            ],
            [
                'nome' => 'Natal Encantado',
                'descricao' => 'Kits de presente',
                'data_inicio' => '2026-12-01 00:00:00',
                'data_fim' => '2026-12-25 23:59:59',
                'status_id' => 1
            ]
        ];

        foreach ($promocoes as $promo) {
            \App\Models\promocoes::create($promo);
        }

        foreach ($promocoes as $promocao) {
            promocoes::forceCreate($promocao);
        }
    }
}
