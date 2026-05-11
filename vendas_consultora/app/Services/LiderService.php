<?php

namespace App\Services;

use App\Models\devolucoes;
use App\Models\pedidos;
use App\Models\usuarios;
use Exception;
use Illuminate\Support\Facades\Auth;

class LiderService
{
    protected $HistoricoComissaoService;

    public function __construct(HistoricoComissaoService $service) {
        $this->HistoricoComissaoService = $service;
    }

    /**
     * tras todas consultoras vinculadas diretamente.
     * consultoras que tem o id do lider na coluna 'consultora_id'
     */

    public function consultorasVinculadas($reutilizavel = false)
    {


        try {
            $usuario = Auth::user();

            /**
             * validação se o cargo não for de lider
             */
            if ($usuario->cargo !== 'lider' || $usuario->cargo !== 'consultora') {
                throw new Exception("Acesso negado!");
            }

            $idLider =  $usuario->id;

            $resultado = usuarios::where('cargo', 'consultora')->where('consultora_id', $idLider)->get();

            if (!$resultado) {
                throw new Exception("Nenhuma consultora encontrada");
            }

            /**
             * pegar apenas a query para reutilizar em outras funcoes
             */
            if ($reutilizavel === true) {
                return $resultado;
            }


            return [
                'status' => 'success',
                'data' => $resultado
            ];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'mensagem' => 'erro encontrado: ' . $e->getMessage()
            ];
        }
    }

    /**
     * desempenho das consultoras
     */
    public function desempenhoConsultoras() {
        $consultoras = $this->consultorasVinculadas(true);

        $resultado = $consultoras->map(function ($consultora) {
            $totalVendido = pedidos::where('usuario_id', $consultora->id)->whereNotIn('status_id', [1, 7])->selectRaw("strftime('%m/%Y', created_at) as mes_ano, SUM(valor_total) as total_vendas")
                                    ->groupBy('mes_ano')->orderBy('mes_ano', 'desc')->get();

            $totalPedidos = pedidos::where('usuario_id', $consultora->id)->whereNotIn('status_id', [1, 7])->selectRaw("strftime('%m/%Y', created_at) as mes_ano, COUNT(id) as total_pedidos")->groupBy('mes_ano')->orderBy('mes_ano', 'desc')->get();

            $comissao = $this->HistoricoComissaoService->comissaoPorMes($consultora->id);

			dd($comissao->toArray());
			
            $consultora->TotalVendido = $totalVendido;
            $consultora->TotalPedidos = $totalPedidos;
            $consultora->comissao = $comissao;

            return $consultora;
        });

        return [
            'data' => $resultado
        ];
    }
}
