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
                'nome' => 'Catálogo Verão 2026',
                'tipo_catalogo_id' => 2,
                'status_id' => 1,
                'descricao' => 'Produtos de beleza para o verão',
                'data_publicacao' => '2026-01-10',
                'data_encerramento' => '2026-03-31'
            ],
            [
                'nome' => 'Catálogo Pontos Bronze',
                'tipo_catalogo_id' => 1,
                'status_id' => 1,
                'descricao' => 'Resgate de pontos nível bronze',
                'data_publicacao' => '2026-01-15',
                'data_encerramento' => '2026-06-30'
            ],
            [
                'nome' => 'Catálogo Especial Dia das Mães',
                'tipo_catalogo_id' => 2,
                'status_id' => 2,
                'descricao' => 'Promoções especiais para o Dia das Mães',
                'data_publicacao' => '2026-04-20',
                'data_encerramento' => '2026-05-15'
            ]
        ];

        foreach ($catalogos as $catalogo) {
            catalogos::forceCreate($catalogo);
        }
    }
}
