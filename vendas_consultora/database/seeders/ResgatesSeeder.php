<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\resgates;
use App\Models\usuarios; // Importante adicionar para a verificação

class ResgatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resgates = [
            ['total_pontos' => 400, 'consultora_id' => 2, 'catalogo_id' => 2, 'data' => '2026-02-01 10:15:00', 'status_id' => 1],
            ['total_pontos' => 600, 'consultora_id' => 3, 'catalogo_id' => 2, 'data' => '2026-02-02 14:20:00', 'status_id' => 2],
            ['total_pontos' => 800, 'consultora_id' => 4, 'catalogo_id' => 2, 'data' => '2026-02-03 09:45:00', 'status_id' => 3],
            ['total_pontos' => 1200, 'consultora_id' => 5, 'catalogo_id' => 2, 'data' => '2026-02-04 11:30:00', 'status_id' => 2],
            ['total_pontos' => 500, 'consultora_id' => 6, 'catalogo_id' => 2, 'data' => '2026-02-05 16:10:00', 'status_id' => 1],
            ['total_pontos' => 700, 'consultora_id' => 7, 'catalogo_id' => 2, 'data' => '2026-02-06 13:00:00', 'status_id' => 2],
            ['total_pontos' => 900, 'consultora_id' => 8, 'catalogo_id' => 2, 'data' => '2026-02-07 15:25:00', 'status_id' => 3],
            ['total_pontos' => 1000, 'consultora_id' => 9, 'catalogo_id' => 2, 'data' => '2026-02-08 17:40:00', 'status_id' => 2],
            ['total_pontos' => 450, 'consultora_id' => 10, 'catalogo_id' => 2, 'data' => '2026-02-09 12:05:00', 'status_id' => 1],
            ['total_pontos' => 650, 'consultora_id' => 11, 'catalogo_id' => 2, 'data' => '2026-02-10 18:15:00', 'status_id' => 2],
            ['total_pontos' => 750, 'consultora_id' => 12, 'catalogo_id' => 2, 'data' => '2026-02-11 19:00:00', 'status_id' => 3],
            ['total_pontos' => 850, 'consultora_id' => 13, 'catalogo_id' => 2, 'data' => '2026-02-12 20:10:00', 'status_id' => 2],
            ['total_pontos' => 950, 'consultora_id' => 14, 'catalogo_id' => 2, 'data' => '2026-02-13 09:20:00', 'status_id' => 1],
            ['total_pontos' => 1050, 'consultora_id' => 15, 'catalogo_id' => 2, 'data' => '2026-02-14 10:30:00', 'status_id' => 2],
            ['total_pontos' => 1150, 'consultora_id' => 16, 'catalogo_id' => 2, 'data' => '2026-02-15 11:45:00', 'status_id' => 3],
            ['total_pontos' => 300, 'consultora_id' => 2, 'catalogo_id' => 2, 'data' => '2026-02-16 12:00:00', 'status_id' => 2],
            ['total_pontos' => 500, 'consultora_id' => 3, 'catalogo_id' => 2, 'data' => '2026-02-17 13:15:00', 'status_id' => 1],
            ['total_pontos' => 700, 'consultora_id' => 4, 'catalogo_id' => 2, 'data' => '2026-02-18 14:25:00', 'status_id' => 2],
            ['total_pontos' => 900, 'consultora_id' => 5, 'catalogo_id' => 2, 'data' => '2026-02-19 15:35:00', 'status_id' => 3],
            ['total_pontos' => 1100, 'consultora_id' => 6, 'catalogo_id' => 2, 'data' => '2026-02-20 16:45:00', 'status_id' => 2]
        ];

        foreach ($resgates as $resgate) {
            // Verifica se a consultora e o catálogo existem antes de inserir
            $usuarioExiste = usuarios::where('id', $resgate['consultora_id'])->exists();
            
            // Nota: Se você tiver um CatalogoSeeder, seria bom checar o catalogo_id também!
            if ($usuarioExiste) {
                resgates::forceCreate($resgate);
            }
        }
    }
}
