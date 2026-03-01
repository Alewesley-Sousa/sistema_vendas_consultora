<?php

namespace Database\Seeders\tipoSeeders;

use Illuminate\Database\Seeder;

class TipoSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            TipoCatalogoSeeder::class,
            TipoDevolucaoSeeder::class,
            TipoMovimentacaoEstoqueSeeder::class,
            TipoMovimentacaoComissaoSeeder::class,
            TipoPromocaoSeeder::class,
            TipoComissaoSeeder::class
        ]);
    }
}
