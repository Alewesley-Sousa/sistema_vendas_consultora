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
}


?>