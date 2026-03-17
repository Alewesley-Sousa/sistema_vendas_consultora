<?php 
namespace App\Services;

use App\Models\comissoes;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ComissaoService 
{
    public function comissaoUsuario(){
        $idUsuario = Auth::id(); // pega o id do usuario autenticado

        return comissoes::find($idUsuario);
    }
}


?>