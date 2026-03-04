<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\itens_resgate;

class ItensResgateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $itensR = [
            [
                'quantidade' => 123,
                'item_catalogo_id' => 1,
                'resgate_id' => 1,
                'subtotal_pontos' => 234134
            ]
        ];

        foreach ($itensR as $itemR) {
            itens_resgate::forceCreate($itemR);
        }
    }
}
