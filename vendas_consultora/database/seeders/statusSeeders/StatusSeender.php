<?php
/**
 * Autor: Alewesley-Sousa
 * Data: 01/03/2026
 * Descrição: seeder lider que agrupa todos os outros que estão na mesma pasta (organização de seeders por status).
 */

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
