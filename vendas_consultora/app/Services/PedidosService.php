<?php

namespace App\Services;

use App\Models\itens_pedido;
use App\Models\pedidos;
use App\Models\pagamentos;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Interfaces\calcularSubtotal;
use App\Interfaces\calcularTotal;
use App\Services\LogService;

class PedidosService
{
    public function atualizarPedido($id, $data)
    {
        DB::beginTransaction();
        try {
            $usuarioLongado = Auth::user();
            if (!$usuarioLongado) {
                throw new Exception('Usuário não autenticado');
            }

            $pedido = pedidos::find($id);
            if (!$pedido) {
                throw new Exception('Pedido não encontrado');
            }

            $itensPedidos = itens_pedido::where('pedido_id', $id)->get();

            if (!empty($data['ids_excluidos'])) {
        	    itens_pedido::where('pedidoid', $id)
                	->whereIn('produtoid', $data['id_itens_excluidos'])
                	->delete();
        	}

            //tabela pedidos
            $pedido->status_id = $data['status_id'] ?? $pedido->status_id;
            $pedido->tipo_pagamento = $data['tipo_pagamento'] ?? $pedido->tipo_pagamento;

            // tabela itens_pedido
            $itensAtualizados = collect($data['itens'])->map(function
            ($itemData) use ($itensPedidos, $usuarioLongado) {
                $item = $itensPedidos->firstWhere('produto_id', $itemData['produto_id']);

                if ($item) {
                    $item->quantidade = $itemData['quantidade'] ?? $item->quantidade;
                    if ($usuarioLongado->cargo == "distribuidora") {
                    	$item->preco_unitario = $itemData['preco_unitario'] ??
                    	$item->preco_unitario;
                    }
                    $calculador = new calcularSubtotal($item->quantidade,
                    $item->preco_unitario);
                    $item->subtotal = $calculador->calcular();
                    $item->save();
                }
                
                return $item;
            });
            $subtotais = $itensAtualizados->map(function ($item) {
            	return $item->subtotal;
            })->toArray();
            $calculador = new calcularTotal($subtotais);
            $pedido->valor_total = $calculador->calcular();
            
            $pedido->save();
            
           LogService::registrarAcao(
            	"Atualizar os produtos do pedido #$pedido->id",
            	"Pedidos e itens_pedido",
            	$pedido->id,
            	"Atualizando os dados dos produtos de um pedido"
            	);
            DB::commit();
            
            return [
            	'status' => 'success',
            	'mensagem' => "os produtos do pedido #{$pedido->id} foram atualizados com sucesso"
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
            	'status' => 'error',
            	'mensagem' => "houve um erro no sistema: " . $e->getMessage()
            ];
        }
    }

    public function trazerPedidoPorId($id)
    {
        try {
            $usuarioLongado = Auth::check();
            if (!$usuarioLongado) {
                throw new Exception('Acesso negado!');
            }
            $resultado = pedidos::select('id', 'usuario_id', 'cliente_id',
            'link', 'valor_total', 'status_id', 'tipo_pagamento')->where('id',
            $id)->with('itensPedidos', function ($query) {
                $query->select('id', 'produto_id', 'quantidade', 'preco');
            })->first();
            if (!$resultado) {
                throw new Exception('Pedido não registrado no sistema!');
            }

            return [
                'status' => 'success',
                'data' => $resultado
            ];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'mensagem' => 'Erro encontrado: ' . $e->getMessage()
            ];
        }
    }
    
    protected function diasDesde(string $data) {
    	$data = new DateTime($data);
    	$hoje = new DateTime();
    	$intervalo = $data->diff($hoje);
    	return $intervalo->days;
    }
    
    
    public function excluirPedido($id)
    {
    	DB::beginTransaction();
    	try {
    		$pedido = pedidos::find($id);
    		$pagamento = pagamentos::where('pedido_id', $pedido->id)->first();
    		if ($pedido->status_id === 1) {
    			throw new Exception('pedido náo pode ser mais cancelado.');
    		} elseif ($pedido->status_id === 7) {
    			throw new Exception('o pedido ja foi cancelado á ' .
    			$this->diasDesde($pedido->created_at)) . ' dias.';
    		}
    		
    		$pedido->status_id = 7;
    		$pagamento->status = 'recusado';
    		$pedido->save();
    		$pagamento->save();
    		
    		LogService::registrarAcao(
            	"O pedido #$pedido->id foi cancelado",
            	"Pedidos e pagamentos",
            	$pedido->id,
            	"Atualizando os dados dos produtos de um pedido"
            	);
    		
    		DB::commit();
    		return [
    			'status' => 'sucesso',
    			'mensagem' => 'pedido cancelado com sucesso'
    		];
    	} catch (Exception $e) {
    		DB::rollBack();
    		return [
    			'status' => 'error',
    			'mensagem' => 'erro ao cancelar: ' . $e->getMessage()
    		];
    	}
    }
}
