<?php
/**
 * Autor: Alewesley-Sousa (criador) && Nathan-Barros (desenvolvedor)
 * Data: 01/03/2026
 * Descrição: seeder responsavel por criar dados iniciais da tabela referente
 */

namespace Database\Seeders\tipoSeeders;

use App\Models\Tipos\tipo_movimentacao_estoque;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoMovimentacaoEstoqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tiposMovimentacao = [
            [
                'nome' => 'entrada',
                'descricao' => 'Movimentação de entrada de estoque'
            ],
            [
                'nome' => 'saida',
                'descricao' => 'Movimentação de saída de estoque'
            ]
        ];

        foreach ($tiposMovimentacao as $tipo) {
            tipo_movimentacao_estoque::create($tipo);
        }
    }
}
