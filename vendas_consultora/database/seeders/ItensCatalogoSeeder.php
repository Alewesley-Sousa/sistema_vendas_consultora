<?php

namespace Database\Seeders;

use App\Models\itens_catalogo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItensCatalogoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $itensCatalogo = [
            // Catálogo Verão 2026 (catalogo_id = 1) - vendas
            [
                'preco' => 39.90,
                'pontos_necessarios' => null,
                'status_id' => 1,
                'estoque_disponivel' => 100,
                'catalogo_id' => 1,
                'produto_id' => 1
            ],
            [
                'preco' => 59.90,
                'pontos_necessarios' => null,
                'status_id' => 1,
                'estoque_disponivel' => 80,
                'catalogo_id' => 1,
                'produto_id' => 2
            ],
            [
                'preco' => 89.90,
                'pontos_necessarios' => null,
                'status_id' => 2,
                'estoque_disponivel' => 0,
                'catalogo_id' => 1,
                'produto_id' => 3
            ],
            [
                'preco' => 79.90,
                'pontos_necessarios' => null,
                'status_id' => 1,
                'estoque_disponivel' => 50,
                'catalogo_id' => 1,
                'produto_id' => 4
            ],

            // Catálogo Pontos Bronze (catalogo_id = 2) - recompensas
            [
                'preco' => 39.90,
                'pontos_necessarios' => 400,
                'status_id' => 1,
                'estoque_disponivel' => 100,
                'catalogo_id' => 2,
                'produto_id' => 1
            ],
            [
                'preco' => 59.90,
                'pontos_necessarios' => 600,
                'status_id' => 1,
                'estoque_disponivel' => 80,
                'catalogo_id' => 2,
                'produto_id' => 2
            ],
            [
                'preco' => 129.90,
                'pontos_necessarios' => 1300,
                'status_id' => 1,
                'estoque_disponivel' => 40,
                'catalogo_id' => 2,
                'produto_id' => 7
            ],
            [
                'preco' => 139.90,
                'pontos_necessarios' => 1400,
                'status_id' => 2,
                'estoque_disponivel' => 0,
                'catalogo_id' => 2,
                'produto_id' => 8
            ],

            // Catálogo Especial Dia das Mães (catalogo_id = 3) - vendas
            [
                'preco' => 34.90,
                'pontos_necessarios' => null,
                'status_id' => 1,
                'estoque_disponivel' => 120,
                'catalogo_id' => 3,
                'produto_id' => 9
            ],
            [
                'preco' => 36.90,
                'pontos_necessarios' => null,
                'status_id' => 1,
                'estoque_disponivel' => 110,
                'catalogo_id' => 3,
                'produto_id' => 10
            ],
            [
                'preco' => 49.90,
                'pontos_necessarios' => null,
                'status_id' => 2,
                'estoque_disponivel' => 0,
                'catalogo_id' => 3,
                'produto_id' => 11
            ],
            [
                'preco' => 12.90,
                'pontos_necessarios' => null,
                'status_id' => 1,
                'estoque_disponivel' => 200,
                'catalogo_id' => 3,
                'produto_id' => 12
            ]
        ];

        foreach ($itensCatalogo as $item) {
            itens_catalogo::forceCreate($item);
        }
    }
}
