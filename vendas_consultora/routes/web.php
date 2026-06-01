<?php

use App\Http\Controllers\MetasController;
use App\Http\Controllers\Auth\AutenticacaoController;
use App\Http\Controllers\Auth\ResetarSenhaController;
use App\Http\Controllers\CatalogosController;
use App\Http\Controllers\LiderController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\HistoricoComissoesController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\PromocoesController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

// Redirecionamento Inicial conforme o Cargo
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();

        return match ($user->cargo) {
            'distribuidora' => redirect()->route('distribuidora.dashboard'),
            'lider'         => redirect()->route('lider.dashboard'),
            'consultora'    => redirect()->route('consultora.dashboard'),
            default         => redirect()->route('login'),
        };
    }

    return redirect()->route('login');
});

// =========================================================================
//  ROTAS DO FLUXO DE PEDIDOS E CLIENTE (URLs ÚNICAS E CORRIGIDAS)
// =========================================================================

// 1. Página de Rastreio (A linha do tempo que criamos por último)
Route::get('/pedido/rastreio/{uuid}', [PedidosController::class, 'visualizarPedidoCliente'])
    ->name('pedido.visualizar.cliente');


// 2. Página de Checkout / Pagamento (Mudamos a URL para /pagamento/ para não dar conflito)
Route::get('/pedido/pagamento/{uuid}', [PedidosController::class, 'exibirPaginaPagamento'])
    ->name('pedido.rastreio');

Route::post('/pedido', [PedidosController::class, 'store'])->name('api.pedido.store');
// =========================================================================
//  AUTENTICAÇÃO
// =========================================================================
Route::get('/login', [AutenticacaoController::class, 'showLogin'])->name('login');
Route::post('/login', [AutenticacaoController::class, 'login']);
Route::post('/login/token', [AutenticacaoController::class, 'geraToken']);
Route::post('/logout', [AutenticacaoController::class, 'logout'])->name('logout');

// =========================================================================
//  DASHBOARDS PROTEGIDOS
// =========================================================================
Route::get('/distribuidora/dashboard', fn() => view('distribuidora.dashboard'))
   ->middleware(['auth', 'cargo:distribuidora'])
   ->name('distribuidora.dashboard');

Route::get('/lider/dashboard', fn() => Inertia::render('Consultora/Dashboard'))
    ->middleware(['auth', 'cargo:lider'])
    ->name('lider.dashboard');

Route::get('/consultora/dashboard', fn() => Inertia::render('Consultora/Dashboard'))
    ->middleware(['auth', 'cargo:consultora'])
    ->name('consultora.dashboard');

// =========================================================================
//  RECUPERAÇÃO DE SENHA
// =========================================================================
Route::get('/recuperar-senha', [ResetarSenhaController::class, 'formularioRecuperacao'])->name('senha-formulario');
Route::post('/recuperar-senha', [ResetarSenhaController::class, 'enviarLinkResetar'])->name('senha-email');
Route::get('/resetar-senha/{token}', [ResetarSenhaController::class, 'formularioAtualizarSenha'])->name('senha.resetar');
Route::post('/resetar-senha', [ResetarSenhaController::class, 'atualizarSenha'])->name('senha.atualizar');

// =========================================================================
//  GESTÃO E RELATÓRIOS
// =========================================================================
Route::get('/comissao/historico', [HistoricoComissoesController::class, 'historicoComissao'])->name('consultoraHistorico');

Route::get('/cliente/cadastro', [ClientesController::class, 'formulario'])->name('cliente.cadastrar')->middleware(['auth', 'cargo:consultora']);
Route::get('/cliente/edicao/{id}', [ClientesController::class, 'formulario'])->name('cliente.editar')->middleware(['auth']);
Route::get('/clientes', [ClientesController::class, 'listar'])->name('cliente.listar')->middleware(['auth', 'cargo:distribuidora']);

Route::get('/usuario/cadastro', [UsuariosController::class, 'formulario'])->name('usuario.cadastrar')->middleware(['auth', 'cargo:consultora']);
Route::get('/usuario/edicao/{id}', [UsuariosController::class, 'formulario'])->name('usuario.editar')->middleware(['auth', 'cargo:distribuidora']);

Route::get('/catalogo', [CatalogosController::class, 'index'])->middleware('auth')->name('catalogo.visualizar');
Route::get('/rede/arvore', [RelatorioController::class, 'viewArvore'])->middleware('auth');

Route::get('/lider/upgrade', [LiderController::class, 'verificarRequisitos']);
Route::get('/lider/mudarCargo', [LiderController::class, 'mudarCargo']);
Route::get('/relatorios/desempenho-equipe', [RelatorioController::class, 'desempenho'])->name('relatorios.desempenho');
Route::get('/metas/configuracao-equipe', [MetasController::class, 'index'])->name('metas.configuracao')->middleware('auth');
Route::get('/pedidos/equipe', [PedidosController::class, 'index'])->middleware('auth');

// =========================================================================
//  PAINEL DA DISTRIBUIDORA
// =========================================================================
Route::prefix('distribuidora')->name('distribuidora.')->group(function () {
    Route::get('/produtos', fn() => view('distribuidora.produtos'))->name('produtos');
    Route::get('/catalogos', fn() => view('distribuidora.catalogos'))->name('catalogos');
    Route::get('/estoques', fn() => view('distribuidora.estoques'))->name('estoques');
    Route::get('/promocoes', [PromocoesController::class, 'index'])->name('promocoes');
    Route::get('/solicitacoes', fn() => view('distribuidora.solicitacoes'))->name('solicitacoes');
    Route::get('/relatorios', fn() => view('distribuidora.relatorios'))->name('relatorios');
    Route::get('/categorias', fn() => view('distribuidora.categorias'))->name('categorias');
});
