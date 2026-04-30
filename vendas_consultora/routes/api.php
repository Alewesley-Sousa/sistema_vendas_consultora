<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    CatalogosController,
    ClientesController,
    ComissoesController,
    DevolucoesController,
    EstoquesController,
    HistoricoComissoesController,
    ItensCatalogoController,
    LiderController,
    MetasController,
    ProdutosController,
    PedidosController,
    UsuariosController
};

Route::middleware("auth:sanctum")->group(function () {

    // --- COMISSÕES ---
    Route::prefix("comissao")->controller(ComissoesController::class)->group(function () {
        Route::get("/", "visualizar");
        Route::get("/solicitar", "solicitarComissao");
        Route::get("/pendentes", "listarPendentes");
        Route::post("/processar/{id}", "processarSolicitacao");
        Route::get("/historico", [HistoricoComissoesController::class, "visualizarHistorico"]);
    });

    // --- METAS ---
    Route::prefix("meta")->controller(MetasController::class)->group(function () {
        Route::get("/", "metaAtual");
        Route::get("/progresso", "progressoMeta");
        Route::get("/historico", "historicoMetaProgresso");
        Route::post("/atribuir/{id}", "atribuirMeta");
    });

    // --- CLIENTES ---
    Route::prefix("cliente")->controller(ClientesController::class)->group(function () {
        Route::post("/", "cadastrarCliente");
        Route::get("/{cliente}", "exibir");
        Route::put("/{cliente}", "atualizarDados");
        Route::delete("/{id}", "destroy");
    });

    // --- USUÁRIOS ---
    Route::prefix("usuario")->controller(UsuariosController::class)->group(function () {
Route::post("/", "cadastrarUsuario");
    
    // 1º: Rotas de texto fixo (específicas)
    Route::get('/pre-cadastros', "listarPreCadastros");
    
    // 2º: Rotas com parâmetros (genéricas)
    Route::get("/{usuario}", "exibirUsuario");
    Route::put("/{usuario}", "atualizarUsuario");
    Route::post('/{id}/aprovacao', "aprovarOuRecusar");
    });

    // --- CATÁLOGOS E ITENS ---
    Route::prefix("catalogos")->group(function () {
        Route::controller(CatalogosController::class)->group(function () {
            Route::get('/', 'listar');
            Route::post('/', 'cadastrar');
            Route::get('/{id}', 'exibir');
            Route::put('/{id}', 'atualizar');
            Route::delete('/{id}', 'excluir');
        });

        Route::controller(ItensCatalogoController::class)->group(function () {
            Route::get("/{id}/itens", "visualizarItensCatalogo"); // Itens de um catálogo
            Route::get("/itens/{id}", "visualizarItens");         // Ver item específico
            Route::post("/itens", "store");             // Adicionar item a um catálogo
            Route::put("/itens/{id}", "update");        // Editar preço/estoque de um item no catálogo
            Route::delete("/itens/{id}", "destroy");
        });
    });

    // --- PEDIDOS ---
    Route::prefix("pedido")->controller(PedidosController::class)->group(function () {
        Route::get("/{pedido}", "visualizarPedido");
        Route::put("/{pedido}", "atualizarPedido");
        Route::delete("/{id}", "cancelarPedido");
    });

    // --- PRODUTOS ---
    Route::prefix("produto")->controller(ProdutosController::class)->group(function () {
        Route::get("/", "index");
        Route::post("/", "store");
        Route::get("/{id}", "show");
        Route::put("/{id}", "update");
        Route::delete("/{id}", "destroy");
    });

    // --- ESTOQUE ---
    Route::prefix("estoque")->controller(EstoquesController::class)->group(function () {
        Route::get("/", "index");
        Route::post("/", "store");
        Route::get("/{id}", "show");
        Route::put("/{id}", "update");
        Route::delete("/{id}", "destroy");
    });

    // --- DEVOLUÇÕES ---
    Route::prefix("devolucao")->controller(DevolucoesController::class)->group(function () {
        Route::get("/pendentes", "pendentes");
        Route::post("/solicitar", "solicitar");
        Route::post("/aprovar/{id}", "aprovar");
        Route::post("/rejeitar/{id}", "rejeitar");
    });

    // --- RELATÓRIOS ---
    Route::prefix("relatorios")->controller(\App\Http\Controllers\RelatorioController::class)->group(function () {
        Route::get("/vendas-pessoais", "vendasPessoais");
        Route::get("/comissoes-detalhadas", "comissoesDetalhadas");
        Route::get("/desempenho-rede", "desempenhoRede");
        Route::get("/ranking-consultoras", "rankingConsultoras");
        Route::get("/analise-produtos", "analiseProdutos");
        Route::get("/metas-bonificacoes", "metasBonificacoes");
        Route::get("/retencao-clientes", "retencaoClientes");
        Route::get("/crescimento-rede", "crescimentoRede");
        Route::get("/financeiro-consolidado", "financeiroConsolidado");
    });

    // --- LIDERANÇA / EQUIPE ---
    Route::prefix("lider")->controller(LiderController::class)->group(function () {
        Route::get("/equipe", "visualizarEquipe");
        Route::get("/equipe/desempenho", "visualizarDesempenho");
    });

});
