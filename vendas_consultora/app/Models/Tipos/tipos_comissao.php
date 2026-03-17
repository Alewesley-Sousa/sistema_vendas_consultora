<?php
/**
 * Autor: Alewesley-Sousa
 * Data: 01/03/2026
 * Descrição: model responsavel pelas configurações da tabela referente
 */

namespace App\Models\Tipo;

use App\Models\historico_comissoes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class tipos_comissao extends Model
{
    // RELACIONAMENTO HISTÓRICO COMISSÕES
    public function historicoComissoes(): HasMany
    {
        return $this->hasMany(historico_comissoes::class, 'tipo_comissao_id', 'id');
    }
}
