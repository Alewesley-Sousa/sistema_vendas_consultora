<?php

namespace App\Http\Controllers;

use App\Services\UsuarioService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
class LiderController extends Controller
{
    protected $liderService;

    public function __construct(protected UsuarioService $service)
    {
        $this->liderService = $service;
    }
    
    /**
     * Visualizar equipe
     * @param int $id
     */
    public function visualizarEquipe() {
        $resultado = $this->liderService->consultorasVinculadas();

        return response()->json($resultado);
    }

    /**
     * Visualizar desempenho da equipe
     */
    public function visualizarDesempenho() {
        $resultado = $this->liderService->desempenhoConsultoras();

        return response()->json($resultado);
    }
    
    /**
 * Avalia se a consultora atende aos requisitos para se tornar Líder
 * @param int $consultoraId
 * @return bool
 */
/**
 * Verifica se a consultora atende aos requisitos para se tornar Líder
 * @param int $id
 */
public function verificarRequisitos() 
{
	$usuarioId = Auth::user();
    // O Controller pergunta ao Service
    $resultado = $this->liderService->checarUpgradeCarreira($usuarioId->id);

    return response()->json([
        'atende_requisitos' => $resultado['atende_requisitos'],
        'dados' => $resultado['dados'],
        'mensagem' => $resultado['mensagem']
    ]);
}

/**
 * Executa a mudança de cargo da consultora logada
 */
public function mudarCargo()
{
    try {
        $usuarioId = Auth::id();

        if (!$usuarioId) {
            return response()->json(['status' => 'error', 'mensagem' => 'Usuário não autenticado.'], 401);
        }

        $resultado = $this->liderService->promoverParaLider($usuarioId);

        return response()->json($resultado);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'mensagem' => 'Erro interno: ' . $e->getMessage()
        ], 500);
    }
}


}
