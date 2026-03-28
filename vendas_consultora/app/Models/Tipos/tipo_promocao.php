<?php
/**
 * Autor: Alewesley-Sousa
 * Data: 01/03/2026
 * Descrição: model responsavel pelas configurações da tabela referente
 */

namespace App\Models\Tipos;

use App\Models\itens_promocao;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class tipo_promocao extends Model
{
    public $timestamps = false;
    protected $table = 'tipo_promocao';

    // RELACIONAMENTO PROMOÇÕES
    public function itensPromocoes(): HasMany
    {
        return $this->hasMany(itens_promocao::class, 'tipo_promocao_id', 'id');
    }
}
