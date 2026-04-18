<?php 
namespace App\Services;

use App\Models\comissoes;
use App\Models\historico_comissoes;
use App\Models\solicitacoes_saque;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ComissaoService 
{
	
	/**
     * Verifica se o usuário autenticado tem o cargo de distribuidora.
     */
    private function verificarCargoDistribuidora() {
        $usuario = Auth::user();
        if (!$usuario || $usuario->cargo !== 'distribuidora') {
            throw new Exception("Acesso negado. Apenas distribuidoras podem realizar esta ação.");
        }
    }
    /**
     * Lista todas as solicitações de saque pendentes (Status 1).
     */
    public function listarSolicitacoesPendentes() {
        $this->verificarCargoDistribuidora();
        
        return solicitacoes_saque::with('consultora') // Assumindo que existe o relacionamento no Model
            ->where('status_id', 1)
            ->get();
    }
    
    public function comissaoUsuario($idUsuario, $atualizarRegistro = false) {
        $query = comissoes::where('consultora_id', $idUsuario);
        // se o parâmetro atualizar registro vier como true, então vai trancar o registro para evitar atualizações simultâneas
        if ($atualizarRegistro) {
            $query->lockForUpdate();
        }
        return $query->first();
    }

    public function solicitacaoPendente() {
        $usuario = Auth::user();
        return solicitacoes_saque::where('consultora_id', $usuario->id)->where('status_id', 1)->first();
    }


    public function solicitarSaque() {
        DB::beginTransaction(); // inicia a regra do saque
        
        try {
            $usuario = Auth::user(); // pega os dados do usuario autenticado
            $registroSaldo = $this->comissaoUsuario($usuario->id, true);

            // verificar se existe uma solicitação 'pendente'.
            $solicitacaoPendente = $this->solicitacaoPendente();

            if ($solicitacaoPendente) {
                throw new Exception("você ja possui solicitação pendente");
            }
            
            // a transação para se não existir registro ou valor acima de zero
            if (!$registroSaldo || $registroSaldo->saldo_liquido <= 0) {
                throw new Exception("Saldo insuficiente ou inexistente para saque.");
            }


            // pega o valor total a sacar
            $valorSolicitacao = $registroSaldo->saldo_liquido; 

            solicitacoes_saque::create([
                'consultora_id' => $usuario->id,
                'valor_solicitado' => $valorSolicitacao,
                'status_id' => 1,
                'data_decisao' => null
            ]);

            DB::commit();
            
            return [
                'status' => 'success',
                'mensagem' => 'Saque solicitado com sucesso!',
                'valor_solicitado' => $valorSolicitacao
            ];

        } catch (Exception $e) {
            DB::rollBack();

            return [
                'status' => 'error',
                'mensagem' => 'Falha ao solicitar o saque: ' . $e->getMessage()
            ];
        }
    }

	 /**
     * Aprova ou Reprova uma comissão.
     * $status_id: 2 para Aprovar, 3 para Reprovar (ajuste conforme seu banco)
     */
    public function processarSolicitacao($solicitacaoId, $statusDesejado) 
    {
        $this->verificarCargoDistribuidora();

        DB::beginTransaction();
        try {
            $solicitacao = solicitacoes_saque::where('id', $solicitacaoId)
                ->where('status_id', 1) // Garante que só processa o que está pendente
                ->lockForUpdate()
                ->first();

            if (!$solicitacao) {
                throw new Exception("Solicitação não encontrada ou já processada.");
            }

            if ($statusDesejado == 2) { // APROVAR
                $registroSaldo = $this->comissaoUsuario($solicitacao->consultora_id, true);
                
                if ($registroSaldo->saldo_liquido < $solicitacao->valor_solicitado) {
                    throw new Exception("A consultora não possui saldo suficiente para esta aprovação.");
                }

                // Deduz o saldo
                $registroSaldo->saldo_liquido -= $solicitacao->valor_solicitado;
                $registroSaldo->save();

                $solicitacao->status_id = 2; // Status Aprovado
            } else { // REPROVAR
                $solicitacao->status_id = 3; // Status Reprovado
            }

            $solicitacao->data_decisao = now();
            $solicitacao->save();

            DB::commit();
            return ['status' => 'success', 'mensagem' => 'Solicitação atualizada com sucesso.'];

        } catch (Exception $e) {
            DB::rollBack();
            return ['status' => 'error', 'mensagem' => $e->getMessage()];
        }
    }
}
?>