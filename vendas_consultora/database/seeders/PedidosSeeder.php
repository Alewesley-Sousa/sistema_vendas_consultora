<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\pedidos;
use Carbon\Carbon;

class PedidosSeeder extends Seeder
{
    public function run(): void
    {
        // Limpamos para garantir que o Tinker não duplique dados em testes manuais
        // pedidos::truncate();

        $agora = Carbon::now(); // Maio 2026
        $mesPassado = Carbon::now()->subMonth(); // Abril 2026

        $pedidosIniciais = [
            // Pedidos Genéricos para outros consultores
            ['usuario_id' => 13, 'cliente_id' => 1, 'link' => 'https://loja.com/p/1', 'valor_total' => 150.00, 'tipo_pagamento' => 'pix', 'status_id' => 2],
            ['usuario_id' => 14, 'cliente_id' => 2, 'link' => 'https://loja.com/p/2', 'valor_total' => 890.00, 'tipo_pagamento' => 'credito', 'status_id' => 5],

            // ===============================================================
            // PERÍODO ANTERIOR (Ex: Abril 2026 ou data fixa tratada)
            // ===============================================================
            ['usuario_id' => 2, 'cliente_id' => 17, 'valor_total' => 5550.00, 'tipo_pagamento' => 'pix', 'status_id' => 6, 'created_at' => "2026-04-06"],
            ['usuario_id' => 21, 'cliente_id' => 19, 'valor_total' => 320.00, 'tipo_pagamento' => 'credito', 'status_id' => 6, 'created_at' => $mesPassado->copy()->day(12)],
            ['usuario_id' => 24, 'cliente_id' => 20, 'valor_total' => 150.00, 'tipo_pagamento' => 'pix', 'status_id' => 5, 'created_at' => $mesPassado->copy()->day(18)],

            // ===============================================================
            // PERÍODO ATUAL (Maio 2026)
            // ===============================================================
            // João (Líder)
            ['usuario_id' => 2, 'cliente_id' => 17, 'valor_total' => 450.00, 'tipo_pagamento' => 'pix', 'status_id' => 5, 'created_at' => $agora->copy()->day(2)],
            
            // Nível 1
            ['usuario_id' => 21, 'cliente_id' => 19, 'valor_total' => 520.00, 'tipo_pagamento' => 'credito', 'status_id' => 5, 'created_at' => $agora->copy()->day(5)],
            ['usuario_id' => 22, 'cliente_id' => 20, 'valor_total' => 300.00, 'tipo_pagamento' => 'pix', 'status_id' => 6, 'created_at' => $agora->copy()->day(10)],
            
            // Nível 2 (Sub A1)
            ['usuario_id' => 24, 'cliente_id' => 21, 'valor_total' => 410.00, 'tipo_pagamento' => 'debito', 'status_id' => 5, 'created_at' => $agora->copy()->day(15)],
            
            // Nível 3 (Bisneta) - Provando a Recursividade
            ['usuario_id' => 26, 'cliente_id' => 22, 'valor_total' => 600.00, 'tipo_pagamento' => 'pix', 'status_id' => 5, 'created_at' => $agora->copy()->day(20)],
        ];

        foreach ($pedidosIniciais as $dados) {
            // Adicionamos link padrão se não existir
            $dados['link'] = $dados['link'] ?? 'https://loja.com/pedido/' . rand(1000, 9000);
            
            // Tratamento rígido de data para não passar objetos brutos ou strings inválidas ao banco
            if (isset($dados['created_at'])) {
                $dados['created_at'] = $dados['created_at'] instanceof Carbon 
                    ? $dados['created_at']->toDateTimeString() 
                    : Carbon::parse($dados['created_at'])->toDateTimeString();
            } else {
                $dados['created_at'] = $agora->toDateTimeString();
            }

            // Força o updated_at a acompanhar rigorosamente a mesma string de data
            $dados['updated_at'] = $dados['created_at'];
            
            pedidos::create($dados);
        }

        // --- MASSA DE DADOS ALEATÓRIA ---
        // Criar mais 20 pedidos rápidos para a rede do João para o gráfico ficar "cheio"
        $membrosRede = [2, 21, 22, 24, 26];
        for ($i = 0; $i < 20; $i++) {
            // Gera uma string de data aleatória limpa dentro do mês atual
            $dataAleatoria = $agora->copy()->subDays(rand(1, 20))->toDateTimeString();

            pedidos::create([
                'usuario_id' => $membrosRede[array_rand($membrosRede)],
                'cliente_id' => rand(1, 20),
                'link' => 'https://loja.com/pedido/auto' . $i,
                'valor_total' => rand(50, 500),
                'tipo_pagamento' => 'pix',
                'status_id' => rand(2, 6), // Status válidos (não 1 ou 7)
                'created_at' => $dataAleatoria,
                'updated_at' => $dataAleatoria,
            ]);
        }
    }
}
