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
            \Database\Seeders\statusSeeders\StatusSeeder::class,
            \Database\Seeders\tipoSeeders\TipoSeeder::class,
            UsuariosSeeder::class,
            ClientesSeeder::class,
            CategoriasSeeder::class,
            ProdutosSeeder::class,
            CatalogosSeeder::class,
            ItensCatalogoSeeder::class,
            PedidosSeeder::class,
            ItensPedidoSeeder::class,
            EstoquesSeeder::class,
            MovimentacaoEstoqueSeeder::class,
            DevolucoesSeeder::class,
            ItensDevolucaoSeeder::class,
            ComissoesSeeder::class,
            HistoricoComissoesSeeder::class,
            SolicitacoesSaqueSeeder::class,
            ResgatesSeeder::class,
            ItensResgateSeeder::class,
            PromocoesSeeder::class,
            ItensPromocaoSeeder::class,
            MetasSeeder::class,
            LogsSeeder::class,
            QualificacaoProfissionalSeeder::class,
            HistoricoCargoSeeder::class,
            PagamentosSeeder::class

        ]);
    }
}
