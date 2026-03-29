<?php

namespace App\Services;

use App\Models\usuarios;
use Exception;
use Illuminate\Support\Facades\Auth;

class LiderService
{

    /**
     * tras todas consultoras vinculadas diretamente.
     * consultoras que tem o id do lider na coluna 'consultora_id'
     */

    public function consultorasVinculadas()
    {
        try {
            $usuario = Auth::user();

            /**
             * validação se o cargo não for de lider
             */
            if ($usuario->cargo !== 'lider') {
                throw new Exception("Acesso negado!");
            }

            $idLider =  $usuario->id;

            $resultado = usuarios::where('cargo', 'consultora')->where('consultora_id', $idLider)->get();

            if (!$resultado) {
                throw new Exception("Nenhuma consultora encontrada");
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
}
