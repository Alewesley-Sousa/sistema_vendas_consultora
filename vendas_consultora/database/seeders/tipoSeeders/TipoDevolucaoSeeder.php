<?php
/**
 * Autor: Alewesley-Sousa (criador) && Nathan-Barros (desenvolvedor)
 * Data: 01/03/2026
 * Descrição: seeder responsavel por criar dados iniciais da tabela referente
 */

namespace Database\Seeders\tipoSeeders;

use App\Models\Tipos\tipo_devolucao;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoDevolucaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tiposDevolucao = [
            [
                'nome' => 'parcial',
                'descricao' => 'Devolução parcial do pedido, onde apenas alguns itens são devolvidos'
            ],
            [
                'nome' => 'total',
                'descricao' => 'Devolução total do pedido, onde todos os itens são devolvidos'
            ]
            ];

            foreach ($tiposDevolucao as $tipo) {
                tipo_devolucao::create($tipo);
            }
    }
}
