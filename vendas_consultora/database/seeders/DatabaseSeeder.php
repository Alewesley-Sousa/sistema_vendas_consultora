<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // \Database\Seeders\StatusSeeders\ProducaoSeeder::class,
            // \Database\Seeders\tipo\TesteSeeder::class,
            // UsuariosSeeder::class,
            // CategoriasSeeder::class,
            // ProdutosSeeder::class,
            // EstoquesSeeder::class,
            // MovimentacaoEstoqueSeeder::class,
            // ClientesSeeder::class,
            // PedidosSeeder::class,
            // ItensPedidoSeeder::class,
            // DevolucoesSeeder::class,
            // ItensDevolucaoSeeder::class,
            ComissoesSeeder::class,
            HistoricoComissoesSeeder::class,
            SolicitacoesSaqueSeeder::class,
            CatalogosSeeder::class,
            ItensCatalogosSeeder::class,
            ResgatesSeeder::class,
            ItensResgateSeeder::class,
            PromocoesSeeder::class

        ]);
    }
}
