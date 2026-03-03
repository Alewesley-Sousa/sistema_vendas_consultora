<?php
/**
 * Autor: Alewesley-Sousa (criador) && Nathan-Barros (desenvolvedor)
 * Data: 01/03/2026
 * Descrição: seeder responsavel por criar dados iniciais da tabela status_resgate
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusResgateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verifica se já existem registros para não duplicar
        if (DB::table('status_resgate')->count() === 0) {
            DB::table('status_resgate')->insert([
                [
                    'nome' => 'Pendente', 
                    'descricao' => 'Resgate aguardando aprovação',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'nome' => 'Aprovada', 
                    'descricao' => 'Resgate aprovado',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'nome' => 'Cancelado', 
                    'descricao' => 'Resgate cancelado',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
        }
    }
}
