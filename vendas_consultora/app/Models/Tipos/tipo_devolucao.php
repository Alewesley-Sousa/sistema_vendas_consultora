<?php
/**
 * Autor: Alewesley-Sousa
 * Data: 01/03/2026
 * Descrição: model responsavel pelas configurações da tabela referente
 */


namespace App\Models\Tipo;

use App\Models\devolucoes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class tipo_devolucao extends Model
{
    // RELACIONAMENTO DEVOLUCAO
    public function devolucao(): HasOne
    {
        return $this->hasOne(devolucoes::class, 'tipo_devolucao_id', 'id');
    }
}
