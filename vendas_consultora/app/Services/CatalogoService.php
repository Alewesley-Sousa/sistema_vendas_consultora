<?php

namespace App\Services;

use App\Models\catalogos;
use App\Models\itens_catalogo;
use App\Services\LogService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

// =====================================================
// ESTRUTURA DO SQL (NÃO APAGUE)
// =====================================================

/* CREATE TABLE `catalogos` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(100) NOT NULL,
    `tipo_catalogo_id` BIGINT UNSIGNED NOT NULL,
    `status_id` BIGINT UNSIGNED NOT NULL,
    `descricao` TEXT NULL,
    `data_encerramento` TIMESTAMP NOT NULL,
    `data_publicacao` TIMESTAMP NOT NULL,
    FOREIGN KEY (`tipo_catalogo_id`) REFERENCES `tipo_catalogo`(`id`),
    FOREIGN KEY (`status_id`) REFERENCES `status_catalogo`(`id`)
);

CREATE TABLE `itens_catalogo` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `pontos_necessarios` INT NULL,
    `status_id` BIGINT UNSIGNED NOT NULL,
    `estoque_disponivel` INT NOT NULL DEFAULT 1,
    `produto_id` BIGINT UNSIGNED NOT NULL,
    `catalogo_id` BIGINT UNSIGNED NOT NULL,
    FOREIGN KEY (`status_id`) REFERENCES `status_item_catalogo`(`id`),
    FOREIGN KEY (`produto_id`) REFERENCES `produtos`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`catalogo_id`) REFERENCES `catalogos`(`id`) ON DELETE CASCADE
); */


class CatalogoService
{
    /**
     * Helper privado para formatar datas vindo do formulário (BR para Banco)
     */
    private function formatarData(?string $data)
    {
        return $data ? Carbon::createFromFormat('d/m/Y', $data)->format('Y-m-d') : null;
    }

    public function listarTodos()
    {
        return catalogos::withCount('itensCatalogo')->get();
    }

    public function exibir(int $id)
    {
        return catalogos::findOrFail($id);
    }

    public function armazenar($request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();

            $catalogo = catalogos::create([
                "nome"              => $data['nome'],
                "tipo_catalogo_id"  => $data['tipo_catalogo_id'],
                "status_id"         => $data['status_id'],
                "descricao"         => $data['descricao'] ?? null,
                "data_encerramento" => $this->formatarData($data['data_encerramento'] ?? null),
                "data_publicacao"   => $this->formatarData($data['data_publicacao'] ?? null),
            ]);

            LogService::registrarAcao("CREATE", "catalogos", $catalogo->id, "Catálogo '{$catalogo->nome}' criado.");

            DB::commit();
            return $catalogo;
        } catch (Exception $e) {
            DB::rollBack();
            return ["status" => "error", "message" => "Erro ao criar: " . $e->getMessage()];
        }
    }

    public function editar($request, int $id)
    {
        DB::beginTransaction();
        try {
            $catalogo = catalogos::findOrFail($id);
            $data = $request->all();

            $catalogo->update([
                "nome"              => $data['nome'],
                "tipo_catalogo_id"  => $data['tipo_catalogo_id'],
                "status_id"         => $data['status_id'],
                "descricao"         => $data['descricao'] ?? null,
                "data_encerramento" => $this->formatarData($data['data_encerramento'] ?? null),
                "data_publicacao"   => $this->formatarData($data['data_publicacao'] ?? null),
            ]);

            LogService::registrarAcao("UPDATE", "catalogos", $id, "Catálogo atualizado.");

            DB::commit();
            return $catalogo;
        } catch (Exception $e) {
            DB::rollBack();
            return ["status" => "error", "message" => "Erro ao atualizar: " . $e->getMessage()];
        }
    }

        public function excluir(int $id)
    {
        DB::beginTransaction();
        try {
            // Garante que só busca catálogos que ainda não sofreram soft delete
            $catalogo = catalogos::findOrFail($id);

            // 1. Regra de Negócio: Devolver ao estoque geral o saldo de todos os itens deste catálogo antes de ocultá-lo
            $itens = itens_catalogo::where('catalogo_id', $id)->get();
            
            foreach ($itens as $item) {
                if ($item->estoque_disponivel > 0) {
                    $estoqueGeral = \App\Models\estoques::where('produto_id', $item->produto_id)->first();
                    if ($estoqueGeral) {
                        $estoqueGeral->increment('quantidade', $item->estoque_disponivel);
                    }

                    // Registra a movimentação de retorno individual
                    \App\Models\movimentacao_estoque::create([
                        'produto_id'           => $item->produto_id,
                        'quantidade'           => $item->estoque_disponivel,
                        'origem_tipo'          => 'itens_catalogo',
                        'origem_id'            => $item->id,
                        'tipo_movimentacao_id' => 1, // 1 = Entrada (Retorno ao Geral)
                        'usuario_responsavel'  => auth()->id(),
                    ]);
                }
                // Opcional: Você pode optar por deletar os itens fisicamente ou deixá-los órfãos guardados sob o catálogo excluído.
                // Mantendo os itens salvos aqui preserva o histórico de quais produtos faziam parte da campanha.
                $item->update(['estoque_disponivel' => 0]); 
            }

            // 2. Executa o Soft Delete no Catálogo
            $catalogo->delete();

            LogService::registrarAcao("DELETE", "catalogos", $id, "Soft delete realizado. Itens recolhidos ao estoque geral.");

            DB::commit();
            return ["status" => "success", "message" => "Campanha arquivada e estoque devolvido com sucesso."];
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


public function saveItem(array $data, ?int $id = null)
{
    DB::beginTransaction();
    try {
        $item = $id ? itens_catalogo::findOrFail($id) : new itens_catalogo();

        // 1. Validação de Segurança: Impede a troca de produto em atualizações
        if ($id && isset($data['produto_id']) && $data['produto_id'] != $item->produto_id) {
            throw new Exception("Não é permitido alterar o produto de um item de catálogo já existente. Remova o item e cadastre-o novamente.");
        }

        // Se for uma atualização, a diferença é baseada no que já existe. Se for novo, o anterior é 0.
        $estoqueAnterior = $id ? $item->estoque_disponivel : 0;
        $novoEstoqueCatalogo = $data["estoque_disponivel"] ?? $estoqueAnterior;
        $diferenca = $novoEstoqueCatalogo - $estoqueAnterior;

        // 2. Preenchimento dos dados (produto_id só é definido na criação)
        $item->fill([
            "pontos_necessarios" => $data["pontos_necessarios"] ?? $item->pontos_necessarios,
            "status_id"          => $data["status_id"] ?? $item->status_id,
            "estoque_disponivel" => $novoEstoqueCatalogo,
            "catalogo_id"        => $data["catalogo_id"] ?? $item->catalogo_id,
        ]);

        // Define o produto_id apenas se o registro for novo
        if (!$id) {
            $item->produto_id = $data["produto_id"];
        }

        // 3. Lógica de Movimentação de Estoque Geral
        if ($diferenca != 0) {
            $estoqueGeral = \App\Models\estoques::where('produto_id', $item->produto_id)->first();

            // Validação: Tem saldo no estoque geral para essa reserva? (Se a diferença for positiva, é uma saída do estoque geral)
            if ($diferenca > 0 && (!$estoqueGeral || $estoqueGeral->quantidade < $diferenca)) {
                throw new Exception("Saldo insuficiente no estoque geral para realizar esta reserva no catálogo.");
            }

            // Se a diferença for negativa (ex: diminuiu o estoque do catálogo), o decrement com valor negativo vira soma no estoque geral.
            if ($estoqueGeral) {
                $estoqueGeral->decrement('quantidade', $diferenca);
            }

            // Registra a movimentação
            \App\Models\movimentacao_estoque::create([
                'produto_id'           => $item->produto_id,
                'quantidade'           => abs($diferenca),
                'origem_tipo'          => 'itens_catalogo',
                'origem_id'            => $item->id ?? null,
                'tipo_movimentacao_id' => $diferenca > 0 ? 2 : 1, // 2 = Saída (Geral -> Catálogo), 1 = Entrada (Catálogo -> Geral)
                'usuario_responsavel'  => auth()->id(),
            ]);
        }

        $item->save();

        // 4. Vincula o ID da movimentação ao novo item criado
        if (!$id) {
            \App\Models\movimentacao_estoque::where('origem_tipo', 'itens_catalogo')
                ->whereNull('origem_id')
                ->where('produto_id', $item->produto_id)
                ->update(['origem_id' => $item->id]);
        }

        $acao = $id ? "UPDATE_ITEM" : "CREATE_ITEM";
        LogService::registrarAcao($acao, "itens_catalogo", $item->id, "Item processado. Estoque ajustado: " . ($diferenca > 0 ? "Reserva" : "Retorno"));

        DB::commit();
        return ["status" => "success", "data" => $item];
    } catch (Exception $e) {
        DB::rollBack();
        return ["status" => "error", "message" => $e->getMessage()];
    }
}

    public function trazerItens(int $catalogoId, $busca = null)
    {
        try {
            // Verifica existência
            $catalogo = catalogos::findOrFail($catalogoId);

            $query = itens_catalogo::where("catalogo_id", $catalogoId);

            if ($busca) {
                $query->whereHas("produto", function ($q) use ($busca) {
                    $q->where("nome", "like", "%{$busca}%");
                });
            }

            $itens = $query->with(["produto", "status"])->get();

            return ["status" => "success", "data" => $itens];
        } catch (Exception $e) {
            return ["status" => "error", "message" => $e->getMessage()];
        }
    }

    public function excluirItem(int $id)
    {
        DB::beginTransaction();
        try {
            $item = itens_catalogo::findOrFail($id);
            $quantidadeParaDevolver = $item->estoque_disponivel;

            // 1. Devolve a quantidade para o estoque geral
            if ($quantidadeParaDevolver > 0) {
                $estoqueGeral = \App\Models\estoques::where('produto_id', $item->produto_id)->first();
                
                if ($estoqueGeral) {
                    $estoqueGeral->increment('quantidade', $quantidadeParaDevolver);
                }

                // 2. Registra a movimentação de entrada (Retorno do catálogo)
                \App\Models\movimentacao_estoque::create([
                    'produto_id'           => $item->produto_id,
                    'quantidade'           => $quantidadeParaDevolver,
                    'origem_tipo'          => 'itens_catalogo',
                    'origem_id'            => $item->id,
                    'tipo_movimentacao_id' => 1, // 1 = Entrada (Retorno ao Geral)
                    'usuario_responsavel'  => auth()->id(),
                ]);
            }

            // 3. Deleta o item
            $item->delete();

            LogService::registrarAcao("DELETE_ITEM", "itens_catalogo", $id, "Item removido e estoque devolvido ao geral.");

            DB::commit();
            return ["status" => "success", "message" => "Item removido e estoque reajustado."];
        } catch (Exception $e) {
            DB::rollBack();
            return ["status" => "error", "message" => "Erro ao excluir item: " . $e->getMessage()];
        }
    }
    
    
    
    
    
}
