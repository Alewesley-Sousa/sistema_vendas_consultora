<?php

namespace App\Services;

use App\Models\produtos;
use App\Models\estoques;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProdutosService
{
    /**
     * Cria um novo produto no sistema
     * 
     * @param array $dados
     * @return array
     */
    public function criar($dados)
    {
        DB::beginTransaction();
        
        try {
            // Criar o produto
            $produto = produtos::create([
                'nome' => $dados['nome'],
                'preco' => $dados['preco'],
                'descricao' => $dados['descricao'] ?? null,
                'categoria_id' => $dados['categoria_id'],
                'status_id' => $dados['status_id'],
                'imagem_url' => $dados['imagem_url'] ?? null,
                'usuario_id' => Auth::id(), // Adicionar o usuário dono
            ]);

            // Criar estoque inicial se fornecido
            if (!empty($dados['estoque_inicial'])) {
                estoques::create([
                    'produto_id' => $produto->id,
                    'quantidade' => $dados['estoque_inicial'],
                    'localizacao' => $dados['localizacao'] ?? 'Principal',
                    'lote' => $dados['lote'] ?? null,
                ]);
            }

            // Registrar ação no log
            LogService::registrarAcao(
                'criar produto',
                'produtos',
                $produto->id,
                "Produto '{$produto->nome}' criado com sucesso. Preço: R$ " . number_format($produto->preco, 2, ',', '.')
            );

            DB::commit();

            return [
                'status' => 'success',
                'mensagem' => 'Produto criado com sucesso!',
                'dados' => $produto
            ];

        } catch (Exception $e) {
            DB::rollBack();

            return [
                'status' => 'error',
                'mensagem' => 'Erro ao criar produto: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Atualiza um produto existente
     * 
     * @param array $dados
     * @param int $id
     * @return array
     */
    public function atualizar($dados, $id)
    {
        DB::beginTransaction();

        try {
            $produto = produtos::findOrFail($id);

            $produto->update([
                'nome' => $dados['nome'] ?? $produto->nome,
                'preco' => $dados['preco'] ?? $produto->preco,
                'descricao' => $dados['descricao'] ?? $produto->descricao,
                'categoria_id' => $dados['categoria_id'] ?? $produto->categoria_id,
                'status_id' => $dados['status_id'] ?? $produto->status_id,
                'imagem_url' => $dados['imagem_url'] ?? $produto->imagem_url,
            ]);

            LogService::registrarAcao(
                'atualizar produto',
                'produtos',
                $produto->id,
                "Produto '{$produto->nome}' atualizado com sucesso"
            );

            DB::commit();

            return [
                'status' => 'success',
                'mensagem' => 'Produto atualizado com sucesso!',
                'dados' => $produto
            ];

        } catch (Exception $e) {
            DB::rollBack();

            return [
                'status' => 'error',
                'mensagem' => 'Erro ao atualizar produto: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Lista todos os produtos com filtros opcionais
     * 
     * @param array $filtros
     * @return array
     */
    public function listar($filtros = [])
    {
        try {
            $query = produtos::query();

            // Filtrar por usuário se for consultora
            $user = Auth::user();
            if ($user && $user->cargo === 'consultora') {
                $query->where('usuario_id', $user->id);
            }

            if (!empty($filtros['categoria_id'])) {
                $query->where('categoria_id', $filtros['categoria_id']);
            }

            if (!empty($filtros['status_id'])) {
                $query->where('status_id', $filtros['status_id']);
            }

            if (!empty($filtros['busca'])) {
                $query->where('nome', 'like', '%' . $filtros['busca'] . '%')
                      ->orWhere('descricao', 'like', '%' . $filtros['busca'] . '%');
            }

            $produtos = $query->with(['categoria', 'status'])->get();

            return [
                'status' => 'success',
                'dados' => $produtos
            ];

        } catch (Exception $e) {
            return [
                'status' => 'error',
                'mensagem' => 'Erro ao listar produtos: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Obtém um produto específico
     * 
     * @param int $id
     * @return array
     */
    public function obter($id)
    {
        try {
            $produto = produtos::with(['categoria', 'status'])->findOrFail($id);

            return [
                'status' => 'success',
                'dados' => $produto
            ];

        } catch (Exception $e) {
            return [
                'status' => 'error',
                'mensagem' => 'Produto não encontrado'
            ];
        }
    }

    /**
     * Deleta um produto
     * 
     * @param int $id
     * @return array
     */
    public function deletar($id)
    {
        DB::beginTransaction();

        try {
            $produto = produtos::findOrFail($id);
            $nomeProduto = $produto->nome;

            // Soft delete se a tabela suportar
            $produto->delete();

            LogService::registrarAcao(
                'deletar produto',
                'produtos',
                $id,
                "Produto '{$nomeProduto}' deletado com sucesso"
            );

            DB::commit();

            return [
                'status' => 'success',
                'mensagem' => 'Produto deletado com sucesso!'
            ];

        } catch (Exception $e) {
            DB::rollBack();

            return [
                'status' => 'error',
                'mensagem' => 'Erro ao deletar produto: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Obtém relatório de produtos com baixo estoque
     * 
     * @return array
     */
    public function produtosBaixoEstoque($minimo = 10)
    {
        try {
            $produtos = produtos::whereHas('estoques', function ($query) use ($minimo) {
                $query->where('quantidade', '<', $minimo);
            })->with('estoques')->get();

            return [
                'status' => 'success',
                'dados' => $produtos
            ];

        } catch (Exception $e) {
            return [
                'status' => 'error',
                'mensagem' => 'Erro ao gerar relatório: ' . $e->getMessage()
            ];
        }
    }
}
