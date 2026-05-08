<?php

namespace App\Services;

use App\Models\metas;
use App\Models\pedidos;
use App\Models\usuarios;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MetaService
{
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

                if ($lider->cargo !== 'lider') {
                    throw new Exception('Acesso negado! Somente líderes podem atribuir metas.');
                }

                // Busca a consultora garantindo que ela pertence à rede do líder logado
                $consultora = usuarios::where('id', $idConsultora)
                    ->where('consultora_id', $lider->id)
                    ->first();

                if (!$consultora) {
                    throw new Exception('Consultora não encontrada ou não pertence à sua rede.');
                }

                // Normaliza a data para o primeiro dia do mês (Evita duplicidade no mesmo mês)
                $dataRef = Carbon::parse($dados['data_referencia'])->startOfMonth();

                // 1. Verifica se JÁ EXISTE uma meta ativa (Status 3)
                $temMetaAtiva = metas::where('consultora_id', $idConsultora)
                    ->where('status_id', 3)
                    ->exists();

                if ($temMetaAtiva) {
                    throw new Exception('Esta consultora já possui uma meta ativa no momento.');
                }

                // 2. Verifica se JÁ EXISTE meta cadastrada para este MÊS específico (Independente do status)
                $metaNoMes = metas::where('consultora_id', $idConsultora)
                    ->whereYear('data_referencia', $dataRef->year)
                    ->whereMonth('data_referencia', $dataRef->month)
                    ->exists();

                if ($metaNoMes) {
                    throw new Exception('Já existe uma meta registrada para ' . $dataRef->format('m/Y'));
                }

                $meta = metas::create([
                    'consultora_id'   => $idConsultora,
                    'lider_id'        => $lider->id,
                    'valor_meta'      => $dados['valor_meta'],
                    'data_referencia' => $dataRef->format('Y-m-d'),
                    'status_id'       => 3 // Ativa
                ]);

                return [
                    'status'   => 'success',
                    'mensagem' => "Meta de R$ " . number_format($dados['valor_meta'], 2, ',', '.') . " atribuída com sucesso para {$consultora->nome}!"
                ];
            });
        } catch (Exception $e) {
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

            if ($lider->cargo !== 'lider') {
                throw new Exception('Acesso negado!');
            }

            $resultado = usuarios::where('consultora_id', $lider->id)
                ->select('nome', 'id', 'status_id')
                ->with(['metasConsultora' => function ($query) {
                    $query->whereNot('status_id', 3)->orderBy('data_referencia', 'desc');
                }])
                ->get()
                ->map(function ($consultora) {
                    $consultora->metaAtual = $this->metaUsuario($consultora->id);
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
