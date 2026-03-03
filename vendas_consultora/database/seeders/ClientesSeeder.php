<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\clientes;

class ClientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clientes = [
            ['nome' => 'Carla Menezes', 'email' => 'carla.menezes@example.com', 'telefone' => '85988880001', 'cep' => '60010001', 'consultora_id' => 2, 'cpf' => '11111111111'],
            ['nome' => 'Diego Santos', 'email' => 'diego.santos@example.com', 'telefone' => '85988880002', 'cep' => '60010002', 'consultora_id' => 3, 'cpf' => '22222222222'],
            ['nome' => 'Mariana Oliveira', 'email' => 'mariana.oliveira@example.com', 'telefone' => '85988880003', 'cep' => '60010003', 'consultora_id' => 4, 'cpf' => '33333333333'],
            ['nome' => 'Felipe Costa', 'email' => 'felipe.costa@example.com', 'telefone' => '85988880004', 'cep' => '60010004', 'consultora_id' => 5, 'cpf' => '44444444444'],
            ['nome' => 'Renata Lima', 'email' => 'renata.lima@example.com', 'telefone' => '85988880005', 'cep' => '60010005', 'consultora_id' => 6, 'cpf' => '55555555555'],
            ['nome' => 'Thiago Rocha', 'email' => 'thiago.rocha@example.com', 'telefone' => '85988880006', 'cep' => '60010006', 'consultora_id' => 7, 'cpf' => '66666666666'],
            ['nome' => 'Luciana Alves', 'email' => 'luciana.alves@example.com', 'telefone' => '85988880007', 'cep' => '60010007', 'consultora_id' => 8, 'cpf' => '77777777777'],
            ['nome' => 'Gabriel Nunes', 'email' => 'gabriel.nunes@example.com', 'telefone' => '85988880008', 'cep' => '60010008', 'consultora_id' => 9, 'cpf' => '88888888888'],
            ['nome' => 'Patrícia Gomes', 'email' => 'patricia.gomes@example.com', 'telefone' => '85988880009', 'cep' => '60010009', 'consultora_id' => 10, 'cpf' => '99999999999'],
            ['nome' => 'André Barbosa', 'email' => 'andre.barbosa@example.com', 'telefone' => '85988880010', 'cep' => '60010010', 'consultora_id' => 11, 'cpf' => '10101010101'],
            ['nome' => 'Sofia Mendes', 'email' => 'sofia.mendes@example.com', 'telefone' => '85988880011', 'cep' => '60010011', 'consultora_id' => 12, 'cpf' => '12121212121'],
            ['nome' => 'Rafael Torres', 'email' => 'rafael.torres@example.com', 'telefone' => '85988880012', 'cep' => '60010012', 'consultora_id' => 2, 'cpf' => '13131313131'],
            ['nome' => 'Isabela Castro', 'email' => 'isabela.castro@example.com', 'telefone' => '85988880013', 'cep' => '60010013', 'consultora_id' => 3, 'cpf' => '14141414141'],
            ['nome' => 'João Victor', 'email' => 'joao.victor@example.com', 'telefone' => '85988880014', 'cep' => '60010014', 'consultora_id' => 4, 'cpf' => '15151515151'],
            ['nome' => 'Larissa Monteiro', 'email' => 'larissa.monteiro@example.com', 'telefone' => '85988880015', 'cep' => '60010015', 'consultora_id' => 5, 'cpf' => '16161616161'],
        ];

        foreach ($clientes as $cliente) {
            clientes::create($cliente);
        }
    }
}
