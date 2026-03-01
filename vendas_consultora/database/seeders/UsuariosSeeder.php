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

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarios = [
            // Distribuidora
            ['nome' => 'Maria Silva', 'cargo' => 'distribuidora', 'email' => 'maria.silva@example.com', 'telefone' => '85999990001', 'senha' => 'senha123', 'cep' => '60000-000', 'consultora_id' => null, 'status_id' => 1],

            // Consultoras
            ['nome' => 'João Pereira', 'cargo' => 'consultora', 'email' => 'joao.pereira@example.com', 'telefone' => '85999990002', 'senha' => 'senha123', 'cep' => '60000-001', 'consultora_id' => null, 'status_id' => 1],
            ['nome' => 'Ana Costa', 'cargo' => 'consultora', 'email' => 'ana.costa@example.com', 'telefone' => '85999990003', 'senha' => 'senha123', 'cep' => '60000-002', 'consultora_id' => null, 'status_id' => 2],
            ['nome' => 'Carlos Souza', 'cargo' => 'consultora', 'email' => 'carlos.souza@example.com', 'telefone' => '85999990004', 'senha' => 'senha123', 'cep' => '60000-003', 'consultora_id' => null, 'status_id' => 1],
            ['nome' => 'Fernanda Lima', 'cargo' => 'consultora', 'email' => 'fernanda.lima@example.com', 'telefone' => '85999990005', 'senha' => 'senha123', 'cep' => '60000-004', 'consultora_id' => null, 'status_id' => 2],
            ['nome' => 'Lucas Martins', 'cargo' => 'consultora', 'email' => 'lucas.martins@example.com', 'telefone' => '85999990006', 'senha' => 'senha123', 'cep' => '60000-005', 'consultora_id' => null, 'status_id' => 1],
            ['nome' => 'Patrícia Gomes', 'cargo' => 'consultora', 'email' => 'patricia.gomes@example.com', 'telefone' => '85999990007', 'senha' => 'senha123', 'cep' => '60000-006', 'consultora_id' => null, 'status_id' => 2],
            ['nome' => 'Ricardo Nunes', 'cargo' => 'consultora', 'email' => 'ricardo.nunes@example.com', 'telefone' => '85999990008', 'senha' => 'senha123', 'cep' => '60000-007', 'consultora_id' => null, 'status_id' => 1],
            ['nome' => 'Beatriz Melo', 'cargo' => 'consultora', 'email' => 'beatriz.melo@example.com', 'telefone' => '85999990009', 'senha' => 'senha123', 'cep' => '60000-008', 'consultora_id' => null, 'status_id' => 2],
            ['nome' => 'Felipe Araújo', 'cargo' => 'consultora', 'email' => 'felipe.araujo@example.com', 'telefone' => '85999990010', 'senha' => 'senha123', 'cep' => '60000-009', 'consultora_id' => null, 'status_id' => 1],
            ['nome' => 'Larissa Monteiro', 'cargo' => 'consultora', 'email' => 'larissa.monteiro@example.com', 'telefone' => '85999990011', 'senha' => 'senha123', 'cep' => '60000-010', 'consultora_id' => null, 'status_id' => 2],
            ['nome' => 'Daniel Ribeiro', 'cargo' => 'consultora', 'email' => 'daniel.ribeiro@example.com', 'telefone' => '85999990012', 'senha' => 'senha123', 'cep' => '60000-011', 'consultora_id' => null, 'status_id' => 1],
            ['nome' => 'Sofia Mendes', 'cargo' => 'consultora', 'email' => 'sofia.mendes@example.com', 'telefone' => '85999990013', 'senha' => 'senha123', 'cep' => '60000-012', 'consultora_id' => null, 'status_id' => 2],
            ['nome' => 'Gabriel Fernandes', 'cargo' => 'consultora', 'email' => 'gabriel.fernandes@example.com', 'telefone' => '85999990014', 'senha' => 'senha123', 'cep' => '60000-013', 'consultora_id' => null, 'status_id' => 1],
            ['nome' => 'Isabela Castro', 'cargo' => 'consultora', 'email' => 'isabela.castro@example.com', 'telefone' => '85999990015', 'senha' => 'senha123', 'cep' => '60000-014', 'consultora_id' => null, 'status_id' => 2],
            ['nome' => 'Thiago Moreira', 'cargo' => 'consultora', 'email' => 'thiago.moreira@example.com', 'telefone' => '85999990016', 'senha' => 'senha123', 'cep' => '60000-015', 'consultora_id' => null, 'status_id' => 1],

            // Líderes
            ['nome' => 'Paulo Henrique', 'cargo' => 'lider', 'email' => 'paulo.henrique@example.com', 'telefone' => '85999990017', 'senha' => 'senha123', 'cep' => '60000-016', 'consultora_id' => null, 'status_id' => 1],
            ['nome' => 'Juliana Alves', 'cargo' => 'lider', 'email' => 'juliana.alves@example.com', 'telefone' => '85999990018', 'senha' => 'senha123', 'cep' => '60000-017', 'consultora_id' => null, 'status_id' => 2],
            ['nome' => 'Roberto Dias', 'cargo' => 'lider', 'email' => 'roberto.dias@example.com', 'telefone' => '85999990019', 'senha' => 'senha123', 'cep' => '60000-018', 'consultora_id' => null, 'status_id' => 1],
            ['nome' => 'Camila Rocha', 'cargo' => 'lider', 'email' => 'camila.rocha@example.com', 'telefone' => '85999990020', 'senha' => 'senha123', 'cep' => '60000-019', 'consultora_id' => null, 'status_id' => 2],
        ];

        foreach ($usuarios as $user) {
            // Usamos forceCreate porque 'cargo' está no seu $guarded.
            // O forceCreate ignora o guarded apenas nesta execução.
            usuarios::forceCreate($user);
        }
    }
}
