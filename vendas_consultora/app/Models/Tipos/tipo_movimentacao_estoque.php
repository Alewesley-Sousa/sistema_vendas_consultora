<?php
/**
 * Autor: Alewesley-Sousa
 * Data: 01/03/2026
 * Descrição: model responsavel pelas configurações da tabela referente
 */


namespace App\Models\Tipo;

use App\Models\movimentacao_estoque;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class tipo_movimentacao_estoque extends Model
{
    // RELACIONAMENTO MOVIMENTAÇÃO ESTOQUE
    public function movimentacoes(): HasMany
    {
        return $this->hasMany(movimentacao_estoque::class, 'tipo_movimentacao_id', 'id');
    }
}
