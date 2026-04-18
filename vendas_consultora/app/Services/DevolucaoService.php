<?php

namespace App\Services;

use App\Models\devolucoes;
use App\Models\itens_devolucao;
use App\Models\pedidos;
use App\Models\itens_pedido;
use App\Services\LogService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;

class DevolucaoService
{
    /**
     * Lista todas as devoluções pendentes (Para Distribuidora)
     */
public function listarPendentes()
{
    return devolucoes::query()
        ->with([
            // Pega o pedido e, dentro dele, apenas o ID e Nome da consultora
            'pedido' => function ($query) {
                $query->select('id', 'usuario_id') // usuario_id é a FK para a consultora
                      ->with(['consultora:id,nome']); // Assume-se que 'usuario' é a relação no Model Pedido
            },
            // Pega apenas ID e Nome do cliente
            'cliente:id,nome', 
            // Pega apenas ID e Nome do tipo de devolução
            'tipoDevolucao:id,nome'
        ])
        ->where('status_id', 1)
        ->orderBy('data_solicitacao', 'desc')
        ->paginate(10);
}
    /**
     * Solicita uma nova devolução com validações de status e prazo
     */
    public function solicitarDevolucao(array $data)
    {
        DB::beginTransaction();
        try {
            $pedidoId = $data['pedido_id'];
            $existePendente = devolucoes::where('pedido_id', $pedidoId)
                ->where('status_id', 1)
                ->exists();

            // 1. Busca o pedido para validar status e data
            $pedido = pedidos::find($pedidoId);

            if (!$pedido) {
                return [
                    'status'  => 'error',
                    'message' => 'Pedido não encontrado.'
                ];
            }

            // 2. Validação: Status deve ser 6 (Entregue)
            if ($pedido->status_id !== 6) {
                return [
                    'status'  => 'error',
                    'message' => 'Apenas pedidos com status "Entregue" podem ter devolução solicitada.'
                ];
            }

            // 3. Validação: Prazo de 7 dias após a entrega (updated_at do status 6)
            // diffInDays compara a data atual com a data da última atualização
            if ($pedido->updated_at->diffInDays(now()) > 7) {
                return [
                    'status'  => 'error',
                    'message' => 'O prazo para solicitação de devolução (7 dias após a entrega) expirou.'
                ];
            }

            // 4. Validação: Verificando se já existe solicitação pendente
            if ($existePendente) {
                return [
                    'status'  => 'error',
                    'message' => 'Já existe uma solicitação de devolução pendente para este pedido.'
                ];
            }

            // 5. Criação da Devolução Pai
            $devolucao = devolucoes::create([
                'pedido_id'           => $pedidoId,
                'cliente_id'          => $data['cliente_id'],
                'motivo'              => $data['motivo'] ?? null,
                'tipo_devolucao_id'   => $data['tipo_devolucao_id'],
                'status_id'           => 1, // Pendente
                'data_solicitacao'    => now(),
                'usuario_responsavel' => null, // Será preenchido na aprovação
            ]);

            // 6. Lógica de Itens Parciais (tipo_devolucao_id = 1)
            if ($data['tipo_devolucao_id'] == 1 && isset($data['itens'])) {
                foreach ($data['itens'] as $item) {
                    $itemPedido = itens_pedido::where('pedido_id', $pedidoId)
                        ->where('id', $item['item_pedido_id'])
                        ->firstOrFail();

                    if ($item['quantidade'] > $itemPedido->quantidade) {
                        throw new Exception("Quantidade excedente no item #{$item['item_pedido_id']}.");
                    }

                    itens_devolucao::create([
                        'item_pedido_id' => $item['item_pedido_id'],
                        'devolucao_id'   => $devolucao->id,
                        'quantidade'     => $item['quantidade'],
                        'subtotal'       => $item['quantidade'] * $itemPedido->preco_unitario,
                    ]);
                }
            }

            // 7. Registro de Log
            LogService::registrarAcao(
                'CREATE',
                'devolucoes',
                $devolucao->id,
                "Solicitação de devolução criada para o pedido #{$pedidoId} (Status: Entregue)."
            );

            DB::commit();

            return [
                'status'  => 'success',
                'message' => 'Solicitação enviada! Analisaremos o seu pedido em breve.'
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'status'  => 'error',
                'message' => 'Falha ao processar devolução: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Aprova uma devolução e retorna os itens ao estoque
     */
    public function aprovarDevolucao(int $id, int $usuarioResponsavelId)
    {
        DB::beginTransaction();
        try {
            // 1. Carrega a devolução com os itens e o pedido (e seus itens)
            $devolucao = devolucoes::with(['itensDevolucao.itemPedido', 'pedido.itensPedidos'])->findOrFail($id);

            if (Auth::user()->cargo !== 'distribuidora') {
                return [
                    'status'  => 'error',
                    'message' => 'Acesso negado. Apenas distribuidoras podem aprovar devoluções.'
                ];
            }

            if ($devolucao->status_id !== 1) {
                return [
                    'status'  => 'error',
                    'message' => 'Esta devolução já foi processada ou não está mais pendente.'
                ];
            }

            // 2. Determinar quais itens devolver ao estoque
            $itensParaEstornar = [];

            if ($devolucao->tipo_devolucao_id == 2) {
                // DEVOLUÇÃO TOTAL: Pega todos os itens do pedido original
                foreach ($devolucao->pedido->itensPedidos as $itemPedido) {
                    $itensParaEstornar[] = [
                        'produto_id' => $itemPedido->produto_id,
                        'quantidade' => $itemPedido->quantidade
                    ];
                }
            } else {
                // DEVOLUÇÃO PARCIAL: Pega apenas os itens registrados na devolução
                foreach ($devolucao->itensDevolucao as $itemDevolucao) {
                    $itensParaEstornar[] = [
                        'produto_id' => $itemDevolucao->itemPedido->produto_id,
                        'quantidade' => $itemDevolucao->quantidade
                    ];
                }
            }

            // 3. Processar a entrada no estoque para cada item
            foreach ($itensParaEstornar as $item) {
                // Atualiza o saldo na tabela 'estoques'
                $estoque = \App\Models\estoques::where('produto_id', $item['produto_id'])->first();

                if ($estoque) {
                    $estoque->increment('quantidade', $item['quantidade']);
                } else {
                    // Caso o produto não tenha registro no estoque, cria um
                    \App\Models\estoques::create([
                        'produto_id' => $item['produto_id'],
                        'quantidade' => $item['quantidade']
                    ]);
                }

                // Registra a movimentação de entrada (Histórico)
                \App\Models\movimentacao_estoque::create([
                    'produto_id'           => $item['produto_id'],
                    'quantidade'           => $item['quantidade'],
                    'origem_tipo'          => 'devolucoes',
                    'origem_id'            => $devolucao->id,
                    'tipo_movimentacao_id' => 1, // 1 = entrada (conforme seu seeder)
                    'usuario_responsavel'  => $usuarioResponsavelId,
                ]);
            }

            // 4. Atualização do status da devolução
            $devolucao->update([
                'status_id'           => 2, // Aprovada
                'data_decisao'        => now(),
                'usuario_responsavel' => $usuarioResponsavelId
            ]);

            // 5. Registro de Log de Auditoria
            LogService::registrarAcao(
                'UPDATE',
                'devolucoes',
                $devolucao->id,
                "Devolução #{$id} aprovada. Itens retornados ao estoque."
            );

            DB::commit();
            return [
                'status'  => 'success',
                'message' => 'Devolução aprovada e estoque atualizado com sucesso.'
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'status'  => 'error',
                'message' => 'Erro ao aprovar devolução: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Rejeita uma devolução pendente
     */
    public function rejeitarDevolucao(int $id, int $usuarioResponsavelId, string $motivoRejeicao = null)
    {
        DB::beginTransaction();
        try {
            $devolucao = devolucoes::findOrFail($id);
            // Validação de segurança extra
            if (Auth::user()->cargo !== 'distribuidora') {
                return [
                    'status'  => 'error',
                    'message' => 'Acesso negado. Apenas distribuidoras podem aprovar devoluções.'
                ];
            }
            // Validação
            if ($devolucao->status_id !== 1) {
                return [
                    'status'  => 'error',
                    'message' => 'Esta devolução já foi processada ou não está mais pendente.'
                ];
            }

            // 2. Atualização dos campos
            // Se o motivo for enviado, ele substitui ou concatena com o motivo original
            $devolucao->update([
                'status_id'           => 3, // Rejeitada
                'data_decisao'        => now(),
                'usuario_responsavel' => $usuarioResponsavelId,
                'motivo'              => $motivoRejeicao ?? $devolucao->motivo
            ]);

            // 3. Registro de Log
            LogService::registrarAcao(
                'UPDATE',
                'devolucoes',
                $devolucao->id,
                "Devolução do pedido #{$devolucao->pedido_id} foi REJEITADA. Motivo: " . ($motivoRejeicao ?? 'Não informado')
            );

            DB::commit();
            return [
                'status'  => 'success',
                'message' => 'Devolução rejeitada com sucesso.'
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'status'  => 'error',
                'message' => 'Erro ao rejeitar devolução: ' . $e->getMessage()
            ];
        }
    }
}
