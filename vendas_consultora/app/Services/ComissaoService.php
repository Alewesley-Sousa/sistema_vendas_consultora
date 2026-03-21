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

}


?>