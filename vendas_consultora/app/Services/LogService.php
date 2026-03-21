<?php

namespace App\Services;

use App\Models\logs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LogService
{
    /**
     * Salva um log de auditoria na tabela 'logs'
     */
    public static function registrarAcao(string $acao, string $entidade, $idAfetado, string $descricao = null)
    {
        $usuario = Auth::user();
        return logs::create([
            'usuario_id'          => $usuario->id, // Pega o ID do usuário logado automaticamente
            'acao'                => $acao,
            'entidade_afetada'    => $entidade,
            'registro_afetado_id' => $idAfetado,
            'descricao'           => $descricao,
            'ip_origem'           => request()->ip(), // Pega o IP do dispositivo (útil no Termux/Mobile)
            'data_hora'           => now(),
        ]);
    }
}