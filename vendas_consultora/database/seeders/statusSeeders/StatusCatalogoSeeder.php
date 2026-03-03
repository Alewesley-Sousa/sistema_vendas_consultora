<?php
/**
 * Autor: Alewesley-Sousa (criador) && Nathan-Barros (desenvolvedor)
 * Data: 01/03/2026
 * Descrição: seeder responsavel por criar dados iniciais da tabela status_catalogo
 */

namespace Database\Seeders\statusSeeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusCatalogoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          DB::table('status_catalogo')->insert([
            ['nome' => 'Ativo', 'descricao' => 'Catálogo ativo e disponível'],
            ['nome' => 'Inativo', 'descricao' => 'Catálogo inativo e indisponível'],
        ]);
    }
    }
}
