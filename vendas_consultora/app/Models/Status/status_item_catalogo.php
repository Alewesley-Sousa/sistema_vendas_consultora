<?php
/**
 * Autor: Alewesley-Sousa
 * Data: 01/03/2026
 * Descrição: model responsavel pelas configurações da tabela referente
 */


namespace App\Models\Status;

use App\Models\itens_catalogo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class status_item_catalogo extends Model
{
    // RELACIONAMENTO ITENS CATALOGO
    public function itensCatalogo(): HasMany
    {
        return $this->hasMany(itens_catalogo::class, 'status_id', 'id');
    }
}
