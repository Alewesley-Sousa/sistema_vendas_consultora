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
                'nome' => 'Promoção Carnaval 2026',
                'desconto' => 20.00,
                'descricao' => 'Desconto de 20% em toda a linha de maquiagem',
                'tipo_promocao_id' => 1,
                'data_inicio' => '2026-02-01',
                'data_fim' => '2026-02-15',
                'status_id' => 1
            ],
            [
                'nome' => 'Semana da Beleza',
                'desconto' => 15.00,
                'descricao' => 'Desconto fixo de R$15 em hidratantes faciais',
                'tipo_promocao_id' => 2,
                'data_inicio' => '2026-03-01',
                'data_fim' => '2026-03-10',
                'status_id' => 1
            ],
            [
                'nome' => 'Brinde Dia das Mães',
                'desconto' => 0.00,
                'descricao' => 'Na compra de perfumes, leve um batom grátis',
                'tipo_promocao_id' => 3,
                'data_inicio' => '2026-04-20',
                'data_fim' => '2026-05-15',
                'status_id' => 2
            ],
            [
                'nome' => 'Frete Grátis Outono',
                'desconto' => 0.00,
                'descricao' => 'Frete grátis em compras acima de R$100',
                'tipo_promocao_id' => 4,
                'data_inicio' => '2026-03-01',
                'data_fim' => '2026-03-31',
                'status_id' => 1
            ],
            [
                'nome' => 'Black Friday 2026',
                'desconto' => 50.00,
                'descricao' => 'Desconto de 50% em produtos selecionados',
                'tipo_promocao_id' => 1,
                'data_inicio' => '2026-11-01',
                'data_fim' => '2026-11-30',
                'status_id' => 3
            ],
            [
                'nome' => 'Natal Encantado',
                'desconto' => 30.00,
                'descricao' => 'Desconto fixo de R$30 em kits de presente',
                'tipo_promocao_id' => 2,
                'data_inicio' => '2026-12-01',
                'data_fim' => '2026-12-25',
                'status_id' => 1
            ]
        ];

        foreach ($promocoes as $promocao) {
            promocoes::forceCreate($promocao);
        }
    }
}
