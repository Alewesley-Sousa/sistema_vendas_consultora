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
        return metas::where('consultora_id', $idUsuario)->where('status_id', 3)->first(); // pega o registro da meta que esta ativa do usuario longado
    }

    public function progressoMeta() {
        $usuario = Auth::user();
        $idUsuario = $usuario->id;
        
        // Usamos o método acima para pegar a meta
        $metaAtual = $this->metaUsuario($idUsuario);

        // Segurança: Se não houver meta ativa, retorna 0 de progresso
        if (!$metaAtual) {
            return 0;
        }

        // Se data_referencia não for um objeto Carbon, adicione no Model: protected $casts = ['data_referencia' => 'date'];
        $mes = $metaAtual->data_referencia->format('m');
        $ano = $metaAtual->data_referencia->format('Y'); // 'Y' maiúsculo para 2026
        $valorMeta = $metaAtual->valor_meta;

        // Total vendido (Status 6 = Pago/Finalizado)
        $totalVendido = pedidos::where('usuario_id', $idUsuario) // Importante filtrar por consultora aqui também!
            ->whereMonth('created_at', $mes)
            ->whereYear('created_at', $ano)
            ->where('status_id', 6)
            ->sum('valor_total');

        if ($valorMeta <= 0) return 0;

        // O cálculo correto de progresso é (O que eu fiz / O que eu preciso fazer)
        // Se eu vendi 500 e a meta é 1000, fiz 0.5 (50%)
        $progresso = ($totalVendido / $valorMeta);
        return round($progresso, 2);
        
    }
}


?>