<?php

/**
 * Autor: Alewesley-Sousa (criador) && Nathan-Barros (desenvolvedor)
 * Data: 01/03/2026
 * Descrição: seeder responsavel por criar dados iniciais da tabela status_solicitacao_saque
 */

namespace Database\Seeders\statusSeeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSolicitacaoSaqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('status_solicitacao_saque')->insert([
            [
                'nome' => 'Pendente', 
                'descricao' => 'Solicitação de saque aguardando aprovação',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nome' => 'Aprovada', 
                'descricao' => 'Solicitação de saque aprovada',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nome' => 'Rejeitada', 
                'descricao' => 'Solicitação de saque rejeitada',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
