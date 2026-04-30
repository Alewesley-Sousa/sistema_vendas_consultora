<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\clientes;
use Illuminate\Support\Facades\DB;

class ClientesSeeder extends Seeder
{
    public function run(): void
    {
        $clientesFixos = [
            ['nome' => 'Carla Menezes', 'email' => 'carla.menezes@example.com', 'telefone' => '85988880001', 'cep' => '60010001', 'consultora_id' => 2, 'cpf' => '11111111111'],
            ['nome' => 'Diego Santos', 'email' => 'diego.santos@example.com', 'telefone' => '85988880002', 'cep' => '60010002', 'consultora_id' => 13, 'cpf' => '22222222222'],
            ['nome' => 'Mariana Oliveira', 'email' => 'mariana.oliveira@example.com', 'telefone' => '85988880003', 'cep' => '60010003', 'consultora_id' => 13, 'cpf' => '33333333333'],
            
            // Clientes distribuídos na hierarquia do João Pereira (ID 2)
            ['nome' => 'Cliente do João (Direto)', 'email' => 'cliente.jp@example.com', 'telefone' => '85988880121', 'cep' => '60010121', 'consultora_id' => 2, 'cpf' => '17171717171'],
            ['nome' => 'Cliente da Nivel 1 - A', 'email' => 'cliente.n1a@example.com', 'telefone' => '85988880124', 'cep' => '60010124', 'consultora_id' => 21, 'cpf' => '20202020202'],
            ['nome' => 'Cliente da Nivel 1 - B', 'email' => 'cliente.n1b@example.com', 'telefone' => '85988880125', 'cep' => '60010125', 'consultora_id' => 22, 'cpf' => '21212121212'],
            ['nome' => 'Cliente da Nivel 2 - Sub A1', 'email' => 'cliente.n2sub@example.com', 'telefone' => '85988880126', 'cep' => '60010126', 'consultora_id' => 24, 'cpf' => '90909090909'],
            ['nome' => 'Cliente da Bisneta (Nivel 3)', 'email' => 'cliente.bisneta@example.com', 'telefone' => '85988880127', 'cep' => '60010127', 'consultora_id' => 26, 'cpf' => '80808080808'],
        ];

        foreach ($clientesFixos as $item) {
            clientes::firstOrCreate(['cpf' => $item['cpf']], $item);
        }

        // --- GERANDO MASSA DE DADOS PARA TESTE DE POTENCIAL ---
        // IDs que agora compõem toda a árvore do João Pereira
        $todaRedeJoao = [2, 21, 22, 23, 24, 25, 26];

        for ($i = 1; $i <= 50; $i++) {
            $cpfAleatorio = str_pad(rand(0, 999999999), 11, '0', STR_PAD_LEFT);
            
            clientes::firstOrCreate(
                ['cpf' => $cpfAleatorio],
                [
                    'nome' => "Consumidor Rede " . $i,
                    'email' => "cliente_rede" . $i . "@email.com",
                    'telefone' => "859" . rand(88000000, 99999999),
                    'cep' => "600" . rand(10000, 20000),
                    // Sorteia um membro da rede para ser o "dono" deste cliente
                    'consultora_id' => $todaRedeJoao[array_rand($todaRedeJoao)],
                ]
            );
        }
    }
}
