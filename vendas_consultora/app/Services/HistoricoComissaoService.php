<?php

namespace App\Services;

use App\Models\historico_comissoes;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;

class HistoricoComissaoService
{
public function PegarHistoricoComissao(Request $request)
{
    $usuario = Auth::user();
    $cargo = $usuario->cargo;
    $usuario_id = $request->usuario_id;

    $saldoDisponivel = $usuario->saldo ?? 0;

    $query = historico_comissoes::query()
        ->with(['tipoComissao', 'tipoMovimentacao', 'usuario:id,nome'])

        // Filtro de Permissão
        ->when($cargo !== 'distribuidora', function ($q) use ($usuario) {
            return $q->where('consultora_id', $usuario->id);
        })
        ->when($cargo === 'distribuidora' && $usuario_id, function ($q) use ($usuario_id) {
            return $q->where('consultora_id', $usuario_id);
        })

        // Filtros de Data
        ->when($request->data_inicio, function ($q) use ($request) {
            return $q->whereDate('data_movimentacao', '>=', $request->data_inicio);
        })
        ->when($request->data_fim, function ($q) use ($request) {
            return $q->whereDate('data_movimentacao', '<=', $request->data_fim);
        })

        // CORREÇÃO: Filtro por Tipo de Movimentação (venda, estorno, saque)
        ->when($request->tipo, function ($q) use ($request) {
            return $q->where('tipo_movimentacao_id', $request->tipo);
        })

        // CORREÇÃO: Filtro por Tipo de Comissão (direta, nivel 1, nivel 2)
        ->when($request->tipo_comissao_id, function ($q) use ($request) {
            return $q->where('tipo_comissao_id', $request->tipo_comissao_id);
        });

    $colunasPermitidas = ['valor', 'data_movimentacao'];
    $coluna = in_array($request->ordenar_por, $colunasPermitidas) ? $request->ordenar_por : 'data_movimentacao';
    $direcao = ($request->direcao === 'asc') ? 'asc' : 'desc';

    $historico = $query->orderBy($coluna, $direcao)->paginate(10);

    return [
        'historico' => $historico,
        'saldo' => $saldoDisponivel
    ];
}



    /**
 * Busca a comissão agrupada por mês com tratamento de erros.
 */
public function comissaoPorMes($id)
{
    try {
        $comissaoVenda = historico_comissoes::where('consultora_id', $id)
            ->selectRaw("
                strftime('%m/%Y', data_movimentacao) as mes_referencia,
                SUM(CASE 
                    WHEN tipo_movimentacao_id = 1 THEN valor 
                    WHEN tipo_movimentacao_id = 2 THEN -valor 
                    ELSE 0 
                END) as valor_final
            ")
            ->groupBy('mes_referencia')
            ->orderBy('mes_referencia', 'desc')
            ->get();

        // Se o resultado for vazio, é um aviso importante para o seu log no Termux
        if ($comissaoVenda->isEmpty()) {
            \Log::info("Aviso: Nenhuma comissão encontrada para a consultora ID: {$id}. Verifique se os Seeds foram rodados.");
        }

        return $comissaoVenda;

    } catch (\Exception $e) {
        // Registra o erro real no log do Laravel (storage/logs/laravel.log)
        \Log::error("Erro na query de comissão (ID $id): " . $e->getMessage());

        // Retorna uma Collection vazia para não quebrar o map() no UsuarioService,
        // mas você saberá pelo log que houve um erro técnico.
        return collect([]);
    }
}

}
