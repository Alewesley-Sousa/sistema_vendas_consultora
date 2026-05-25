<?php

namespace App\Services;

use App\Models\produtos;
use App\Models\estoques;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

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

            // Remove imagem do create inicial
            unset($dados['imagem_url']);

            // Criar produto
            $produto = produtos::create([
                'nome' => $dados['nome'],
                'preco' => $dados['preco'],
                'descricao' => $dados['descricao'] ?? null,
                'categoria_id' => $dados['categoria_id'],
                'status_id' => $dados['status_id'],
                'usuario_id' => Auth::id(),
                'imagem_url' => null,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Upload da imagem
            |--------------------------------------------------------------------------
            */
            if (
                isset($dados['imagem']) &&
                $dados['imagem'] instanceof UploadedFile
            ) {

                $arquivo = $dados['imagem'];

                $nomeArquivo =
                    'produto_' .
                    $produto->id .
                    '_' .
                    time() .
                    '.' .
                    $arquivo->getClientOriginalExtension();

                $path = $arquivo->storeAs(
                    'public/produtos',
                    $nomeArquivo
                );

                // Salva caminho relativo
                $produto->update([
                    'imagem_url' => str_replace('public/', '', $path)
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Estoque inicial
            |--------------------------------------------------------------------------
            */
            if (!empty($dados['estoque_inicial'])) {

                estoques::create([
                    'produto_id' => $produto->id,
                    'quantidade' => $dados['estoque_inicial'],
                    'localizacao' => $dados['localizacao'] ?? 'Principal',
                    'lote' => $dados['lote'] ?? null,
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Log
            |--------------------------------------------------------------------------
            */
            LogService::registrarAcao(
                'criar produto',
                'produtos',
                $produto->id,
                "Produto '{$produto->nome}' criado com sucesso. Preço: R$ " .
                number_format($produto->preco, 2, ',', '.')
            );

            DB::commit();

            return [
                'status' => 'success',
                'mensagem' => 'Produto criado com sucesso!',
                'dados' => $produto->fresh()
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

            /*
            |--------------------------------------------------------------------------
            | Atualiza dados básicos
            |--------------------------------------------------------------------------
            */
            $produto->update([
                'nome' => $dados['nome'] ?? $produto->nome,
                'preco' => $dados['preco'] ?? $produto->preco,
                'descricao' => $dados['descricao'] ?? $produto->descricao,
                'categoria_id' => $dados['categoria_id'] ?? $produto->categoria_id,
                'status_id' => $dados['status_id'] ?? $produto->status_id,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Nova imagem enviada
            |--------------------------------------------------------------------------
            */
            if (
                isset($dados['imagem']) &&
                $dados['imagem'] instanceof UploadedFile
            ) {

                // Remove antiga
                if (
                    !empty($produto->imagem_url) &&
                    Storage::exists('public/' . $produto->imagem_url)
                ) {
                    Storage::delete('public/' . $produto->imagem_url);
                }

                $arquivo = $dados['imagem'];

                $nomeArquivo =
                    'produto_' .
                    $produto->id .
                    '_' .
                    time() .
                    '.' .
                    $arquivo->getClientOriginalExtension();

                $path = $arquivo->storeAs(
                    'public/produtos',
                    $nomeArquivo
                );

                // Atualiza caminho relativo
                $produto->update([
                    'imagem_url' => str_replace('public/', '', $path)
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Log
            |--------------------------------------------------------------------------
            */
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
                'dados' => $produto->fresh()
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
     * Lista todos os produtos
     *
     * @param array $filtros
     * @return array
     */
    public function listar($filtros = [])
    {
        try {

            $query = produtos::query();

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

                $query->where(function ($q) use ($filtros) {
                    $q->where(
                        'nome',
                        'like',
                        '%' . $filtros['busca'] . '%'
                    )
                    ->orWhere(
                        'descricao',
                        'like',
                        '%' . $filtros['busca'] . '%'
                    );
                });
            }

            $produtos = $query
                ->with(['categoria', 'status'])
                ->get();

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
     * Obtém produto específico
     */
    public function obter($id)
    {
        try {

            $produto = produtos::with([
                'categoria',
                'status'
            ])->findOrFail($id);

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
     * Deleta produto + imagem
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

            /*
            |--------------------------------------------------------------------------
            | Remove imagem física
            |--------------------------------------------------------------------------
            */
            if (
                !empty($produto->imagem_url) &&
                Storage::exists('public/' . $produto->imagem_url)
            ) {
                Storage::delete('public/' . $produto->imagem_url);
            }

            /*
            |--------------------------------------------------------------------------
            | Soft delete
            |--------------------------------------------------------------------------
            */
            $produto->delete();

            /*
            |--------------------------------------------------------------------------
            | Log
            |--------------------------------------------------------------------------
            */
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
     * Produtos com baixo estoque
     */
    public function produtosBaixoEstoque($minimo = 10)
    {
        try {

            $produtos = produtos::whereHas(
                'estoques',
                function ($query) use ($minimo) {
                    $query->where(
                        'quantidade',
                        '<',
                        $minimo
                    );
                }
            )
            ->with('estoques')
            ->get();

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