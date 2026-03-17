<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\itens_promocao;

class ItensPromocaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $itensP = [
            // Promoção Carnaval 2026 (20% desconto)
            [
                'produto_id' => 5,
                'promocao_id' => 1,
                'quantidade_min' => 1,
                'condicao_especial' => 'Desconto aplicado automaticamente'
            ],
            [
                'produto_id' => 6,
                'promocao_id' => 1,
                'quantidade_min' => 2,
                'condicao_especial' => 'Na compra de 2 unidades'
            ],
            
            // Semana da Beleza (R$15 fixo em hidratantes)
            [
                'produto_id' => 16,
                'promocao_id' => 2,
                'quantidade_min' => 1,
                'condicao_especial' => 'Desconto fixo em hidratante anti-idade'
            ],
            [
                'produto_id' => 19,
                'promocao_id' => 2,
                'quantidade_min' => 1,
                'condicao_especial' => 'Desconto fixo em hidratante orgânico'
            ],
            
            // Brinde Dia das Mães
            [
                'produto_id' => 7,
                'promocao_id' => 3,
                'quantidade_min' => 1,
                'condicao_especial' => 'Na compra do perfume, ganha batom'
            ],
            [
                'produto_id' => 20,
                'promocao_id' => 3,
                'quantidade_min' => 1,
                'condicao_especial' => 'Kit presente com brinde especial'
            ],
            
            // Frete Grátis Outono
            [
                'produto_id' => 13,
                'promocao_id' => 4,
                'quantidade_min' => 2,
                'condicao_especial' => 'Frete grátis acima de R$100'
            ],
            [
                'produto_id' => 14,
                'promocao_id' => 4,
                'quantidade_min' => 3,
                'condicao_especial' => 'Frete grátis para 3 unidades'
            ],
            
            // Black Friday 2026 (50% desconto)
            [
                'produto_id' => 15,
                'promocao_id' => 5,
                'quantidade_min' => 1,
                'condicao_especial' => 'Desconto especial Black Friday'
            ],
            [
                'produto_id' => 18,
                'promocao_id' => 5,
                'quantidade_min' => 1,
                'condicao_especial' => 'Kit maquiagem com 50% off'
            ],
            
            // Natal Encantado (R$30 fixo em kits)
            [
                'produto_id' => 17,
                'promocao_id' => 6,
                'quantidade_min' => 1,
                'condicao_especial' => 'Sérum com desconto natalino'
            ],
            [
                'produto_id' => 20,
                'promocao_id' => 6,
                'quantidade_min' => 1,
                'condicao_especial' => 'Kit presente com desconto natalino'
            ]
        ];


        foreach ($itensP as $itemP) {
            itens_promocao::forceCreate($itemP);
        }
    }
}
