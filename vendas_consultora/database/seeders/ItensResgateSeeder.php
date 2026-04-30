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
            // Batom Matte Vermelho (400 pontos cada)
            [
                'quantidade' => 1,
                'item_catalogo_id' => 5,
                'resgate_id' => 1,
                'subtotal_pontos' => 400
            ],
            [
                'quantidade' => 2,
                'item_catalogo_id' => 5,
                'resgate_id' => 2,
                'subtotal_pontos' => 800
            ],
            [
                'quantidade' => 1,
                'item_catalogo_id' => 5,
                'resgate_id' => 3,
                'subtotal_pontos' => 400
            ],
            [
                'quantidade' => 3,
                'item_catalogo_id' => 5,
                'resgate_id' => 4,
                'subtotal_pontos' => 1200
            ],
            
            // Base Líquida (600 pontos cada)
            [
                'quantidade' => 1,
                'item_catalogo_id' => 6,
                'resgate_id' => 5,
                'subtotal_pontos' => 600
            ],
            [
                'quantidade' => 2,
                'item_catalogo_id' => 6,
                'resgate_id' => 6,
                'subtotal_pontos' => 1200
            ],
            [
                'quantidade' => 1,
                'item_catalogo_id' => 6,
                'resgate_id' => 7,
                'subtotal_pontos' => 600
            ],
            [
                'quantidade' => 3,
                'item_catalogo_id' => 6,
                'resgate_id' => 8,
                'subtotal_pontos' => 1800
            ],
            
            // Perfume Floral (1300 pontos cada)
            [
                'quantidade' => 1,
                'item_catalogo_id' => 7,
                'resgate_id' => 9,
                'subtotal_pontos' => 1300
            ],
            [
                'quantidade' => 2,
                'item_catalogo_id' => 7,
                'resgate_id' => 10,
                'subtotal_pontos' => 2600
            ],
            [
                'quantidade' => 1,
                'item_catalogo_id' => 7,
                'resgate_id' => 11,
                'subtotal_pontos' => 1300
            ],
            [
                'quantidade' => 3,
                'item_catalogo_id' => 7,
                'resgate_id' => 12,
                'subtotal_pontos' => 3900
            ],
            
            // Perfume Amadeirado (1400 pontos cada)
            [
                'quantidade' => 1,
                'item_catalogo_id' => 8,
                'resgate_id' => 13,
                'subtotal_pontos' => 1400
            ],
            [
                'quantidade' => 2,
                'item_catalogo_id' => 8,
                'resgate_id' => 14,
                'subtotal_pontos' => 2800
            ],
            [
                'quantidade' => 1,
                'item_catalogo_id' => 8,
                'resgate_id' => 15,
                'subtotal_pontos' => 1400
            ],
            [
                'quantidade' => 3,
                'item_catalogo_id' => 8,
                'resgate_id' => 16,
                'subtotal_pontos' => 4200
            ],
            
            // Mistura de itens em resgates posteriores
            [
                'quantidade' => 1,
                'item_catalogo_id' => 5,
                'resgate_id' => 17,
                'subtotal_pontos' => 400
            ],
            [
                'quantidade' => 1,
                'item_catalogo_id' => 6,
                'resgate_id' => 18,
                'subtotal_pontos' => 600
            ],
            [
                'quantidade' => 1,
                'item_catalogo_id' => 7,
                'resgate_id' => 19,
                'subtotal_pontos' => 1300
            ],
            [
                'quantidade' => 1,
                'item_catalogo_id' => 8,
                'resgate_id' => 20,
                'subtotal_pontos' => 1400
            ]
        ];

                foreach ($itensR as $itemR) {
            // 1. Verifica se o Resgate (pai) existe no banco
            $resgateExiste = \App\Models\resgates::where('id', $itemR['resgate_id'])->exists();
            
            // 2. Verifica se o Item do Catálogo existe
            // (Assumindo que o model seja ItemCatalogo ou similar)
            $itemExiste = \App\Models\itens_catalogo::where('id', $itemR['item_catalogo_id'])->exists();

            if ($resgateExiste && $itemExiste) {
                itens_resgate::forceCreate($itemR);
            } else {
                // Se o resgate não foi criado (ex: resgate do ID 7), ele apenas pula este item
                continue;
            }
        }

    }
}
