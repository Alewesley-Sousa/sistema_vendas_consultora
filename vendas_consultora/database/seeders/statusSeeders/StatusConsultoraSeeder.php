<?php
/**
 * Autor: Alewesley-Sousa (criador) && Nathan-Barros (desenvolvedor)
 * Data: 01/03/2026
 * Descrição: seeder responsavel por criar dados iniciais da tabela status_consultora
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusConsultoraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('status_consultoras')->insert([
            [
                'nome' => 'Ativa', 
                'descricao' => 'Consultora com vendas válidas no mês vigente',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nome' => 'Inativa', 
                'descricao' => 'Consultora que não atingiu o mínimo de vendas e foi desativada',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
