<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\categorias;

class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            ['nome' => 'Maquiagem', 'descricao' => 'Produtos de beleza como batons, bases, sombras e delineadores.'],
            ['nome' => 'Cuidados com a Pele', 'descricao' => 'Cremes hidratantes, protetores solares, séruns e máscaras faciais.'],
            ['nome' => 'Perfumes', 'descricao' => 'Fragrâncias femininas, masculinas e unissex.'],
            ['nome' => 'Cabelos', 'descricao' => 'Shampoos, condicionadores, máscaras capilares e óleos nutritivos.'],
            ['nome' => 'Unhas', 'descricao' => 'Esmaltes, removedores, fortalecedores e acessórios para manicure.'],
            ['nome' => 'Corpo e Banho', 'descricao' => 'Sabonetes, óleos corporais, hidratantes e esfoliantes.'],
            ['nome' => 'Anti-idade', 'descricao' => 'Produtos específicos para redução de linhas de expressão e rejuvenescimento.'],
            ['nome' => 'Maquiagem Profissional', 'descricao' => 'Produtos de alta performance para uso profissional em salões e eventos.'],
            ['nome' => 'Cosméticos Naturais', 'descricao' => 'Produtos feitos com ingredientes orgânicos e sustentáveis.'],
            ['nome' => 'Kits e Presentes', 'descricao' => 'Conjuntos de cosméticos para presente, embalagens especiais e edições limitadas.'],
        ];

        foreach ($categorias as $categoria) {
            categorias::create($categoria);
        }
    }
}
