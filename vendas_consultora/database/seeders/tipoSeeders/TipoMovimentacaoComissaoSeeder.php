<?php
/**
 * Autor: Alewesley-Sousa (criador) && Nathan-Barros (desenvolvedor)
 * Data: 01/03/2026
 * Descrição: seeder responsavel por criar dados iniciais da tabela referente
 */
 
namespace Database\Seeders\tipoSeeders;

use App\Models\Tipos\tipo_movimentacao_comissao;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoMovimentacaoComissaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tiposMovimentacao = [
            [
                'nome' => 'venda',
                'descricao' => 'Movimentação de comissão gerada por venda'
            ],
            [
                'nome' => 'estorno',
                'descricao' => 'Movimentação de comissão gerada por estorno de venda, se a comissão ja tiver sido sacada, o valor do estorno será descontado do próximo saque'
            ],
            [
                'nome' => 'saque',
                'descricao' => 'Movimentação de comissão gerada por solicitação de saque'
            ]
        ];

        foreach ($tiposMovimentacao as $tipo) {
            tipo_movimentacao_comissao::create($tipo);
        }
    }
}
