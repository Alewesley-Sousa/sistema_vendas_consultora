<?php 
namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;

class HistoricoComissaoService
{
    public function PegarHistoricoComissao(Request $request) {
        $usuario = Auth::user();
        $cargo = $usuario->cargo;

        $colunasPermitidas = ['valor', 'data_movimentacao'];
        
        // 2. Captura os valores ou define um padrão (default)
        $coluna = in_array($request->ordenar_por, $colunasPermitidas) ? $request->ordenar_por : 'data_movimentacao';
        $direcao = ($request->direcao === 'asc') ? 'asc' : 'desc';

        return DB::table('historico_comissoes')
        //Se não for distribuidora, vai mostrar apenas o historico do usuario autenticado.
        ->when($cargo !== 'distribuidora', function ($query) use ($usuario) {
            return $query->where('consultora_id', $usuario->id);
        })

        //Se for distribuidora, vai filtrar pelo id do usuario escolhido
        ->when($cargo === 'distribuidora' && $request->id_usuario, function ($query, $idEscolhido) {
            return $query->where('consultora_id', $idEscolhido);
        })

        ->orderBy($coluna, $direcao)
        ->paginate(10);


    }
}
