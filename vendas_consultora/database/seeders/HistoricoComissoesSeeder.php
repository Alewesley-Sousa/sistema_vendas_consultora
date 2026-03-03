<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\historico_comissoes;

class HistoricoComissoesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $historicosComissoes = [
            [
                'consultora_id' => 1,
                'pedido_id' => 1,
                'tipo_comissao_id' => 1,
                'valor' => 500.00,
                'tipo_movimentacao_id' => 1,
                'data_movimentacao' => '2026-04-12 12:12:12',
                'usuario_responsavel' => 1
            ]
        ];

        foreach ($historicosComissoes as $HC) {
            historico_comissoes::forceCreate($HC);
        }
    }
}
