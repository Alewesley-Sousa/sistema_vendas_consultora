<?php

namespace App\Services;

use App\Models\Catalogos;
use App\Services\LogService; // Importando seu serviço de log
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

            // Registro na tabela de logs
            LogService::registrarAcao(
                'CREATE', 
                'catalogos', 
                $catalogo->id, 
                "Catálogo '{$catalogo->nome}' criado com sucesso."
            );

            DB::commit();
            return $catalogo;

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log de erro no banco
            LogService::registrarAcao('ERROR_CREATE', 'catalogos', null, $e->getMessage());
            
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

            // Registro na tabela de logs
            LogService::registrarAcao(
                'UPDATE', 
                'catalogos', 
                $catalogo->id, 
                "Catálogo ID {$id} atualizado."
            );

            DB::commit();
            return $catalogo;

        } catch (\Exception $e) {
            DB::rollBack();
            
            LogService::registrarAcao('ERROR_UPDATE', 'catalogos', $id, $e->getMessage());
            
            throw $e;
        }
    }

    public function destroy(int $id)
    {
        DB::beginTransaction();
        try {
            $catalogo = Catalogos::findOrFail($id);
            $catalogo->delete();

            // Registro na tabela de logs
            LogService::registrarAcao(
                'DELETE', 
                'catalogos', 
                $id, 
                "Catálogo deletado permanentemente."
            );

            DB::commit();
            return ['message' => 'Catálogo deletado com sucesso'];

        } catch (\Exception $e) {
            DB::rollBack();
            
            LogService::registrarAcao('ERROR_DELETE', 'catalogos', $id, $e->getMessage());
            
            throw $e;
        }
    }
    
    // App\Services\CatalogoService.php

public function saveItem(array $data, ?int $id = null)
{
    DB::beginTransaction();
    try {
        if ($id) {
            $item = \App\Models\ItensCatalogo::findOrFail($id);
            $acao = 'UPDATE_ITEM';
            $mensagem = 'Item do catálogo atualizado com sucesso!';
        } else {
            $item = new \App\Models\ItensCatalogo();
            $acao = 'CREATE_ITEM';
            $mensagem = 'Item adicionado ao catálogo com sucesso!';
        }

        $item->fill([
            'preco'              => $data['preco'] ?? $item->preco,
            'pontos_necessarios' => $data['pontos_necessarios'] ?? $item->pontos_necessarios,
            'status_id'          => $data['status_id'] ?? $item->status_id,
            'estoque_disponivel' => $data['estoque_disponivel'] ?? $item->estoque_disponivel,
            'produto_id'         => $data['produto_id'] ?? $item->produto_id,
            'catalogo_id'        => $data['catalogo_id'] ?? $item->catalogo_id,
        ]);

        $item->save();

        LogService::registrarAcao($acao, 'itens_catalogo', $item->id, $mensagem);

        DB::commit();

        return [
            'status'  => 'success',
            'message' => $mensagem,
            'data'    => $item
        ];

    } catch (\Exception $e) {
        DB::rollBack();
        LogService::registrarAcao('ERROR_ITEM_SAVE', 'itens_catalogo', $id, $e->getMessage());

        return [
            'status'  => 'error',
            'message' => 'Erro ao processar item do catálogo.',
            'error'   => $e->getMessage()
        ];
    }
}

}
