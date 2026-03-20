<?php 
namespace App\Services;

use App\Models\historico_comissoes;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HistoricoComissaoService
{
    public function PegarHistoricoComissao($idUsuario) {
        return historico_comissoes::where('consultora_id', $idUsuario)->get();
    }
}
