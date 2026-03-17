<?php 
namespace App\Services;

use App\Models\metas;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MetaService 
{
    public function metaUsuario(){
        $idUsuario = Auth::id(); // pega o id do usuario autenticado

        return metas::where('consultora_id', $idUsuario)->where('status_id', 3); // pega o registro da meta que esta ativa do usuario longado
    }
}


?>