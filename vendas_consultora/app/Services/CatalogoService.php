<?php

namespace App\Services;

use App\Models\catalogos;
use App\Services\LogService; // Importando seu serviço de log
use App\Models\itens_catalogo;
use Carbon\Carbon;
use Exception;
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
        "nome" => $request->nome,
        "tipo_catalogo_id" => $request->tipo_catalogo_id,
        "status_id" => $request->status_id,
        "descricao" => $request->descricao ?? null,
        "data_encerramento" => Carbon::createFromFormat(
          "d/m/Y",
          $request->data_encerramento
        )->format("Y-m-d"),
        "data_publicacao" => Carbon::createFromFormat(
          "d/m/Y",
          $request->data_publicacao
        )->format("Y-m-d"),
      ]);

      // Registro na tabela de logs
      LogService::registrarAcao(
        "CREATE",
        "catalogos",
        $catalogo->id,
        "Catálogo '{$catalogo->nome}' criado com sucesso."
      );

      DB::commit();
      return $catalogo;
    } catch (\Exception $e) {
      DB::rollBack();

      // Log de erro no banco
      LogService::registrarAcao(
        "ERROR_CREATE",
        "catalogos",
        null,
        $e->getMessage()
      );

      throw $e;

      Log::info("Catálogo criado", ["id" => $catalogo->id]);

      return [
        "status" => "success",
        "message" => "Catálogo criado com sucesso",
        "data" => $catalogo,
      ];
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error("Erro ao criar catálogo", ["error" => $e->getMessage()]);
      return [
        "status" => "error",
        "message" => "Erro ao criar catálogo",
      ];
    }
  }

  public function editar($request, int $id)
  {
    DB::beginTransaction();
    try {
      $catalogo = catalogos::findOrFail($id);
      $catalogo->update([
        "nome" => $request->nome,
        "tipo_catalogo_id" => $request->tipo_catalogo_id,
        "status_id" => $request->status_id,
        "descricao" => $request->descricao ?? null,
        "data_encerramento" => Carbon::createFromFormat(
          "d/m/Y",
          $request->data_encerramento
        )->format("Y-m-d"),
        "data_publicacao" => Carbon::createFromFormat(
          "d/m/Y",
          $request->data_publicacao
        )->format("Y-m-d"),
      ]);

      // Registro na tabela de logs
      LogService::registrarAcao(
        "UPDATE",
        "catalogos",
        $catalogo->id,
        "Catálogo ID {$id} atualizado."
      );

      DB::commit();
      return $catalogo;
    } catch (\Exception $e) {
      DB::rollBack();

      LogService::registrarAcao(
        "ERROR_UPDATE",
        "catalogos",
        $id,
        $e->getMessage()
      );

      throw $e;

      Log::info("Catálogo atualizado", ["id" => $catalogo->id]);

      return [
        "status" => "success",
        "message" => "Catálogo atualizado com sucesso",
        "data" => $catalogo,
      ];
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error("Erro ao atualizar catálogo", ["error" => $e->getMessage()]);
      return [
        "status" => "error",
        "message" => "Erro ao atualizar catálogo",
      ];
    }
  }

  public function excluir(int $id)
  {
    DB::beginTransaction();
    try {
      $catalogo = catalogos::findOrFail($id);
      $catalogo->delete();

      // Registro na tabela de logs
      LogService::registrarAcao(
        "DELETE",
        "catalogos",
        $id,
        "Catálogo deletado permanentemente."
      );

      DB::commit();
      return ["message" => "Catálogo deletado com sucesso"];
    } catch (\Exception $e) {
      DB::rollBack();

      LogService::registrarAcao(
        "ERROR_DELETE",
        "catalogos",
        $id,
        $e->getMessage()
      );

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
        $acao = "UPDATE_ITEM";
        $mensagem = "Item do catálogo atualizado com sucesso!";
      } else {
        $item = new \App\Models\ItensCatalogo();
        $acao = "CREATE_ITEM";
        $mensagem = "Item adicionado ao catálogo com sucesso!";
      }

      $item->fill([
        "preco" => $data["preco"] ?? $item->preco,
        "pontos_necessarios" =>
          $data["pontos_necessarios"] ?? $item->pontos_necessarios,
        "status_id" => $data["status_id"] ?? $item->status_id,
        "estoque_disponivel" =>
          $data["estoque_disponivel"] ?? $item->estoque_disponivel,
        "produto_id" => $data["produto_id"] ?? $item->produto_id,
        "catalogo_id" => $data["catalogo_id"] ?? $item->catalogo_id,
      ]);

      $item->save();

      LogService::registrarAcao($acao, "itens_catalogo", $item->id, $mensagem);

      DB::commit();

      return [
        "status" => "success",
        "message" => $mensagem,
        "data" => $item,
      ];
    } catch (\Exception $e) {
      DB::rollBack();

      return [
        "status" => "error",
        "message" => "Erro ao processar item do catálogo.",
        "error" => $e->getMessage(),
      ];
    }
  }

  public function trazerItens(int $id, $busca = null)
  {
    try {
    	if (!catalogos::find($id)) {
    		throw new Exception("nenhum catalogo encontrada.");
    	}
      $query = itens_catalogo::where("catalogo_id", $id);

	if (!$query) {
		throw new Exception("nenhuma item do catalogo encontrada.");
	}
      if ($busca) {
        $query->whereHas("produto", function ($q) use ($busca) {
          $q->where("nome", "like", "%" . $busca . "%");
        });
      }

      $itens = $query->with("produto", "status")->get();

      return [
        "status" => "success",
        "data" => $itens,
      ];
    } catch (Exception $e) {
      return [
        "status" => "error",
        "messagem" => "erro ao trazer itens do catalogo: " . $e->getMessage(),
      ];
    }
  }

  public function visualizarItens(array $ids)
  {
    $itens = itens_catalogo::whereIn("id", $ids)
      ->with("produto", "status")
      ->get();

    if ($itens->isEmpty()) {
      return [
        "status" => "error",
        "mensagem" => "Nenhum item encontrado",
      ];
    }

    return [
      "status" => "success",
      "data" => $itens,
    ];
  }
}
