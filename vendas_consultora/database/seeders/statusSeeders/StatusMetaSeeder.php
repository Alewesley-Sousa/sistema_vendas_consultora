<?php

/**
 * Autor: Alewesley-Sousa (criador) && Nathan-Barros (desenvolvedor)
 * Data: 01/03/2026
 * Descrição: seeder responsavel por criar dados iniciais da tabela status_metas
 */

namespace Database\Seeders\statusSeeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusMetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('status_meta')->insert([
            [
                'nome' => 'Atingida', 
                'descricao' => 'Meta foi atingida',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nome' => 'Não atingida', 
                'descricao' => 'Meta não foi atingida',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nome' => 'Ativa', 
                'descricao' => 'Meta está ativa',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
