<?php

namespace App\Services;

use App\Models\estoques;
use App\Services\LogService;
use Illuminate\Support\Facades\DB;
use App\Models\movimentacao_estoque; 
class EstoqueService
{
    public function index()
    {
        return estoques::with('produto')->get();
    }

    public function show(int $id)
    {
        return estoques::with('produto')->findOrFail($id);
    }
/**
     * Retorna o histórico completo de movimentações de estoque com relacionamentos.
     */
    public function getMovimentacoes()
    {
        return movimentacao_estoque::with(['produto', 'tipoMovimentacao'])
            ->latest() // Ordena pelo 'created_at' decrescente
            ->get();
    }
    
    
    /**
 * Retorna todos os produtos que foram criados, mas ainda não possuem estoque definido.
 */
public function getProdutosSemEstoque()
{
    // Usa o Model de produtos para buscar quem NÃO tem relacionamento com estoque
    return \App\Models\produtos::doesntHave('estoque')->get();
}

   

    
    
    
    
    
    public function store(array $data)
    {
        DB::beginTransaction();
        try {
            $estoque = estoques::create($data);

            $estoque->load('produto');
            $nomeProduto = $estoque->produto->nome ?? 'Produto não encontrado';

            LogService::registrarAcao(
                'CREATE',
                'estoques',
                $estoque->id,
                "Estoque criado para o produto '{$nomeProduto}' com quantidade {$estoque->quantidade}."
            );

            DB::commit();

            return [
                'status'  => 'success',
                'message' => "Estoque do produto '{$nomeProduto}' criado com {$estoque->quantidade} unidade(s)."
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            LogService::registrarAcao('ERROR_CREATE', 'estoques', null, $e->getMessage());
            throw $e;
        }
    }

    public function update(array $data, int $id)
    {
        DB::beginTransaction();
        try {
            $estoque = estoques::findOrFail($id);
            $estoque->update($data);

            $estoque->load('produto');
            $nomeProduto = $estoque->produto->nome ?? 'Produto não encontrado';

            LogService::registrarAcao(
                'UPDATE',
                'estoques',
                $id,
                "Estoque ID {$id} atualizado. Produto: '{$nomeProduto}', nova quantidade: {$estoque->quantidade}."
            );

            DB::commit();

            return [
                'status'  => 'success',
                'message' => "Estoque do produto '{$nomeProduto}' atualizado para {$estoque->quantidade} unidade(s)."
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            LogService::registrarAcao('ERROR_UPDATE', 'estoques', $id, $e->getMessage());
            throw $e;
        }
    }

    public function destroy(int $id)
    {
        DB::beginTransaction();
        try {
            $estoque = estoques::with('produto')->findOrFail($id);
            $nomeProduto = $estoque->produto->nome ?? 'Produto não encontrado';
            $estoque->delete();

            LogService::registrarAcao(
                'DELETE',
                'estoques',
                $id,
                "Estoque do produto '{$nomeProduto}' removido."
            );

            DB::commit();

            return [
                'status'  => 'success',
                'message' => "Estoque do produto '{$nomeProduto}' removido com sucesso."
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            LogService::registrarAcao('ERROR_DELETE', 'estoques', $id, $e->getMessage());
            throw $e;
        }
    }
    
        /**
     * Realiza a baixa de múltiplos itens no estoque a partir de um pedido.
     */
 public function baixarEstoquePedido($pedido)
{
    // Carrega os itens do pedido junto com o item correspondente no catálogo
    // IMPORTANTE: mude para o nome exato da relação que está no seu Model
    $itens = $pedido->itensPedidos()->with('itemCatalogo')->get(); 

    foreach ($itens as $item) {
        
        // PEGA O ID DO PRODUTO PASSANDO PELO CATÁLOGO:
        $produtoId = $item->itemCatalogo->produto_id ?? null;

        if (!$produtoId) {
            throw new \Exception("Não foi possível rastrear o produto_id para o item do catálogo ID: {$item->item_catalogo_id}");
        }

        // Agora sim, busca o estoque usando o ID correto do produto
        $estoque = estoques::where('produto_id', $produtoId)->first();

        if (!$estoque) {
            throw new \Exception("Estoque não encontrado para o produto ID: {$produtoId}");
        }

        if ($estoque->quantidade < $item->quantidade) {
            // Se você tiver a relação de produto no catálogo, pode pegar o nome dele assim:
            $produtoNome = $item->itemCatalogo->produto->nome ?? "ID {$produtoId}";
            throw new \Exception("Estoque insuficiente para o produto: {$produtoNome}");
        }

        // Subtrai a quantidade
        $estoque->quantidade -= $item->quantidade;
        $estoque->save();

        LogService::registrarAcao(
            'UPDATE_ESTOQUE_BAIXA',
            'estoques',
            $estoque->id,
            "Baixa automática: Pedido #{$pedido->id} retirou {$item->quantidade} unidades."
        );
    }
}

}