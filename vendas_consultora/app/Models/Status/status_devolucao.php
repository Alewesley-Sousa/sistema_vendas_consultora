<?php
/**
 * Autor: Alewesley-Sousa
 * Data: 01/03/2026
 * Descrição: model responsavel pelas configurações da tabela referente
 */


namespace App\Models\Status;

use App\Models\devolucoes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class status_devolucao extends Model
{
    // RELACIONAMENTO DEVOLUÇÃO
    public function devolucao(): HasOne
    {
        return $this->hasOne(devolucoes::class, 'status_id', 'id');
    }
}
