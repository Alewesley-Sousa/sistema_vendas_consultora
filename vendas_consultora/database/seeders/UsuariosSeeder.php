<?php
/**
 * Autor: Alewesley-Sousa
 * Data: 01/03/2026
 * Descrição: seeder responsavel por criar dados iniciais da tabela referente.
 */

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\usuarios;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarios = [
            // Distribuidora
            ['nome' => 'Maria Silva', 'cargo' => 'distribuidora', 'cpf' => '11122233344', 'email' => 'maria.silva@example.com', 'telefone' => '85999990001', 'senha' => Hash::make('senha123'), 'cep' => '60000000', 'consultora_id' => null, 'status_id' => 1],

            // Consultoras
            ['nome' => 'João Pereira', 'cargo' => 'consultora', 'cpf' => '22233344455', 'email' => 'alewesley1234@gmail.com', 'telefone' => '85999990002', 'senha' => Hash::make('senha123'), 'cep' => '60000001', 'consultora_id' => null, 'status_id' => 1],
            ['nome' => 'Ana Costa', 'cargo' => 'consultora', 'cpf' => '33344455566', 'email' => 'ana.costa@example.com', 'telefone' => '85999990003', 'senha' => Hash::make('senha123'), 'cep' => '60000002', 'consultora_id' => null, 'status_id' => 2],
            ['nome' => 'Carlos Souza', 'cargo' => 'consultora', 'cpf' => '44455566677', 'email' => 'carlos.souza@example.com', 'telefone' => '85999990004', 'senha' => Hash::make('senha123'), 'cep' => '60000003', 'consultora_id' => null, 'status_id' => 1],
            ['nome' => 'Fernanda Lima', 'cargo' => 'consultora', 'cpf' => '55566677788', 'email' => 'fernanda.lima@example.com', 'telefone' => '85999990005', 'senha' => Hash::make('senha123'), 'cep' => '60000004', 'consultora_id' => null, 'status_id' => 2],
            ['nome' => 'Lucas Martins', 'cargo' => 'consultora', 'cpf' => '66677788899', 'email' => 'lucas.martins@example.com', 'telefone' => '85999990006', 'senha' => Hash::make('senha123'), 'cep' => '60000005', 'consultora_id' => null, 'status_id' => 1],
            ['nome' => 'Patrícia Gomes', 'cargo' => 'consultora', 'cpf' => '77788899900', 'email' => 'patricia.gomes@example.com', 'telefone' => '85999990007', 'senha' => Hash::make('senha123'), 'cep' => '60000006', 'consultora_id' => null, 'status_id' => 2],
            ['nome' => 'Ricardo Nunes', 'cargo' => 'consultora', 'cpf' => '88899900011', 'email' => 'ricardo.nunes@example.com', 'telefone' => '85999990008', 'senha' => Hash::make('senha123'), 'cep' => '60000007', 'consultora_id' => null, 'status_id' => 1],
            ['nome' => 'Beatriz Melo', 'cargo' => 'consultora', 'cpf' => '99900011122', 'email' => 'beatriz.melo@example.com', 'telefone' => '85999990009', 'senha' => Hash::make('senha123'), 'cep' => '60000008', 'consultora_id' => null, 'status_id' => 2],
            ['nome' => 'Felipe Araújo', 'cargo' => 'consultora', 'cpf' => '00011122233', 'email' => 'felipe.araujo@example.com', 'telefone' => '85999990010', 'senha' => Hash::make('senha123'), 'cep' => '60000009', 'consultora_id' => null, 'status_id' => 1],
            ['nome' => 'Larissa Monteiro', 'cargo' => 'consultora', 'cpf' => '12123234354', 'email' => 'larissa.monteiro@example.com', 'telefone' => '85999990011', 'senha' => Hash::make('senha123'), 'cep' => '60000010', 'consultora_id' => null, 'status_id' => 2],
            ['nome' => 'Daniel Ribeiro', 'cargo' => 'consultora', 'cpf' => '23234345465', 'email' => 'daniel.ribeiro@example.com', 'telefone' => '85999990012', 'senha' => Hash::make('senha123'), 'cep' => '60000011', 'consultora_id' => null, 'status_id' => 1],

            //lider
            ['nome' => 'Paulo Henrique', 'cargo' => 'lider', 'cpf' => '78789890910', 'email' => 'paulo.henrique@example.com', 'telefone' => '85999990017', 'senha' => Hash::make('senha123'), 'cep' => '60000016', 'consultora_id' => null, 'status_id' => 1],
            ['nome' => 'Sofia Mendes', 'cargo' => 'consultora', 'cpf' => '34345456576', 'email' => 'sofia.mendes@example.com', 'telefone' => '85999990013', 'senha' => Hash::make('senha123'), 'cep' => '60000012', 'consultora_id' => 12, 'status_id' => 2],
            ['nome' => 'Gabriel Fernandes', 'cargo' => 'consultora', 'cpf' => '45456567687', 'email' => 'gabriel.fernandes@example.com', 'telefone' => '85999990014', 'senha' => Hash::make('senha123'), 'cep' => '60000013', 'consultora_id' => 12, 'status_id' => 1],
            ['nome' => 'Isabela Castro', 'cargo' => 'consultora', 'cpf' => '56567678798', 'email' => 'isabela.castro@example.com', 'telefone' => '85999990015', 'senha' => Hash::make('senha123'), 'cep' => '60000014', 'consultora_id' => 12, 'status_id' => 2],
            ['nome' => 'Thiago Moreira', 'cargo' => 'consultora', 'cpf' => '67678789809', 'email' => 'thiago.moreira@example.com', 'telefone' => '85999990016', 'senha' => Hash::make('senha123'), 'cep' => '60000015', 'consultora_id' => 12, 'status_id' => 1],

            // Líderes
            ['nome' => 'Juliana Alves', 'cargo' => 'lider', 'cpf' => '89890901021', 'email' => 'juliana.alves@example.com', 'telefone' => '85999990018', 'senha' => Hash::make('senha123'), 'cep' => '60000017', 'consultora_id' => null, 'status_id' => 2],
            ['nome' => 'Roberto Dias', 'cargo' => 'lider', 'cpf' => '90901012132', 'email' => 'roberto.dias@example.com', 'telefone' => '85999990019', 'senha' => Hash::make('senha123'), 'cep' => '60000018', 'consultora_id' => null, 'status_id' => 1],
            ['nome' => 'Camila Rocha', 'cargo' => 'lider', 'cpf' => '01012123243', 'email' => 'camila.rocha@example.com', 'telefone' => '85999990020', 'senha' => Hash::make('senha123'), 'cep' => '60000019', 'consultora_id' => null, 'status_id' => 2],
        ];

        foreach ($usuarios as $user) {
            // Usamos forceCreate porque 'cargo' está no seu $guarded.
            // O forceCreate ignora o guarded apenas nesta execução.
            usuarios::forceCreate($user);
        }
    }
}
