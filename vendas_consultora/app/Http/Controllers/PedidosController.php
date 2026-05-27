<?php

namespace App\Http\Controllers;

use App\Http\Requests\PedidoRequest;
use App\Models\pedidos;
use App\Services\PedidosService;
use App\Services\FinanceiroService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidosController extends Controller
{
    protected $pedidosService;
    protected $financeiroService;

    public function __construct(PedidosService $pedidosService, FinanceiroService $financeiroService)
    {
        $this->financeiroService = $financeiroService;
        $this->pedidosService = $pedidosService;
    }

    /**
     * Exibe a página inicial de pedidos da equipe para o Líder
     */
    public function index() 
    {
        return view("lider.pedidos-equipe");
    }

    /**
     * Método chamado pelo botão "Confirmar Pagamento" do Checkout
     */
    public function processarPagamentoCheckout($id)
    {
        // Chama o método no FinanceiroService (que cuida de estoque, comissões e pontos)
        $resultado = $this->financeiroService->confirmarPagamentoSimulado($id);

        if ($resultado['status'] === 'success') {
            $pedido = pedidos::find($id);
            
            // Redireciona para a página de rastreio do cliente usando o UUID
            return redirect()->route('pedido.visualizar.cliente', ['uuid' => $pedido->uuid])
                             ->with('success', $resultado['mensagem']);
        }

        // Se der erro (ex: falta de estoque), volta para o checkout com a mensagem
        return back()->with('error', $resultado['mensagem']);
    }

    /**
     * Página pública para o cliente final acompanhar o status (Aba que criamos)
     */
    public function visualizarPedidoCliente($uuid)
    {
        // Busca pelo UUID trazendo todas as relações que a tela de rastreio precisa
        $pedido = pedidos::with(['clientes', 'itensPedidos.itemCatalogo.produto', 'status'])
            ->where('uuid', $uuid)
            ->firstOrFail();

        // Aponta para a view nova que criamos: pedidos/rastreio.blade.php
        return view("pedidos.rastreio", compact("pedido"));
    }

    /**
     * Lista pedidos para o painel do Líder (usado pelo AlpineJS)
     */
    public function listar(Request $request)
    {
        try {
            $liderId = Auth::id();

            if ($request->wantsJson() || $request->ajax()) {
                $pedidos = $this->pedidosService->listarPedidosPorEquipe($liderId);
                return response()->json($pedidos);
            }

            return view('lider.pedidos-equipe');
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Buscar dados de um pedido específico por ID
     */
    public function visualizarPedido($id)
    {
        $resultado = $this->pedidosService->trazerPedidoPorId($id);
        return response()->json($resultado);
    }

    /**
     * Atualizar dados de um pedido
     */
    public function atualizarPedido(PedidoRequest $request, $id)
    {
        $dadosValidados = $request->validated();
        $resultado = $this->pedidosService->atualizarPedido($id, $dadosValidados);
        return response()->json($resultado);
    }

    /**
     * Cancelar um pedido (Excluir)
     */
    public function cancelarPedido($id)
    {
        $resultado = $this->pedidosService->excluirPedido($id);
        return response()->json($resultado);
    }

    /**
     * Criar um novo pedido via API/Request
     */
    public function store(PedidoRequest $request)
    {
        $dadosValidados = $request->validated();
        $resultado = $this->pedidosService->criarPedido($dadosValidados);

        return response()->json(
            $resultado,
            $resultado["status"] === "success" ? 201 : 400
        );
    }

    /**
     * Exibe a página de Checkout (com o resumo da Glow Cosmetics)
     */
    public function exibirPaginaPagamento($uuid)
    {
        $pedido = pedidos::with(['itensPedidos.itemCatalogo.produto', 'clientes'])
            ->where('uuid', $uuid)
            ->firstOrFail();

        return view('pagamentos.checkout', compact('pedido'));
    }

    /**
     * Gera o link público de visualização/rastreio
     */
    public function gerarLink($id)
    {
        try {
            $link = $this->pedidosService->obterLinkPorId($id);

            return response()->json([
                "status" => "success",
                "link" => $link,
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => "error",
                "mensagem" => $e->getMessage(),
            ], 404);
        }
    }
}