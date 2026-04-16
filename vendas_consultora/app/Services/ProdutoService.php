<?php

namespace App\Services;

use App\Models\produtos;
use App\Services\LogService;
use Illuminate\Support\Facades\DB;

class ProdutoService
{
    public function index()
    {
        // Retorna todos os produtos com os dados da categoria vinculada
        return produtos::with('categoria')->get();
    }

    public function show(int $id)
    {
        return produtos::with('categoria')->findOrFail($id);
    }

    public function store(array $data)
    {
        DB::beginTransaction();
        try {
            $produto = produtos::create($data);
            
            // Carrega o relacionamento para pegar o nome da categoria
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
            LogService::registrarAcao('ERROR_CREATE', 'produtos', null, $e->getMessage());
            throw $e;
        }
    }

    public function update(array $data, int $id)
    {
        DB::beginTransaction();
        try {
            $produto = produtos::findOrFail($id);
            $produto->update($data);
            
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
