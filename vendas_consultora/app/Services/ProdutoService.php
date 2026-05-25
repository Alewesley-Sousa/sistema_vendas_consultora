<?php

namespace App\Services;

use App\Models\produtos;
use App\Services\LogService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProdutosRequest;

class ProdutoService
{
    public function index()
    {
        return produtos::with('categoria')->get();
    }

    public function show(int $id)
    {
        return produtos::with('categoria')->findOrFail($id);
    }

    public function store(ProdutosRequest $request)
    {
        DB::beginTransaction();
        try {
            $dados = $request->validated();

            // Executa o upload se a imagem foi enviada
            if ($request->hasFile('imagem')) {
                $path = $request->file('imagem')->store('produtos', 'public');
                $dados['imagem_url'] = $path; // Seta o link correto para persistir no banco
            }

            $produto = produtos::create($dados);
            
            $produto->load('categoria');
            $nomeCategoria = $produto->categoria->nome ?? 'Sem Categoria';

            LogService::registrarAcao(
                'CREATE', 
                'produtos', 
                $produto->id, 
                "Produto '{$produto->nome}' cadastrado na categoria '{$nomeCategoria}'."
            );

            DB::commit();

            return [
                'status'  => 'success',
                'message' => "O produto '{$produto->nome}' foi adicionado na categoria '{$nomeCategoria}'."
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'status'  => 'error',
                'message' => "Erro ao adicionar o produto: " . $e->getMessage()
            ];
        }
    }

    public function update(ProdutosRequest $request, int $id)
    {
        DB::beginTransaction();
        try {
            $produto = produtos::findOrFail($id);
            $dados = $request->validated();

            if ($request->hasFile('imagem')) {
                // Remove a imagem antiga se existir para não entulhar o Storage
                if ($produto->imagem_url && Storage::disk('public')->exists($produto->imagem_url)) {
                    Storage::disk('public')->delete($produto->imagem_url);
                }

                $path = $request->file('imagem')->store('produtos', 'public');
                $dados['imagem_url'] = $path;
            }

            $produto->update($dados);
            
            $produto->load('categoria');
            $nomeCategoria = $produto->categoria->nome ?? 'Sem Categoria';

            LogService::registrarAcao(
                'UPDATE', 
                'produtos', 
                $id, 
                "Produto ID {$id} atualizado."
            );

            DB::commit();

            return [
                'status'  => 'success',
                'message' => "Produto '{$produto->nome}' da categoria '{$nomeCategoria}' atualizado com sucesso.",
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            LogService::registrarAcao('ERROR_UPDATE', 'produtos', $id, $e->getMessage());
            throw $e;
        }
    }

    public function destroy(int $id)
    {
        DB::beginTransaction();
        try {
            $produto = produtos::findOrFail($id);
            $nomeRemovido = $produto->nome;

            // Opcional: deletar a imagem do storage ao excluir o produto definitivamente
            if ($produto->imagem_url && Storage::disk('public')->exists($produto->imagem_url)) {
                Storage::disk('public')->delete($produto->imagem_url);
            }

            $produto->delete();

            LogService::registrarAcao(
                'DELETE', 
                'produtos', 
                $id, 
                "Produto '{$nomeRemovido}' removido."
            );

            DB::commit();

            return [
                'status'  => 'success',
                'message' => "Produto '{$nomeRemovido}' removido com sucesso."
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            LogService::registrarAcao('ERROR_DELETE', 'produtos', $id, $e->getMessage());
            throw $e;
        }
    }
}
