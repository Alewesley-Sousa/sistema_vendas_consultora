<?php
/**
 * Autor: Alewesley-Sousa (criador) && Nathan-Barros (desenvolvedor)
 * Data: 01/03/2026
 * Descrição: seeder responsavel por criar dados iniciais da tabela status_item_catalogos
 */

namespace Database\Seeders\statusSeeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusItemCatalogoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('status_item_catalogos')->insert([
            [
                'nome' => 'Disponível', 
                'descricao' => 'Item disponível para compra',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nome' => 'Indisponível', 
                'descricao' => 'Item indisponível para compra',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
