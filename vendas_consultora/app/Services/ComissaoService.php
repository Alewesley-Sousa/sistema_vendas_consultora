<?php 
namespace App\Services;

use App\Models\comissoes;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ComissaoService 
{
    public function comissaoUsuario($idUsuario) {
        return comissoes::find($idUsuario);
    }
}


?>