<?php

namespace App\Services;

use App\Models\usuarios;
use App\Models\pedidos;
use App\Services\LogService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\Auth;

/**
 * Service: UsuarioService
 * Autor: Alewesley-Sousa
 * Descrição: Gerencia toda a lógica de usuários, desde cadastros e logs até regras de upgrade.
 */
class UsuarioService
{
	protected $HistoricoComissaoService;

public function __construct(HistoricoComissaoService $service) {
        $this->HistoricoComissaoService = $service;
    }


  public function listar()
  {
    return usuarios::all();
  }

  public function atualizarRegistro($dados, $id)
  {
    DB::beginTransaction();

    try {
      $usuario = usuarios::findOrFail($id);
      $usuario->update($dados);

      DB::commit();

      return [
        "status" => "success",
        "mensagem" => "usuario atualizado com sucesso!",
      ];
    } catch (Exception $e) {
      DB::rollBack();

      return [
        "status" => "error",
        "mensagem" => "falha ao atualizar o usuario: " . $e->getMessage(),
      ];
    }
  }

       /**
     * Gera o desempenho detalhado das consultoras vinculadas
     */
    public function desempenhoConsultoras() 
    {
        // Obtém a Collection de consultoras
        $consultoras = $this->consultorasVinculadas(true);

        // Se por algum motivo não for uma Collection (ex: erro de permissão), retorna o erro
        if (!($consultoras instanceof \Illuminate\Support\Collection)) {
            return $consultoras; 
        }

        $resultado = $consultoras->map(function ($consultora) {
            // Agrupamento de Vendas por Mês/Ano (SQLite strftime)
            $totalVendido = pedidos::where('usuario_id', $consultora->id)
                ->whereNotIn('status_id', [1, 7])
                ->selectRaw("strftime('%m/%Y', created_at) as mes_ano, SUM(valor_total) as total_vendas")
                ->groupBy('mes_ano')
                ->orderBy('mes_ano', 'desc')
                ->get();

            // Contagem de Pedidos por Mês/Ano
            $totalPedidos = pedidos::where('usuario_id', $consultora->id)
                ->whereNotIn('status_id', [1, 7])
                ->selectRaw("strftime('%m/%Y', created_at) as mes_ano, COUNT(id) as total_pedidos")
                ->groupBy('mes_ano')
                ->orderBy('mes_ano', 'desc')
                ->get();

            // Busca comissão via Service externo
            $comissao = $this->HistoricoComissaoService->comissaoPorMes($consultora->id);

            // Injeta os dados no objeto da consultora
            $consultora->TotalVendido = $totalVendido;
            $consultora->TotalPedidos = $totalPedidos;
            $consultora->comissao = $comissao;

            return $consultora;
        });

        return [
            'status' => 'success',
            'data' => $resultado
        ];
    }
    
    /**
     * Retorna consultoras vinculadas ao usuário logado
     */
    public function consultorasVinculadas($reutilizavel = false)
    {
        try {
            $usuario = Auth::user();

            // CORREÇÃO: Verifica se o cargo NÃO é líder E NÃO é consultora
            if (!in_array($usuario->cargo, ['lider', 'consultora'])) {
                throw new Exception("Acesso negado! Seu cargo é: {$usuario->cargo}");
            }

            // Busca as consultoras onde o consultora_id é o ID do líder logado
            $resultado = usuarios::where('cargo', 'consultora')
                ->where('consultora_id', $usuario->id)
                ->get();

            // Se for para uso interno (map), retorna a Collection pura
            if ($reutilizavel === true) {
                return $resultado;
            }

            return [
                'status' => 'success',
                'data' => $resultado
            ];

        } catch (Exception $e) {
            $errorResponse = [
                'status' => 'error',
                'mensagem' => $e->getMessage()
            ];

            // Se der erro mas o sistema espera uma Collection, retorna Collection vazia para não quebrar o map()
            return $reutilizavel ? collect([]) : $errorResponse;
        }
    }
    
    
    
  public function destroy(int $id): bool
  {
    try {
      return DB::transaction(function () use ($id) {
        $usuario = usuarios::findOrFail($id);
        return $usuario->delete();
      });
    } catch (Exception $e) {
      throw new Exception("Erro ao excluir usuário: " . $e->getMessage());
    }
  }

  public function visualizarSolicitacoesDeNovasConsultora()
  {
    try {
      $usuarios = usuarios::where("status_id", 3)->get();

      if ($usuarios->isEmpty()) {
        throw new \Exception("Não há nenhum pré cadastro.");
      }

      return [
        "status" => "success",
        "dados" => $usuarios,
      ];
    } catch (\Exception $e) {
      return [
        "status" => "error",
        "mensagem" => "problema na busca de consultoras: " . $e->getMessage(),
      ];
    }
  }

  /**
   * @param int $decisao 0 (recusar) e 1 (aprovar)
   */
  public function aprovarOuRecusarCadastro(int $id, int $decisao)
  {
    DB::beginTransaction();
    try {
      $usuario = usuarios::where("id", $id)->firstOrFail();

      if ($usuario->status_id != 3) {
        throw new Exception(
          "Status atual inválido para esta ação! Status: " . $usuario->status_id
        );
      }

      $authUser = Auth::user();
      $nomeUsuario = $usuario->nome;

      if ($decisao == 1) {
        $usuario->update(["status_id" => 1]);
        $acao = "aprovar cadastro";
        $descricao = "{$authUser->nome} aprovou cadastro de {$nomeUsuario}";
      } else {
        $usuario->forceDelete();
        $acao = "recusar cadastro";
        $descricao = "{$authUser->nome} recusou/deletou pré-cadastro de {$nomeUsuario}";
      }

      LogService::registrarAcao($acao, "usuarios", $id, $descricao);

      DB::commit();

      return [
        "status" => "success",
        "mensagem" =>
          $decisao == 1
            ? "Cadastro aprovado com sucesso!"
            : "Pré-cadastro deletado com sucesso!",
      ];
    } catch (Exception $e) {
      DB::rollBack();
      return [
        "status" => "error",
        "mensagem" => "Erro ao processar: " . $e->getMessage(),
      ];
    }
  }

  public function registrarUsuario($dados)
  {
    DB::beginTransaction();
    $usuarioAutenticado = Auth::user();

    try {
      // se não for distribuidora vai apenas criar um pre cadastro
      if ($usuarioAutenticado->cargo !== 'distribuidora') {
        $ehPreCadastro = true;
      } else {
        $ehPreCadastro = false;
      }

      $statusId = $ehPreCadastro ? 3 : $dados->status ?? 1;

      $usr = usuarios::create([
        "nome" => $dados->nome,
        "cargo" => $ehPreCadastro ? "consultora" : $dados->cargo,
        "email" => $dados->email,
        "telefone" => $dados->telefone,
        "senha" => Hash::make($dados->senha),
        "cep" => $dados->cep,
        "cpf" => $dados->cpf,
        "consultora_id" => in_array($usuarioAutenticado->cargo, [
          "consultora",
          "lider",
        ])
          ? $usuarioAutenticado->id
          : null,
        "status_id" => $statusId,
      ]);

      $descricao = $ehPreCadastro
        ? "Consultor(a) {$usuarioAutenticado->nome} realizando pré-cadastro de {$usr->nome}."
        : "Usuário(a) {$usuarioAutenticado->nome} realizando cadastro direto de {$usr->nome}.";

      LogService::registrarAcao(
        "cadastrar novo usuario",
        "usuarios",
        $usr->id,
        $descricao
      );

      DB::commit();

      $tipoMsg = $statusId === 3 ? "Pré-cadastro" : "Cadastro";

      return [
        "status" => "success",
        "mensagem" => "{$tipoMsg} realizado com sucesso!",
      ];
    } catch (Exception $e) {
      DB::rollBack();
      return [
        "status" => "error",
        "mensagem" => "Falha ao cadastrar o usuario: " . $e->getMessage(),
      ];
    }
  }

  /**
   * Regra de negócio para promoção baseada no desempenho do mês atual
   * Utilizado pela "Div Mentora" no Front-end.
   */
  public function checarUpgradeCarreira(int $consultoraId): array
  {
    // 1. Calcular total de vendas do MÊS e ANO ATUAIS
    $totalVendas = pedidos::where("usuario_id", $consultoraId)
      ->whereNotIn("status_id", [1, 7])
      ->whereMonth("created_at", now()->month)
      ->whereYear("created_at", now()->year)
      ->sum("valor_total");

    // 2. Contar consultoras ativas vinculadas (usando a coluna consultora_id da sua migration)
    $ativas = usuarios::where("consultora_id", $consultoraId)
      ->where("status_id", 1)
      ->count();

    $podePromover = $totalVendas >= 5000 && $ativas >= 3;

    return [
      "atende_requisitos" => $podePromover,
      "dados" => [
        "total_vendas" => (float) $totalVendas,
        "consultoras_ativas" => $ativas,
      ],
      "mensagem" => $podePromover
        ? "Requisitos atingidos."
        : "Ainda faltam metas para atingir o cargo de Líder este mês.",
    ];
  }

  /**
   * Efetiva a promoção da consultora para Líder
   */
  public function promoverParaLider(int $consultoraId)
  {
    DB::beginTransaction();

    try {
      // 1. Verifica novamente os requisitos (Segurança de Backend)
      $checagem = $this->checarUpgradeCarreira($consultoraId);

      if (!$checagem["atende_requisitos"]) {
        throw new Exception("Requisitos insuficientes para promoção.");
      }

      $usuario = usuarios::findOrFail($consultoraId);

      // 2. Atualiza o cargo
      $usuario->update([
        "cargo" => "lider",
      ]);

      // 3. Registra o Log da promoção
      LogService::registrarAcao(
        "upgrade de cargo",
        "usuarios",
        $consultoraId,
        "Usuária {$usuario->nome} foi promovida a Líder por atingir as metas mensais."
      );

      DB::commit();

      return [
        "status" => "success",
        "mensagem" => "Parabéns! Agora você é oficialmente uma Líder Glow!",
      ];
    } catch (Exception $e) {
      DB::rollBack();
      return [
        "status" => "error",
        "mensagem" => "Erro ao processar promoção: " . $e->getMessage(),
      ];
    }
  }
}
