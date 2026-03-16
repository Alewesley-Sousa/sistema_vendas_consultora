<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\logs;

class LogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $logs = [
            // Primeiros 20 registros
            [
                'usuario_id' => 1,
                'acao' => 'inserção',
                'entidade_afetada' => 'pedidos',
                'registro_afetado_id' => 1,
                'detalhes' => 'Pedido criado pelo cliente 2',
                'ip_origem' => '192.168.0.10',
                'data_hora' => '2026-01-15 09:30:00'
            ],
            [
                'usuario_id' => 2,
                'acao' => 'atualização',
                'entidade_afetada' => 'devolucoes',
                'registro_afetado_id' => 9,
                'detalhes' => 'Status da devolução alterado para aprovado',
                'ip_origem' => '192.168.0.11',
                'data_hora' => '2026-01-15 10:15:00'
            ],
            [
                'usuario_id' => 3,
                'acao' => 'inserção',
                'entidade_afetada' => 'comissoes',
                'registro_afetado_id' => 5,
                'detalhes' => 'Comissão gerada por venda direta',
                'ip_origem' => '192.168.0.12',
                'data_hora' => '2026-01-16 14:20:00'
            ],
            [
                'usuario_id' => 4,
                'acao' => 'exclusão',
                'entidade_afetada' => 'itens_devolucao',
                'registro_afetado_id' => 3,
                'detalhes' => 'Item de devolução removido por erro',
                'ip_origem' => '192.168.0.13',
                'data_hora' => '2026-01-16 16:45:00'
            ],
            [
                'usuario_id' => 5,
                'acao' => 'inserção',
                'entidade_afetada' => 'resgates',
                'registro_afetado_id' => 2,
                'detalhes' => 'Resgate de pontos solicitado',
                'ip_origem' => '192.168.0.14',
                'data_hora' => '2026-01-17 11:30:00'
            ],
            [
                'usuario_id' => 6,
                'acao' => 'atualização',
                'entidade_afetada' => 'solicitacoes_saque',
                'registro_afetado_id' => 7,
                'detalhes' => 'Solicitação de saque aprovada',
                'ip_origem' => '192.168.0.15',
                'data_hora' => '2026-01-17 15:10:00'
            ],
            [
                'usuario_id' => 7,
                'acao' => 'inserção',
                'entidade_afetada' => 'catalogos',
                'registro_afetado_id' => 1,
                'detalhes' => 'Novo catálogo de verão publicado',
                'ip_origem' => '192.168.0.16',
                'data_hora' => '2026-01-18 09:00:00'
            ],
            [
                'usuario_id' => 8,
                'acao' => 'inserção',
                'entidade_afetada' => 'itens_catalogo',
                'registro_afetado_id' => 5,
                'detalhes' => 'Item Batom Matte adicionado ao catálogo de pontos',
                'ip_origem' => '192.168.0.17',
                'data_hora' => '2026-01-18 10:30:00'
            ],
            [
                'usuario_id' => 9,
                'acao' => 'atualização',
                'entidade_afetada' => 'historico_comissoes',
                'registro_afetado_id' => 12,
                'detalhes' => 'Estorno de comissão registrado',
                'ip_origem' => '192.168.0.18',
                'data_hora' => '2026-01-19 13:40:00'
            ],
            [
                'usuario_id' => 10,
                'acao' => 'inserção',
                'entidade_afetada' => 'promocoes',
                'registro_afetado_id' => 3,
                'detalhes' => 'Promoção Dia das Mães cadastrada',
                'ip_origem' => '192.168.0.19',
                'data_hora' => '2026-01-19 16:20:00'
            ],
            [
                'usuario_id' => 11,
                'acao' => 'inserção',
                'entidade_afetada' => 'itens_promocao',
                'registro_afetado_id' => 6,
                'detalhes' => 'Produto Máscara de Argila vinculado à promoção Carnaval',
                'ip_origem' => '192.168.0.20',
                'data_hora' => '2026-01-20 11:15:00'
            ],
            [
                'usuario_id' => 12,
                'acao' => 'atualização',
                'entidade_afetada' => 'metas',
                'registro_afetado_id' => 4,
                'detalhes' => 'Meta da consultora 4 marcada como atingida',
                'ip_origem' => '192.168.0.21',
                'data_hora' => '2026-01-20 14:30:00'
            ],
            [
                'usuario_id' => 13,
                'acao' => 'inserção',
                'entidade_afetada' => 'logs',
                'registro_afetado_id' => 1,
                'detalhes' => 'Primeiro log de auditoria criado',
                'ip_origem' => '192.168.0.22',
                'data_hora' => '2026-01-21 09:45:00'
            ],
            [
                'usuario_id' => 14,
                'acao' => 'exclusão',
                'entidade_afetada' => 'pedidos',
                'registro_afetado_id' => 7,
                'detalhes' => 'Pedido cancelado por desistência',
                'ip_origem' => '192.168.0.23',
                'data_hora' => '2026-01-21 15:50:00'
            ],
            [
                'usuario_id' => 15,
                'acao' => 'inserção',
                'entidade_afetada' => 'resgates',
                'registro_afetado_id' => 10,
                'detalhes' => 'Resgate de perfume floral aprovado',
                'ip_origem' => '192.168.0.24',
                'data_hora' => '2026-01-22 10:00:00'
            ],
            [
                'usuario_id' => 16,
                'acao' => 'atualização',
                'entidade_afetada' => 'comissoes',
                'registro_afetado_id' => 14,
                'detalhes' => 'Saldo líquido atualizado após saque',
                'ip_origem' => '192.168.0.25',
                'data_hora' => '2026-01-22 13:25:00'
            ],
            [
                'usuario_id' => 17,
                'acao' => 'inserção',
                'entidade_afetada' => 'metas',
                'registro_afetado_id' => 8,
                'detalhes' => 'Meta criada para consultora 8',
                'ip_origem' => '192.168.0.26',
                'data_hora' => '2026-01-23 11:40:00'
            ],
            [
                'usuario_id' => 18,
                'acao' => 'atualização',
                'entidade_afetada' => 'catalogos',
                'registro_afetado_id' => 2,
                'detalhes' => 'Catálogo Pontos Bronze prorrogado',
                'ip_origem' => '192.168.0.27',
                'data_hora' => '2026-01-23 16:10:00'
            ],
            [
                'usuario_id' => 19,
                'acao' => 'inserção',
                'entidade_afetada' => 'itens_resgate',
                'registro_afetado_id' => 5,
                'detalhes' => 'Item Batom resgatado com 400 pontos',
                'ip_origem' => '192.168.0.28',
                'data_hora' => '2026-01-24 09:30:00'
            ],
            [
                'usuario_id' => 20,
                'acao' => 'inserção',
                'entidade_afetada' => 'promocoes',
                'registro_afetado_id' => 5,
                'detalhes' => 'Promoção Black Friday cadastrada',
                'ip_origem' => '192.168.0.29',
                'data_hora' => '2026-01-24 14:50:00'
            ],
            
            // Mais 20 registros para completar os 40
            [
                'usuario_id' => 1,
                'acao' => 'inserção',
                'entidade_afetada' => 'pedidos',
                'registro_afetado_id' => 12,
                'detalhes' => 'Pedido criado pelo cliente 11',
                'ip_origem' => '192.168.0.30',
                'data_hora' => '2026-01-25 10:20:00'
            ],
            [
                'usuario_id' => 2,
                'acao' => 'atualização',
                'entidade_afetada' => 'devolucoes',
                'registro_afetado_id' => 13,
                'detalhes' => 'Devolução parcial registrada',
                'ip_origem' => '192.168.0.31',
                'data_hora' => '2026-01-25 15:35:00'
            ],
            [
                'usuario_id' => 3,
                'acao' => 'inserção',
                'entidade_afetada' => 'comissoes',
                'registro_afetado_id' => 9,
                'detalhes' => 'Comissão gerada por venda nível 1',
                'ip_origem' => '192.168.0.32',
                'data_hora' => '2026-01-26 12:15:00'
            ],
            [
                'usuario_id' => 4,
                'acao' => 'exclusão',
                'entidade_afetada' => 'itens_devolucao',
                'registro_afetado_id' => 8,
                'detalhes' => 'Item de devolução removido por duplicidade',
                'ip_origem' => '192.168.0.33',
                'data_hora' => '2026-01-26 16:40:00'
            ],
            [
                'usuario_id' => 5,
                'acao' => 'inserção',
                'entidade_afetada' => 'resgates',
                'registro_afetado_id' => 15,
                'detalhes' => 'Resgate de pontos cancelado',
                'ip_origem' => '192.168.0.34',
                'data_hora' => '2026-01-27 09:50:00'
            ],
            [
                'usuario_id' => 6,
                'acao' => 'atualização',
                'entidade_afetada' => 'solicitacoes_saque',
                'registro_afetado_id' => 12,
                'detalhes' => 'Solicitação de saque rejeitada',
                'ip_origem' => '192.168.0.35',
                'data_hora' => '2026-01-27 14:05:00'
            ],
            [
                'usuario_id' => 7,
                'acao' => 'inserção',
                'entidade_afetada' => 'catalogos',
                'registro_afetado_id' => 3,
                'detalhes' => 'Catálogo Dia das Mães publicado',
                'ip_origem' => '192.168.0.36',
                'data_hora' => '2026-01-28 11:00:00'
            ],
            [
                'usuario_id' => 8,
                'acao' => 'inserção',
                'entidade_afetada' => 'itens_catalogo',
                'registro_afetado_id' => 7,
                'detalhes' => 'Perfume Floral adicionado ao catálogo de pontos',
                'ip_origem' => '192.168.0.37',
                'data_hora' => '2026-01-28 13:30:00'
            ],
            [
                'usuario_id' => 9,
                'acao' => 'atualização',
                'entidade_afetada' => 'historico_comissoes',
                'registro_afetado_id' => 18,
                'detalhes' => 'Saque registrado no histórico',
                'ip_origem' => '192.168.0.38',
                'data_hora' => '2026-01-29 10:45:00'
            ],
            [
                'usuario_id' => 10,
                'acao' => 'inserção',
                'entidade_afetada' => 'promocoes',
                'registro_afetado_id' => 6,
                'detalhes' => 'Promoção Natal Encantado cadastrada',
                'ip_origem' => '192.168.0.39',
                'data_hora' => '2026-01-29 15:20:00'
            ],
            [
                'usuario_id' => 11,
                'acao' => 'inserção',
                'entidade_afetada' => 'itens_promocao',
                'registro_afetado_id' => 15,
                'detalhes' => 'Esfoliante Corporal vinculado à promoção Black Friday',
                'ip_origem' => '192.168.0.40',
                'data_hora' => '2026-01-30 11:35:00'
            ],
            [
                'usuario_id' => 12,
                'acao' => 'atualização',
                'entidade_afetada' => 'metas',
                'registro_afetado_id' => 12,
                'detalhes' => 'Meta da consultora 12 não atingida',
                'ip_origem' => '192.168.0.41',
                'data_hora' => '2026-01-30 16:15:00'
            ],
            [
                'usuario_id' => 13,
                'acao' => 'inserção',
                'entidade_afetada' => 'logs',
                'registro_afetado_id' => 20,
                'detalhes' => 'Log de auditoria adicional criado',
                'ip_origem' => '192.168.0.42',
                'data_hora' => '2026-01-31 09:25:00'
            ],
            [
                'usuario_id' => 14,
                'acao' => 'exclusão',
                'entidade_afetada' => 'pedidos',
                'registro_afetado_id' => 16,
                'detalhes' => 'Pedido cancelado por devolução total',
                'ip_origem' => '192.168.0.43',
                'data_hora' => '2026-01-31 14:40:00'
            ],
            [
                'usuario_id' => 15,
                'acao' => 'inserção',
                'entidade_afetada' => 'resgates',
                'registro_afetado_id' => 18,
                'detalhes' => 'Resgate de sérum rejuvenescedor aprovado',
                'ip_origem' => '192.168.0.44',
                'data_hora' => '2026-02-01 10:10:00'
            ],
            [
                'usuario_id' => 16,
                'acao' => 'atualização',
                'entidade_afetada' => 'comissoes',
                'registro_afetado_id' => 20,
                'detalhes' => 'Saldo líquido atualizado após estorno',
                'ip_origem' => '192.168.0.45',
                'data_hora' => '2026-02-01 15:55:00'
            ],
            [
                'usuario_id' => 17,
                'acao' => 'inserção',
                'entidade_afetada' => 'metas',
                'registro_afetado_id' => 14,
                'detalhes' => 'Meta criada para consultora 14',
                'ip_origem' => '192.168.0.46',
                'data_hora' => '2026-02-02 12:30:00'
            ],
            [
                'usuario_id' => 18,
                'acao' => 'atualização',
                'entidade_afetada' => 'catalogos',
                'registro_afetado_id' => 1,
                'detalhes' => 'Catálogo Verão encerrado',
                'ip_origem' => '192.168.0.47',
                'data_hora' => '2026-02-02 17:00:00'
            ],
            [
                'usuario_id' => 19,
                'acao' => 'inserção',
                'entidade_afetada' => 'itens_resgate',
                'registro_afetado_id' => 12,
                'detalhes' => 'Item Base Líquida resgatado com 600 pontos',
                'ip_origem' => '192.168.0.48',
                'data_hora' => '2026-02-03 09:45:00'
            ],
            [
                'usuario_id' => 20,
                'acao' => 'inserção',
                'entidade_afetada' => 'promocoes',
                'registro_afetado_id' => 2,
                'detalhes' => 'Promoção Semana da Beleza cadastrada',
                'ip_origem' => '192.168.0.49',
                'data_hora' => '2026-02-03 14:20:00'
            ]
        ];

        foreach ($logs as $log) {
            logs::forceCreate($log);
        }
    }
}
