<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\catalogos;

class CatalogosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $catalogos = [
            [
                'nome' => 'exemplo',
                'tipo_catalogo_id' => 1,
                'status_id' => 2,
                'descricao' => 'texto descritivo',
                'data_encerramento' => '2026-12-12',
                'data_publicacao' => '2026-03-02'
            ]
        ];

        foreach ($catalogos as $catalogo) {
            catalogos::forceCreate($catalogo);
        }
    }
}
