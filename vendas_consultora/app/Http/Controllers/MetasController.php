<?php

namespace App\Http\Controllers;

use App\Http\Requests\MetaRequest;
use App\Models\metas;
use App\Services\MetaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MetasController extends Controller
{
    protected $metaService;

    public function __construct(MetaService $metaService)
    {
        $this->metaService = $metaService;
    }

public function listarPendentesConfiguracao(Request $request)
{
    // O ideal é que o MetasController use um MetasService, 
    // mas seguindo sua lógica, podemos chamar o service especializado
    $resultado = $this->metaService->consultorasSemMetaMesAtual($request);

    return response()->json($resultado);
}
    /**
     * Exibe a tela de definição de metas individuais.
     */
    public function index()
    {
        // Aqui você pode carregar dados iniciais se precisar, 
        // como a lista de membros da equipe para o Alpine.js consumir.
        
        return view('lider.configuracaoMeta'); 
        // Certifique-se que o arquivo está em: resources/views/metas/configuracao.blade.php
    }
    public function metaAtual() {

        $idUsuario = Auth::id();
        $meta = $this->metaService->metaUsuario($idUsuario);

        if (!$meta) {
            return response()->json(['status' => 'erro', 'message' => 'Nenhuma meta ativa'], 404);
        }

        return response()->json([
            'status' => 'sucesso',
            'data' => $meta->valor_meta // Agora funciona perfeitamente!
        ]);
    }

    public function progressoMeta() {
        $idUsuario = Auth::id();
        $progresso = $this->metaService->progressoMeta($idUsuario);
        return response()->json([
            'status' => 'sucesso',
            'data' => $progresso
        ]);
    }

    /**
     * Atribuir meta para consultora
     * -> atribui uma nova meta ativa para a consultora
     */

    public function atribuirMeta(MetaRequest $request, $idConsultora) {
        $dados = $request->validated();
        $resultado = $this->metaService->criarMeta($idConsultora, $dados);
        
        return response()->json($resultado);
    }

    /**
     * Historico de meta e progresso atual das consultoras
     */
    public function historicoMetaProgresso () {
        $resultado = $this->metaService->pegarHistoricoMetaProgresso();

        return response()->json($resultado);
    }
}
