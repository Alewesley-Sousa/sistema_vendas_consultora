<?php
/**
 * Autor: Alewesley-Sousa (criador) && Nathan-Barros (desenvolvedor)
 * Data: 01/03/2026
 * Descrição: seeder responsavel por criar dados iniciais da tabela status_promocao
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusPromocaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verifica se já existem registros para não duplicar
        if (DB::table('status_promocao')->count() === 0) {
            DB::table('status_promocao')->insert([
                [
                    'nome' => 'Ativa', 
                    'descricao' => 'Promoção ativa',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'nome' => 'Inativa', 
                    'descricao' => 'Promoção inativa',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'nome' => 'Expirada', 
                    'descricao' => 'Promoção expirada',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
        }
    }
}
