<?php
/**
 * Autor: Alewesley-Sousa
 * Data: 01/03/2026
 * Descrição: model responsavel pelas configurações da tabela referente
 */


namespace App\Models\Status;

use App\Models\solicitacoes_saque;
use Illuminate\Database\Eloquent\Model;

class status_solicitacao_saque extends Model
{
    // RELACIONAMENTO SOLICITACOES SAQUE
    public function solicitacoesSaque()
    {
        return $this->hasMany(solicitacoes_saque::class, 'status_id', 'id');
    }
}
