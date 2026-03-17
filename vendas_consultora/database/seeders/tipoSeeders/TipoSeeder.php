<?php
/**
 * Autor: Alewesley-Sousa
 * Data: 01/03/2026
 * Descrição: seeder lider que agrupa todos os outros que estão na mesma pasta (organização de seeders por tipo).
 */

namespace Database\Seeders\tipoSeeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            TipoCatalogoSeeder::class,
            TipoDevolucaoSeeder::class,
            TipoMovimentacaoEstoqueSeeder::class,
            TipoMovimentacaoComissaoSeeder::class,
            TipoPromocaoSeeder::class,
            TiposComissaoSeeder::class
        ]);
    }
}
