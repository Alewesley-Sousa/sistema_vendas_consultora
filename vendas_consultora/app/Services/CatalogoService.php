<?php

namespace App\Services;

use App\Models\Catalogos;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CatalogoService
{
    public function index()
    {
        return Catalogos::all();
    }

    public function show(int $id)
    {
        return Catalogos::findOrFail($id);
    }

    public function store(array $data)
    {
        DB::beginTransaction();
        try {
            $catalogo = Catalogos::create([
                'nome'              => $data['nome'],
                'tipo_catalogo_id'  => $data['tipo_catalogo_id'],
                'status_id'         => $data['status_id'],
                'descricao'         => $data['descricao'] ?? null,
                'data_encerramento' => Carbon::createFromFormat('d/m/Y', $data['data_encerramento'])->format('Y-m-d'),
                'data_publicacao'   => Carbon::createFromFormat('d/m/Y', $data['data_publicacao'])->format('Y-m-d'),
            ]);
            DB::commit();

            Log::info('Catálogo criado', ['id' => $catalogo->id]);

            return $catalogo;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao criar catálogo', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function update(array $data, int $id)
    {
        DB::beginTransaction();
        try {
            $catalogo = Catalogos::findOrFail($id);
            $catalogo->update([
                'nome'              => $data['nome'],
                'tipo_catalogo_id'  => $data['tipo_catalogo_id'],
                'status_id'         => $data['status_id'],
                'descricao'         => $data['descricao'] ?? null,
                'data_encerramento' => Carbon::createFromFormat('d/m/Y', $data['data_encerramento'])->format('Y-m-d'),
                'data_publicacao'   => Carbon::createFromFormat('d/m/Y', $data['data_publicacao'])->format('Y-m-d'),
            ]);
            DB::commit();

            Log::info('Catálogo atualizado', ['id' => $catalogo->id]);

            return $catalogo;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao atualizar catálogo', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function destroy(int $id)
    {
        DB::beginTransaction();
        try {
            $catalogo = Catalogos::findOrFail($id);
            $catalogo->delete();
            DB::commit();

            Log::info('Catálogo deletado', ['id' => $id]);

            return ['message' => 'Catálogo deletado com sucesso'];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao deletar catálogo', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}