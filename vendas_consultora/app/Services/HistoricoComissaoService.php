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

        $colunasPermitidas = ['valor', 'data_movimentacao'];

        // 2. Captura os valores ou define um padrão (default)
        $coluna = in_array($request->ordenar_por, $colunasPermitidas) ? $request->ordenar_por : 'data_movimentacao';
        $direcao = ($request->direcao === 'asc') ? 'asc' : 'desc';

        return historico_comissoes::query()
            ->with(
                [
                    'tipoComissao',
                    'tipoMovimentacao',
                    'usuario' => function ($query) {
                        $query->select('id', 'nome'); // 'id' é obrigatório para o Eloquent ligar as tabelas
                    }
                ]
            )
            //Se não for distribuidora, vai mostrar apenas o historico do usuario autenticado.
            ->when($cargo !== 'distribuidora', function ($query) use ($usuario) {
                return $query->where('consultora_id', $usuario->id);
            })

            //Se for distribuidora, vai filtrar pelo id do usuario escolhido
            ->when($cargo === 'distribuidora' && $usuario_id, function ($query) use ($usuario_id) {
                return $query->where('consultora_id', $id_usuario);
            })
            ->whereIn('tipo_movimentacao_id', [1, 2]) // Só vai pegar do tipo estorno e venda

            ->orderBy($coluna, $direcao)
            ->paginate(10);
    }

    public function comissaoPorMes($id)
    {
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

        return $comissaoVenda;
    }
}
