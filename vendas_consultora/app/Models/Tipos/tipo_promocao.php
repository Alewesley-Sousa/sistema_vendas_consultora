<?php
/**
 * Autor: Alewesley-Sousa
 * Data: 01/03/2026
 * Descrição: model responsavel pelas configurações da tabela referente
 */

namespace App\Models\Tipo;

use App\Models\promocoes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class tipo_promocao extends Model
{
    // RELACIONAMENTO PROMOÇÕES
    public function promocoes(): HasMany
    {
        return $this->hasMany(promocoes::class, 'tipo_promocao_id', 'id');
    }
}
