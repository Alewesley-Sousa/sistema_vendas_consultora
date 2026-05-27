<?php
/**
 * Autor: Alewesley-Sousa
 * Data: 21/04/2026
 * Descrição: Seeder responsável por criar a estrutura hierárquica completa para testes de desempenho de rede.
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\usuarios;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpa a tabela para evitar IDs bagunçados (Opcional, mas recomendado para testes)
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // usuarios::truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $usuarios = [
            // Distribuidora
            ['id' => 1, 'nome' => 'Maria Silva', 'cargo' => 'distribuidora', 'cpf' => '11122233344', 'email' => 'maria.silva@example.com', 'telefone' => '85999990001', 'senha' => Hash::make('senha123'), 'cep' => '60000000', 'consultora_id' => null, 'status_id' => 1],

            // LÍDER DA REDE EM TESTE (João Pereira)
            ['id' => 2, 'nome' => 'João Pereira', 'cargo' => 'consultora', 'cpf' => '22233344455', 'email' => 'alewesley1234@gmail.com', 'telefone' => '85999990002', 'senha' => Hash::make('senha123'), 'cep' => '60000001', 'consultora_id' => null, 'status_id' => 1],

            // Consultoras Aleatórias
            ['nome' => 'Ana Costa', 'cargo' => 'consultora', 'cpf' => '33344455566', 'email' => 'ana.costa@example.com', 'telefone' => '85999990003', 'senha' => Hash::make('senha123'), 'cep' => '60000002', 'consultora_id' => null, 'status_id' => 2],
            ['nome' => 'Carlos Souza', 'cargo' => 'consultora', 'cpf' => '44455566677', 'email' => 'carlos.souza@example.com', 'telefone' => '85999990004', 'senha' => Hash::make('senha123'), 'cep' => '60000003', 'consultora_id' => null, 'status_id' => 1],
            ['nome' => 'Fernanda Lima', 'cargo' => 'consultora', 'cpf' => '55566677788', 'email' => 'fernanda.lima@example.com', 'telefone' => '85999990005', 'senha' => Hash::make('senha123'), 'cep' => '60000004', 'consultora_id' => null, 'status_id' => 1],
            ['nome' => 'Lucas Martins', 'cargo' => 'consultora', 'cpf' => '66677788899', 'email' => 'lucas.martins@example.com', 'telefone' => '85999990006', 'senha' => Hash::make('senha123'), 'cep' => '60000005', 'consultora_id' => null, 'status_id' => 1],

            // Líder Paulo e sua rede (ID 13)
            ['id' => 13, 'nome' => 'Paulo Henrique', 'cargo' => 'lider', 'cpf' => '78789890910', 'email' => 'paulo.henrique@example.com', 'telefone' => '85999990017', 'senha' => Hash::make('senha123'), 'cep' => '60000016', 'consultora_id' => null, 'status_id' => 1],
            ['nome' => 'Sofia Mendes', 'cargo' => 'consultora', 'cpf' => '34345456576', 'email' => 'sofia.mendes@example.com', 'telefone' => '85999990013', 'senha' => Hash::make('senha123'), 'cep' => '60000012', 'consultora_id' => 13, 'status_id' => 1],
            ['nome' => 'Gabriel Fernandes', 'cargo' => 'consultora', 'cpf' => '45456567687', 'email' => 'gabriel.fernandes@example.com', 'telefone' => '85999990014', 'senha' => Hash::make('senha123'), 'cep' => '60000013', 'consultora_id' => 13, 'status_id' => 1],

            // OUTROS LÍDERES
            ['nome' => 'Juliana Alves', 'cargo' => 'lider', 'cpf' => '89890901021', 'email' => 'juliana.alves@example.com', 'telefone' => '85999990018', 'senha' => Hash::make('senha123'), 'cep' => '60000017', 'consultora_id' => null, 'status_id' => 2],
            ['nome' => 'Roberto Dias', 'cargo' => 'lider', 'cpf' => '90901012132', 'email' => 'roberto.dias@example.com', 'telefone' => '85999990019', 'senha' => Hash::make('senha123'), 'cep' => '60000018', 'consultora_id' => null, 'status_id' => 1],

            // ===============================================================
            // REFEITURA DA REDE DO JOÃO PEREIRA (ID 2) - PROFUNDIDADE
            // ===============================================================

            // NÍVEL 1: Diretos do João
            ['id' => 21, 'nome' => 'Consultora Nivel 1 - A', 'cargo' => 'consultora', 'cpf' => '99911122233', 'email' => 'teste1.rede@example.com', 'telefone' => '85999990121', 'senha' => Hash::make('senha123'), 'cep' => '60000121', 'consultora_id' => 2, 'status_id' => 1],
            ['id' => 22, 'nome' => 'Consultora Nivel 1 - B', 'cargo' => 'consultora', 'cpf' => '99922233344', 'email' => 'teste2.rede@example.com', 'telefone' => '85999990122', 'senha' => Hash::make('senha123'), 'cep' => '60000122', 'consultora_id' => 2, 'status_id' => 1],
            ['id' => 23, 'nome' => 'Consultora Nivel 1 - C', 'cargo' => 'consultora', 'cpf' => '99933344455', 'email' => 'teste3.rede@example.com', 'telefone' => '85999990123', 'senha' => Hash::make('senha123'), 'cep' => '60000123', 'consultora_id' => 2, 'status_id' => 1],

            // NÍVEL 2: Indiretos (Filhos da Consultora A)
            ['id' => 24, 'nome' => 'Consultora Nivel 2 - Sub A1', 'cargo' => 'consultora', 'cpf' => '88811122233', 'email' => 'sub1.rede@example.com', 'telefone' => '85999990124', 'senha' => Hash::make('senha123'), 'cep' => '60000124', 'consultora_id' => 21, 'status_id' => 1],
            ['id' => 25, 'nome' => 'Consultora Nivel 2 - Sub A2', 'cargo' => 'consultora', 'cpf' => '88822233344', 'email' => 'sub2.rede@example.com', 'telefone' => '85999990125', 'senha' => Hash::make('senha123'), 'cep' => '60000125', 'consultora_id' => 21, 'status_id' => 1],

            // NÍVEL 3: Bisneto do João (Filho da Sub A1)
            ['id' => 26, 'nome' => 'Consultora Nivel 3 - Bisneta', 'cargo' => 'consultora', 'cpf' => '77711122233', 'email' => 'bisneta@example.com', 'telefone' => '85999990126', 'senha' => Hash::make('senha123'), 'cep' => '60000126', 'consultora_id' => 24, 'status_id' => 1],
        ];

        foreach ($usuarios as $user) {
            // forceCreate ignora proteção de $guarded para o campo 'cargo'
            usuarios::forceCreate($user);
        }
    }
}
