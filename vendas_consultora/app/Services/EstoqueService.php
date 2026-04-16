<?php

namespace App\Services;

use App\Models\estoques;
use App\Services\LogService;
use Illuminate\Support\Facades\DB;

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
}