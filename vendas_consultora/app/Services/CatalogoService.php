<?php

namespace App\Services;

use App\Models\Catalogos;
use App\Models\itens_catalogo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CatalogoService
{
    public function listarTodos()
    {
        return Catalogos::all();
    }

    public function exibir(int $id)
    {
        return Catalogos::findOrFail($id);
    }

    public function armazenar($request)
    {
        DB::beginTransaction();
        try {
            $catalogo = Catalogos::create([
                'nome'              => $request->nome,
                'tipo_catalogo_id'  => $request->tipo_catalogo_id,
                'status_id'         => $request->status_id,
                'descricao'         => $request->descricao ?? null,
                'data_encerramento' => Carbon::createFromFormat('d/m/Y', $request->data_encerramento)->format('Y-m-d'),
                'data_publicacao'   => Carbon::createFromFormat('d/m/Y', $request->data_publicacao)->format('Y-m-d'),
            ]);
            DB::commit();

            Log::info('Catálogo criado', ['id' => $catalogo->id]);

            return [
                'status'  => 'success',
                'message' => 'Catálogo criado com sucesso',
                'data'    => $catalogo
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao criar catálogo', ['error' => $e->getMessage()]);
            return [
                'status'  => 'error',
                'message' => 'Erro ao criar catálogo'
            ];
        }
    }

    public function editar($request, int $id)
    {
        DB::beginTransaction();
        try {
            $catalogo = Catalogos::findOrFail($id);
            $catalogo->update([
                'nome'              => $request->nome,
                'tipo_catalogo_id'  => $request->tipo_catalogo_id,
                'status_id'         => $request->status_id,
                'descricao'         => $request->descricao ?? null,
                'data_encerramento' => Carbon::createFromFormat('d/m/Y', $request->data_encerramento)->format('Y-m-d'),
                'data_publicacao'   => Carbon::createFromFormat('d/m/Y', $request->data_publicacao)->format('Y-m-d'),
            ]);
            DB::commit();

            Log::info('Catálogo atualizado', ['id' => $catalogo->id]);

            return [
                'status'  => 'success',
                'message' => 'Catálogo atualizado com sucesso',
                'data'    => $catalogo
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao atualizar catálogo', ['error' => $e->getMessage()]);
            return [
                'status'  => 'error',
                'message' => 'Erro ao atualizar catálogo'
            ];
        }
    }

    public function excluir(int $id)
    {
        DB::beginTransaction();
        try {
            $catalogo = Catalogos::findOrFail($id);
            $catalogo->delete();
            DB::commit();

            Log::info('Catálogo deletado', ['id' => $id]);

            return [
                'status'  => 'success',
                'message' => 'Catálogo deletado com sucesso'
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao deletar catálogo', ['error' => $e->getMessage()]);
            return [
                'status'  => 'error',
                'message' => 'Erro ao deletar catálogo'
            ];
        }
    }

    public function trazerItens(int $id, $busca = null)
    {
        $query = itens_catalogo::where('catalogo_id', $id);

        if ($busca) {
            $query->whereHas('produto', function ($q) use ($busca) {
                $q->where('nome', 'like', '%' . $busca . '%');
            });
        }

        $itens = $query->with('produto', 'status')->get();

        return [
            'status' => 'success',
            'data'   => $itens
        ];
    }

    public function visualizarItens(array $ids)
    {
        $itens = itens_catalogo::whereIn('id', $ids)
            ->with('produto', 'status')
            ->get();

        if ($itens->isEmpty()) {
            return [
                'status'   => 'error',
                'mensagem' => 'Nenhum item encontrado'
            ];
        }

        return [
            'status' => 'success',
            'data'   => $itens
        ];
    }
}