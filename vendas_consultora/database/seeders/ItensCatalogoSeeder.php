<?php

namespace Database\Seeders;

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
            [
                'preco' => 1223.00,
                'pontos_necesarios' => 12123434,
                'status_id' => 1,
                'estoque_disponivel' => 1432,
                'catalogo_id' => 1,
                'produto_id' => 1
            ]
        ];
    }
}
