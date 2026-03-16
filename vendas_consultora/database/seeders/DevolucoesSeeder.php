<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\devolucoes;

class DevolucoesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $devolucoes = [
            [
                'pedido_id' => 1,
                'cliente_id' => 2,
                'motivo' => 'Cliente devolveu apenas um dos itens por defeito',
                'tipo_devolucao_id' => 1,
                'status_id' => 1,
                'data_decisao' => null,
                'data_solicitacao' => Carbon::now(),
                'usuario_responsavel' => 1
            ],
            [
                'pedido_id' => 2,
                'cliente_id' => 3,
                'motivo' => 'Pedido devolvido integralmente por desistência',
                'tipo_devolucao_id' => 2,
                'status_id' => 2,
                'data_decisao' => Carbon::now(),
                'data_solicitacao' => Carbon::now(),
                'usuario_responsavel' => 1
            ],
            [
                'pedido_id' => 3,
                'cliente_id' => 4,
                'motivo' => 'Produto incorreto enviado, devolução parcial',
                'tipo_devolucao_id' => 1,
                'status_id' => 2,
                'data_decisao' => Carbon::now(),
                'data_solicitacao' => Carbon::now(),
                'usuario_responsavel' => 1
            ],
            [
                'pedido_id' => 4,
                'cliente_id' => 5,
                'motivo' => 'Cliente não ficou satisfeito, devolução total',
                'tipo_devolucao_id' => 2,
                'status_id' => 3,
                'data_decisao' => Carbon::now(),
                'data_solicitacao' => Carbon::now(),
                'usuario_responsavel' => 1
            ],
            [
                'pedido_id' => 5,
                'cliente_id' => 6,
                'motivo' => 'Produto com embalagem danificada, devolução parcial',
                'tipo_devolucao_id' => 1,
                'status_id' => 1,
                'data_decisao' => null,
                'data_solicitacao' => Carbon::now(),
                'usuario_responsavel' => 1
            ],
            [
                'pedido_id' => 6,
                'cliente_id' => 7,
                'motivo' => 'Cliente alegou alergia, devolução total',
                'tipo_devolucao_id' => 2,
                'status_id' => 2,
                'data_decisao' => Carbon::now(),
                'data_solicitacao' => Carbon::now(),
                'usuario_responsavel' => 1
            ],
            [
                'pedido_id' => 7,
                'cliente_id' => 8,
                'motivo' => 'Produto entregue fora do prazo, devolução parcial',
                'tipo_devolucao_id' => 1,
                'status_id' => 3,
                'data_decisao' => Carbon::now(),
                'data_solicitacao' => Carbon::now(),
                'usuario_responsavel' => 1
            ],
            [
                'pedido_id' => 9,
                'cliente_id' => 10,
                'motivo' => 'Itens faltando na caixa, devolução total',
                'tipo_devolucao_id' => 2,
                'status_id' => 1,
                'data_decisao' => null,
                'data_solicitacao' => Carbon::now(),
                'usuario_responsavel' => 1
            ]
        ];

        foreach ($devolucoes as $devolucao) {
            Devolucoes::forceCreate($devolucao);
        }
    }
}
