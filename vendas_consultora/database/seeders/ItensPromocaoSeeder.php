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
            [
                'produto_id' => 1,
                'promocao_id' => 1,
                'quantidade_min' => 123,
                'condicao_especial' => 'lafniuanfgiuawfg'
            ]
        ];

        foreach ($itensP as $itemP) {
            itens_promocoes::forceCreate($itemP);
        }
    }
}
