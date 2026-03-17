<?php
/**
 * Autor: Alewesley-Sousa
 * Data: 01/03/2026
 * Descrição: model responsavel pelas configurações da tabela referente
 */

namespace App\Models\Tipos;

use App\Models\promocoes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class tipo_promocao extends Model
{
    public $timestamps = false;
    protected $table = 'tipo_promocao';

    // RELACIONAMENTO PROMOÇÕES
    public function promocoes(): HasMany
    {
        return $this->hasMany(promocoes::class, 'tipo_promocao_id', 'id');
    }
}
