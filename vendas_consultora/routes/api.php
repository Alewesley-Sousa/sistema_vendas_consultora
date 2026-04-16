<?php

use App\Http\Controllers\CatalogosController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ComissoesController;
use App\Http\Controllers\HistoricoComissoesController;
use App\Http\Controllers\ItensCatalogoController;
use App\Http\Controllers\LiderController;
use App\Http\Controllers\MetasController;
use App\Http\Controllers\ProdutosController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// agrupa todos que usam a autenticação com token
Route::middleware("auth:sanctum")->group(function () {
  Route::prefix("/comissao")->group(function () {
    // Pegar comissao atual do usuario autenticado
    Route::get("/", [ComissoesController::class, "visualizar"]);

    // pegar historico de comissoes do usuarioa autenticado
    Route::get("/historico", [
      HistoricoComissoesController::class,
      "visualizarHistorico",
    ]);

    // solicitar o saque da comissão do usuario
    Route::get("/solicitar", [ComissoesController::class, "solicitarComissao"]);
  });

  Route::prefix("/meta")->group(function () {
    //pegar meta atual do usuario autenticado
    Route::get("/", [MetasController::class, "metaAtual"]);

    // pegar progresso atual da meta do usuario autenticado
    Route::get("/progresso", [MetasController::class, "progressoMeta"]);

    /**
     * criar a meta da consultora selecionada
     */
    Route::post("/atribuir/{id}", [MetasController::class, "atribuirMeta"]);

    /**
     * ver historico de meta e ver o progresso da meta atual
     */
    Route::get("/historico", [
      MetasController::class,
      "historicoMetaProgresso",
    ]);
  });

  Route::prefix("/cliente")->group(function () {
    // cadastrar cliente
    Route::post("/", [ClientesController::class, "cadastrarCliente"]);

    // atualzar dados do cliente
    Route::put("/{cliente}", [ClientesController::class, "atualizarDados"]);

    // exibir um cliente
    Route::get("/{cliente}", [ClientesController::class, "exibir"]);

    // Rota de Ação (API)
    Route::delete("/{id}", [ClientesController::class, "destroy"]);
  });

  Route::prefix("/usuario")->group(function () {
    // cadastrar usuario
    Route::post("/", [UsuariosController::class, "cadastrarUsuario"]);

    // atualzar dados do usuario
    Route::put("/{usuario}", [UsuariosController::class, "atualizarUsuario"]);

    // exibir um usuario
    Route::get("/{usuario}", [UsuariosController::class, "exibirUsuario"]);
  });

  Route::prefix("/catalogo")->group(function () {
    // Listar todos os catálogos
    Route::get("/", [CatalogosController::class, "index"]);

    // Criar um novo catálogo
    Route::post("/", [CatalogosController::class, "store"]);

    // Exibir um catálogo específico
    Route::get("/{id}", [CatalogosController::class, "show"]);

    // Atualizar um catálogo
    Route::put("/{id}", [CatalogosController::class, "update"]);

    // Deletar um catálogo
    Route::delete("/{id}", [CatalogosController::class, "destroy"]);

    // Visualizar os itens do catálogo selecionado (mantendo sua rota original)
    Route::get("/itens/{id}", [
      ItensCatalogoController::class,
      "visualizarItensCatalogo",
    ]);
  });

  Route::prefix("/lider")->group(function () {
    /**
     * visualizar equipe
     * email com dados de exemplo: paulo.henrique@example.com
     * senha: senha123
     */
    Route::get("/equipe", [LiderController::class, "visualizarEquipe"]);

    /**
     * pegar desempenho da equipe
     */
    Route::get("/equipe/desempenho", [
      LiderController::class,
      "visualizarDesempenho",
    ]);
  });

  Route::prefix("/pedido")->group(function () {
    /**
     * visualizar um pedido especifico
     */
    Route::get("/{pedido}", [PedidosController::class, "visualizarPedido"]);

    /**
     * editar pedido
     */
    Route::put("/{pedido}", [PedidosController::class, "atualizarPedido"]);

    /**
     * apagar pedido
     */
    Route::delete("/{id}", [PedidosController::class, "cancelarPedido"]);
  });
  //exibir itens selecionados
  Route::get("/itens/{id}", [
    ItensCatalogoController::class,
    "visualizarItens",
  ]);

  Route::prefix("/produto")->controller(ProdutosController::class)->group(function () {
    Route::get("/", "index");
    Route::post("/", "store");
    Route::get("/{id}", "show");
    Route::put("/{id}", "update");
    Route::delete("/{id}", "destroy");
  });
});
