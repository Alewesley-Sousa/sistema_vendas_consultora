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
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();

        // Decide o dashboard conforme o cargo
        return match ($user->cargo) {
            'distribuidora' => redirect()->route('distribuidora.dashboard'),
            'lider'         => redirect()->route('lider.dashboard'),
            'consultora'    => redirect()->route('consultora.dashboard'),
            default         => redirect()->route('login'),
        };
    }

    return redirect()->route('login');
});

// pagina de login
Route::get('/login', [AutenticacaoController::class, 'showLogin'])->name('login');

// Processa o login
Route::post('/login', [AutenticacaoController::class, 'login']);

// cria o token
Route::post('/login/token', [AutenticacaoController::class, 'geraToken']);

// Processa o logout
Route::post('/logout', [AutenticacaoController::class, 'logout'])->name('logout');

// Rotas protegidas por cargo
Route::get('/distribuidora/dashboard', fn() => view('distribuidora.dashboard'))
   ->middleware(['auth', 'cargo:distribuidora'])
   ->name('distribuidora.dashboard');

Route::get('/lider/dashboard', fn() => view('lider.dashboard'))
    ->middleware(['auth', 'cargo:lider'])
    ->name('lider.dashboard');

Route::get('/consultora/dashboard', fn() => view('consultora.dashboard'))
    ->middleware(['auth', 'cargo:consultora'])
    ->name('consultora.dashboard');

Route::get('/recuperar-senha', [ResetarSenhaController::class, 'formularioRecuperacao'])->name('senha-formulario');

Route::post('/recuperar-senha', [ResetarSenhaController::class, 'enviarLinkResetar'])->name('senha-email');

Route::get('/resetar-senha/{token}', [ResetarSenhaController::class, 'formularioAtualizarSenha'])->name('senha.resetar');

Route::post('/resetar-senha', [ResetarSenhaController::class, 'atualizarSenha'])->name('senha.atualizar');

Route::get('/comissao/historico', [HistoricoComissoesController::class, 'historicoComissao'])->name('consultoraHistorico');

Route::get('/cliente/cadastro', [ClientesController::class, 'formulario'])->name('cliente.cadastrar')->middleware(['auth', 'cargo:consultora']);

Route::get('/cliente/edicao/{id}', [ClientesController::class, 'formulario'])->name('cliente.editar')->middleware(['auth']);

Route::get('/usuario/cadastro', [UsuariosController::class, 'formulario'])->name('usuario.cadastrar')->middleware(['auth', 'cargo:consultora']);

Route::get('/usuario/edicao/{id}', [UsuariosController::class, 'formulario'])->name('usuario.editar')->middleware(['auth', 'cargo:distribuidora']);

Route::get('/catalogo', [CatalogosController::class, 'index'])->middleware('auth')->name('catalogo.visualizar');

Route::get('/clientes', [ClientesController::class, 'listar'])->name('cliente.listar')->middleware(['auth', 'cargo:distribuidora']);

// Rota pública para o cliente visualizar o pedido via link/UUID
Route::get('/pedido/rastreio/{uuid}', [App\Http\Controllers\PedidosController::class, 'exibirPedidoCliente'])
    ->name('cliente.pedido.montado');

Route::get('/rede/arvore', [RelatorioController::class, 'viewArvore'])->middleware('auth');

Route::get('/lider/upgrade', [LiderController::class, 'verificarRequisitos']);
Route::get('/lider/mudarCargo', [LiderController::class, 'mudarCargo']);
Route::get('/relatorios/desempenho-equipe', [RelatorioController::class, 'desempenho'])
        ->name('relatorios.desempenho');
        

// Rota para a página de configuração de metas
Route::get('/metas/configuracao-equipe', [MetasController::class, 'index'])
    ->name('metas.configuracao')->middleware('auth');
Route::get('/pedidos/equipe', [PedidosController::class,
'index'])->middleware('auth');

Route::get('/pedido/rastreio/{uuid}', [PedidosController::class,
'exibirPaginaPagamento'])->name('pedido.rastreio');


Route::prefix('distribuidora')->name('distribuidora.')->group(function () {
    // ADICIONE ESTA LINHA:
    Route::get('/produtos', function () { return view('distribuidora.produtos'); })->name('produtos');
    Route::get('/catalogos', function () { return view('distribuidora.catalogos'); })->name('catalogos');
    Route::get('/estoques', function () { return view('distribuidora.estoques');
    })->name('estoques');
    Route::get('/promocoes', [PromocoesController::class,
    'index'])->name('promocoes');
    Route::get('/solicitacoes', fn() =>
    view('distribuidora.solicitacoes'))->name('solicitacoes');
    Route::get('/relatorios', fn() =>
    view('distribuidora.relatorios'))->name('relatorios');
    
});
