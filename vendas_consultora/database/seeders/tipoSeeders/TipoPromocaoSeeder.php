<?php
/**
 * Autor: Alewesley-Sousa (criador) && Nathan-Barros (desenvolvedor)
 * Data: 01/03/2026
 * Descrição: seeder responsavel por criar dados iniciais da tabela referente
 */

namespace Database\Seeders\tipoSeeders;

use App\Models\Tipos\tipo_promocao;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoPromocaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tiposPromocao = [
            [
                'nome' => 'desconto',
                'descricao' => 'Promoção de desconto em porcentagem'
            ],
            [
                'nome' => 'frete grátis',
                'descricao' => 'Promoção de frete grátis para compras acima de um valor'
            ],
            [
                'nome' => 'desconto fixo',
                'descricao' => 'Promoção que oferece um desconto fixo em reais sobre o preço do produto'
            ],
            [
                'nome' => 'pague x e leve y',
                'descricao' => 'Leve x produtos e pague apenas y produtos'
            ],
            [
                'nome' => 'brinde',
                'descricao' => 'Promoção que oferece um brinde na compra de produtos selecionados'
            ]
        ];

        foreach ($tiposPromocao as $tipo) {
            tipo_promocao::create($tipo);
        }
    }
}
