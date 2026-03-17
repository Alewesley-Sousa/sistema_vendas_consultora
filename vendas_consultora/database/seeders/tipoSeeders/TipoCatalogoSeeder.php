<?php
/**
 * Autor: Alewesley-Sousa (criador) && Nathan-Barros (desenvolvedor)
 * Data: 01/03/2026
 * Descrição: seeder responsavel por criar dados iniciais da tabela referente
 */

namespace Database\Seeders\tipoSeeders;

use App\Models\Tipos\tipo_catalogo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoCatalogoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipoCatalogo = [
            [
                'nome' => 'recompensas',
                'descricao' => 'Catálogo de recompensas para resgate de pontos'
            ], 
            [
                'nome' => 'vendas',
                'descricao' => 'Catálogo de produtos disponíveis para venda'
            ]
        ];

        foreach ($tipoCatalogo as $tipo) {
            tipo_catalogo::forceCreate($tipo);
        }
    }
}
