<?php 
namespace App\Services;

use App\Models\metas;
use App\Models\pedidos;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MetaService 
{
    public function metaUsuario($idUsuario){
        return metas::where('consultora_id', $idUsuario)->where('status_id', 3)->get(); // pega o registro da meta que esta ativa do usuario longado
    }

    public function progressoMeta() {
        // pega o id do usuario autenticado (UA)
        $idUsuario = Auth::id();
        // pega a meta ativa do UA
        $metaAtual = metas::where('consultora_id', $idUsuario)->where('status_id', 3);
        // pega o mês de referencia
        $mes = $metaAtual->data_referencia->format('m');

        // pega o ano de referencia
        $ano = $metaAtual->data_referencia->format('y');

        // pega o valor da meta atual
        $valorMeta = $metaAtual->valor_meta;

        // total de vendas no mês e ano de referencia
        $totalVendido = pedidos::whereMonth('created_at', $mes)->whereYear('created_at', $ano)->where('status_id', 6)->sum('valor');

        // pega o percentual em decimal do progresso da meta
        return ( $valorMeta / $totalVendido );
    }
}


?>