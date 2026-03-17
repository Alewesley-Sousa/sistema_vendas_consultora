<?php

/**
 * Autor: Alewesley-Sousa (criador) && Nathan-Barros (desenvolvedor)
 * Data: 01/03/2026
 * Descrição: seeder responsavel por criar dados iniciais da tabela status_devolucao
 */

namespace Database\Seeders\statusSeeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusDevolucaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('status_devolucao')->insert([
            [
                'nome' => 'Pendente', 
                'descricao' => 'Devolução aguardando análise',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nome' => 'Aprovada', 
                'descricao' => 'Devolução aprovada',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nome' => 'Rejeitada', 
                'descricao' => 'Devolução rejeitada',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
