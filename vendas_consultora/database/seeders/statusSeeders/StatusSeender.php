<?php

namespace Database\Seeders\statusSeeders;

use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            StatusCatalogoSeeder::class,
            StatusConsultoraSeeder::class,
            StatusDevolucaoSeeder::class,
            StatusItemCatalogoSeeder::class,
            StatusMetaSeeder::class,
            StatusPedidoSeeder::class,
            StatusProdutoSeeder::class,
            StatusPromocaoSeeder::class,
            StatusResgateSeeder::class,
            StatusSolicitacaoSaqueSeeder::class
        ]);
    }
}
