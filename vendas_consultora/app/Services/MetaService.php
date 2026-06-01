<?php

namespace App\Services;

use App\Models\metas;
use App\Models\pedidos;
use App\Models\usuarios;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MetaService
{
	
	// No UsuarioService.php ou MetasService.php

/**
 * Retorna todas as consultoras do líder, priorizando no topo as que 
 * não possuem meta definida para o mês/ano atual.
 */
public function consultorasSemMetaMesAtual(Request $request)
{
    try {
        $lider = Auth::user();
        $mesAtual = now()->month;
        $anoAtual = now()->year;
        $busca = $request->query('search');

        // Seleção explícita de campos evita problemas no mapeamento do Eloquent com selectSub
        $query = usuarios::select('id', 'nome', 'consultora_id', 'cargo', 'status_id')
            ->where('consultora_id', $lider->id)
            ->where('cargo', 'consultora')
            ->where('status_id', 1);

        // Subquery da contagem
        // No seu Controller:
		$query->selectSub(function ($q) use ($mesAtual, $anoAtual) {
		    $q->from('metas') // <--- Alterado de 'metas_consultoras' para 'metas'
		      ->whereColumn('metas.consultora_id', 'usuarios.id') // <-- Ajuste aqui também se a coluna for usuario_id
		      ->whereMonth('data_referencia', $mesAtual)
		      ->whereYear('data_referencia', $anoAtual)
		      ->selectRaw('count(*)');
		}, 'possui_meta_no_mes');


        // Ordenação prioritária
        $query->orderByRaw('(possui_meta_no_mes > 0) ASC')
              ->orderBy('nome', 'ASC');

        $consultoras = $query->paginate(10);

        // Mutação da Collection convertendo para Array seguro
        $consultoras->getCollection()->transform(function ($consultora) {
            // Convertendo para int para garantir a comparação segura
            $totalMetas = (int) $consultora->possui_meta_no_mes;
            $consultora->status_meta = $totalMetas === 0 ? 'Pendente' : 'Definida';
            return $consultora;
        });

        return [
            'status' => 'success',
            'data' => $consultoras
        ];

    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'mensagem' => $e->getMessage()
        ];
    }
}




    /**
     * Pega o registro da meta ativa (status 3) do usuário.
     */
    public function metaUsuario($idUsuario)
    {
        return metas::where('consultora_id', $idUsuario)
            ->where('status_id', 3)
            ->first();
    }

    /**
     * Calcula o percentual de atingimento da meta ativa.
     */
    public function progressoMeta($idConsultora = null)
    {
        $idUsuario = $idConsultora;
        // Obtém a meta ativa usando o método da própria classe
        $metaAtual = $this->metaUsuario($idUsuario);

        if (!$metaAtual) {
            return 0;
        }

        // Garante que trabalhamos com Carbon (Certifique-se de ter o cast no Model Metas)
        $dataReferencia = Carbon::parse($metaAtual->data_referencia);
        $mes = $dataReferencia->month;
        $ano = $dataReferencia->year;
        $valorMeta = (float) $metaAtual->valor_meta;

        // Soma pedidos válidos (Não pendentes e não cancelados)
        $totalVendido = (float) pedidos::where('usuario_id', $idUsuario)
            ->whereMonth('created_at', $mes)
            ->whereYear('created_at', $ano)
            ->whereNotIn('status_id', [1, 7])
            ->sum('valor_total');

        if ($valorMeta <= 0) {
            return 0;
        }

        $progresso = ($totalVendido / $valorMeta) * 100;

        return round($progresso, 2);
    }

/**
 * Cria uma nova meta para uma consultora da rede.
 */
public function criarMeta($idConsultora, $dados)
{
    try {
        return DB::transaction(function () use ($idConsultora, $dados) {
            $lider = Auth::user();

            // 1. Verificação de Cargo
            if ($lider->cargo !== 'lider') {
                throw new Exception('Acesso negado! Somente líderes podem atribuir metas.');
            }

            // 2. Busca a consultora (Usando o model plural conforme seu padrão)
            // IMPORTANTE: Verifique se a coluna é 'consultora_id' ou 'lider_id'
            $consultora = usuarios::where('id', $idConsultora)
                ->where('consultora_id', $lider->id) 
                ->first();

            if (!$consultora) {
                throw new Exception('Consultora não encontrada ou não pertence à sua rede.');
            }

            // 3. Tratamento da Data com Carbon
            // Se vier "2026-05", o Carbon entende. startOfMonth() garante 2026-05-01
            $dataRef = Carbon::parse($dados['data_referencia'])->startOfMonth();

            // 4. Verificação de Meta Existente (Mesmo Mês/Ano)
            // Usamos whereDate ou Month/Year para evitar falsos negativos
            $metaExistente = metas::where('consultora_id', $idConsultora)
                ->whereYear('data_referencia', $dataRef->year)
                ->whereMonth('data_referencia', $dataRef->month)
                ->first();

            if ($metaExistente) {
                $statusMsg = ($metaExistente->status_id == 3) ? 'ativa' : 'registrada';
                throw new Exception("Já existe uma meta {$statusMsg} para " . $dataRef->format('m/Y'));
            }

            // 5. Criação da Meta
            metas::create([
                'consultora_id'   => $idConsultora,
                'lider_id'        => $lider->id,
                'valor_meta'      => $dados['valor_meta'],
                'data_referencia' => $dataRef->toDateString(), // Formato Y-m-d
                'status_id'       => 3 // Ativa
            ]);

            return [
                'status'   => 'success',
                'mensagem' => "Meta de R$ " . number_format($dados['valor_meta'], 2, ',', '.') . " atribuída para {$consultora->nome}!"
            ];
        });
    } catch (Exception $e) {
        // Log para debug interno se necessário
        // Log::error($e->getMessage());
        
        return [
            'status'   => 'error',
            'mensagem' => $e->getMessage()
        ];
    }
}


    /**
     * Lista consultoras da rede com histórico de metas concluídas e progresso da meta atual.
     */
    public function pegarHistoricoMetaProgresso()
{
    try {
        $lider = Auth::user();

        // Garante que o model se chama 'usuarios' de acordo com a estrutura do seu projeto
        if ($lider->cargo !== 'lider') {
            throw new Exception('Acesso negado!');
        }

        $resultado = usuarios::where('consultora_id', $lider->id)
            ->select('nome', 'id', 'status_id')
            ->get()
            ->map(function ($consultora) {
                // Buscamos o valor real da meta atual usando o seu método interno existente
                $metaAtualValor = $this->metaUsuario($consultora->id);

                // Forçamos o retorno a ter exatamente a estrutura que o find() do Vue busca:
                // metaInfo?.metas_consultora?.[0]?.valor_meta
                $consultora->metas_consultora = [
                    [
                        'valor_meta' => $metaAtualValor ?? 0
                    ]
                ];

                // Mantém os seus outros dados caso outras telas usem
                $consultora->progressoMeta = $this->progressoMeta(true, $consultora->id);

                return $consultora;
            });

        return [
            'status' => 'success',
            'data'   => $resultado
        ];
    } catch (Exception $e) {
        return [
            'status'   => 'error',
            'mensagem' => 'Erro ao consultar o sistema: ' . $e->getMessage()
        ];
    }
}

}
