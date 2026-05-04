<?php

namespace App\Http\Controllers;

use App\Http\Requests\PedidoRequest;
use App\Models\pedidos;
use App\Services\PedidosService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidosController extends Controller
{
  protected $pedidosService;

  public function __construct(PedidosService $pedidosService)
  {
    $this->pedidosService = $pedidosService;
  }
  /**
   * pegar dados de um pedido pelo id
   */
  public function visualizarPedido($id)
  {
    $resultado = $this->pedidosService->trazerPedidoPorId($id);

    return response()->json($resultado);
  }

  /**
   * atualizar pedido do usuario
   */
  public function atualizarPedido(PedidoRequest $request, $id)
  {
    $dadosValidados = $request->validated();
    $resultado = $this->pedidosService->atualizarPedido($id, $dadosValidados);

    return response()->json($resultado);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function cancelarPedido($id)
  {
    $resultado = $this->pedidosService->excluirPedido($id);

    return response()->json($resultado);
  }
  /**
   * Criar um novo pedido
   */
  public function store(PedidoRequest $request)
  {
    // O PedidoRequest já faz a validação dos dados (itens, cliente_id, etc)
    $dadosValidados = $request->validated();

    $resultado = $this->pedidosService->criarPedido($dadosValidados);

    // Retorna 201 (Created) em caso de sucesso
    return response()->json(
      $resultado,
      $resultado["status"] === "success" ? 201 : 400
    );
  }

  /**
   * Gerar o link de rastreio/visualização do pedido pelo ID
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
      return response()->json(
        [
          "status" => "error",
          "mensagem" => $e->getMessage(),
        ],
        404
      );
    }
  }

  /**
   * Exibe a página personalizada do pedido para o cliente final (Pública)
   */
  public function exibirPedidoCliente($uuid)
  {
    // Busca o pedido pelo UUID com os itens e o nome do produto
    $pedido = \App\Models\pedidos::where("uuid", $uuid)
      ->with(["itensPedidos.produto"]) // Certifique-se que a relação existe no Model
      ->firstOrFail(); // Se não achar o UUID, dá erro 404 automaticamente

    return view("cliente.pedido_visualizacao", compact("pedido"));
  }
}
