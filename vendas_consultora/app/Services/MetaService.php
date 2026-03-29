<?php

namespace App\Services;

use App\Http\Controllers\UsuariosController;
use App\Models\metas;
use App\Models\pedidos;
use App\Models\usuarios;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MetaService
{
    public function metaUsuario($idUsuario)
    {
        return metas::where('consultora_id', $idUsuario)->where('status_id', 3)->first(); // pega o registro da meta que esta ativa do usuario longado
    }

    public function progressoMeta()
    {
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
        $progresso = ($totalVendido / $valorMeta) * 100;
        return round($progresso, 2);
    }

    public function criarMeta($idConsultora, $dados)
    {
        try {
            $usuario = Auth::user();
            if ($usuario->cargo !== 'lider') {
                throw new Exception('Acesso negado!');
            }
            $idLider = $usuario->id;

            $consultora = usuarios::find($idConsultora);
            
            if (!$consultora) {
                throw new Exception('Usuario não identificado!');
            }

            if ($consultora['consultora_id'] !== $idLider) {
                throw new Exception('Você não tem esse nivel de permissão!');
            }

            $temMetaAtiva = metas::where('consultora_id', $consultora->id)->where('status_id', 3)->exists();

            if ($temMetaAtiva) {
                throw new Exception('Esse consultor(a) ja possui uma meta ativa!');
            }

            $meta = metas::create([
                'consultora_id' => $idConsultora,
                'lider_id' => $idLider,
                'valor_meta' => $dados['valor_meta'],
                'data_referencia' => $dados['data_referencia'] . '-01',
                'status_id' => 3
            ]);

            return [
                'status' => 'success',
                'mensagem' => "meta atribuida com sucesso a(o) consultor(a) $consultora->nome!" 
            ];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'mensagem' => 'não foi possivel atribuir a meta: ' .
                $e->getMessage()
            ];
        }
    }
}
