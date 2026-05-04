<?php
/**
 * Autor: Alewesley-Sousa (criador) && Nathan-Barros (desenvolvedor)
 * Data: 01/03/2026
 * Descrição: seeder responsavel por criar dados iniciais da tabela referente
 */

namespace Database\Seeders\tipoSeeders;

use App\Models\Tipos\tipos_comissao;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TiposComissaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tiposComissao = [
            [
                'nome' => 'vendas direta',
                'descricao' => 'Comissão gerada por venda direta da consultora',
                'taxa' => 0.30
            ],
            [
                'nome' => 'nivel 1',
                'descricao' => 'Comissão gerada por venda da rede da sua rede (1º nível)',
                'taxa' => 0.05
            ],
            [
                'nome' => 'nivel 2',
                'descricao' => 'Comissão gerada por venda da rede da sua rede (2º nível)',
                'taxa' => 0.02
            ]
        ];

        foreach ($tiposComissao as $tipo) {
            tipos_comissao::create($tipo);
        }
    }
}
