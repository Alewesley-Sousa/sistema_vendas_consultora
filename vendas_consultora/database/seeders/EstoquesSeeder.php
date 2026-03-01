<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\estoques;

class EstoquesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estoques = [
            ['produto_id' => 1, 'quantidade' => 100],
            ['produto_id' => 2, 'quantidade' => 80],
            ['produto_id' => 3, 'quantidade' => 50],
            ['produto_id' => 4, 'quantidade' => 120],
            ['produto_id' => 5, 'quantidade' => 90],
            ['produto_id' => 6, 'quantidade' => 40],
            ['produto_id' => 7, 'quantidade' => 60],
            ['produto_id' => 8, 'quantidade' => 30],
            ['produto_id' => 9, 'quantidade' => 150],
            ['produto_id' => 10, 'quantidade' => 140],
            ['produto_id' => 11, 'quantidade' => 70],
            ['produto_id' => 12, 'quantidade' => 200],
            ['produto_id' => 13, 'quantidade' => 110],
            ['produto_id' => 14, 'quantidade' => 130],
            ['produto_id' => 15, 'quantidade' => 60],
            ['produto_id' => 16, 'quantidade' => 45],
            ['produto_id' => 17, 'quantidade' => 25],
            ['produto_id' => 18, 'quantidade' => 75],
            ['produto_id' => 19, 'quantidade' => 95],
            ['produto_id' => 20, 'quantidade' => 55],
        ];

        foreach ($estoques as $item) {
            estoques::create($item);
        }
    }
}
