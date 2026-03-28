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
        // ItensPromocaoSeeder.php
        $itensP = [
            // Promoção Carnaval 2026 (ID 1) -> Maquiagem (Desconto 20%)
            ['produto_id' => 5, 'promocao_id' => 1, 'quantidade_min' => 1, 'tipo_promocao_id' => 1, 'valor_desconto' => 20.00, 'status_id' => 1],
            ['produto_id' => 6, 'promocao_id' => 1, 'quantidade_min' => 2, 'tipo_promocao_id' => 1, 'valor_desconto' => 20.00, 'status_id' => 1],

            // Semana da Beleza (ID 2) -> Hidratantes (Fixo R$ 15)
            ['produto_id' => 16, 'promocao_id' => 2, 'quantidade_min' => 1, 'tipo_promocao_id' => 2, 'valor_desconto' => 15.00, 'status_id' => 1],
            ['produto_id' => 19, 'promocao_id' => 2, 'quantidade_min' => 1, 'tipo_promocao_id' => 2, 'valor_desconto' => 15.00, 'status_id' => 1],

            // Brinde Dia das Mães (ID 3)
            ['produto_id' => 7, 'promocao_id' => 2, 'quantidade_min' => 1, 'tipo_promocao_id' => 2, 'valor_desconto' => 10.00, 'status_id' => 1],

            // Frete Grátis Outono (ID 4)
            ['produto_id' => 13, 'promocao_id' => 4, 'quantidade_min' => 2, 'tipo_promocao_id' => 4, 'valor_desconto' => 0.00, 'status_id' => 1],

            // Black Friday (ID 5) -> Desconto 50%
            ['produto_id' => 15, 'promocao_id' => 5, 'quantidade_min' => 1, 'tipo_promocao_id' => 1, 'valor_desconto' => 50.00, 'status_id' => 1],

            // Natal Encantado (ID 6) -> Fixo R$ 30
            ['produto_id' => 17, 'promocao_id' => 6, 'quantidade_min' => 1, 'tipo_promocao_id' => 2, 'valor_desconto' => 30.00, 'status_id' => 1]
        ];

        foreach ($itensP as $item) {
            \App\Models\itens_promocao::create($item);
        }


        foreach ($itensP as $itemP) {
            itens_promocao::forceCreate($itemP);
        }
    }
}
