<?php

/**
 * Autor: Alewesley-Sousa (criador) && Nathan-Barros (desenvolvedor)
 * Data: 01/03/2026
 * Descrição: seeder responsavel por criar dados iniciais da tabela status_pedido
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusPedidoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('status_pedido')->insert([
            [
                'nome' => 'Aguardando Pagamento', 
                'descricao' => 'Pedido aguardando confirmação de pagamento',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nome' => 'Pagamento Confirmado', 
                'descricao' => 'Pagamento foi confirmado',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nome' => 'Separando Pedido', 
                'descricao' => 'Pedido sendo separado no estoque',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nome' => 'Pronto para Envio', 
                'descricao' => 'Pedido pronto para ser enviado',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nome' => 'Enviado', 
                'descricao' => 'Pedido foi enviado',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nome' => 'Entregue', 
                'descricao' => 'Pedido entregue ao cliente',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nome' => 'Cancelado', 
                'descricao' => 'Pedido cancelado',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
