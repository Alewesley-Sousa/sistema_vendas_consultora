<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\logs;

class LogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $logs = [
            [
                'usuario_id' => 1,
                'registro_afetado_id' => 1,
                'entidade_afetada' => 'metas',
                'acao' => 'criacao',
                'detalhes' => 'cricao de vendas para consultora',
                'ip_origem' => '127.0.0.8:00',
                'data_hora' => '2026-06-06 12:60:60'
            ]
        ];

        foreach ($logs as $log) {
            logs::forceCreate($log);
        }
    }
}
