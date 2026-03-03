<?php
/**
 * Autor: Alewesley-Sousa (criador) && Nathan-Barros (desenvolvedor)
 * Data: 01/03/2026
 * Descrição: seeder responsavel por criar dados iniciais da tabela status_produto
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusProdutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verifica se já existem registros para não duplicar
        if (DB::table('status_produto')->count() === 0) {
            DB::table('status_produto')->insert([
                [
                    'nome' => 'Ativo', 
                    'descricao' => 'Produto ativo e disponível para venda',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'nome' => 'Inativo', 
                    'descricao' => 'Produto inativo',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'nome' => 'Descontinuado', 
                    'descricao' => 'Produto descontinuado',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
        }
    }
}
