<?php
/**
 * Autor: Alewesley-Sousa
 * Data: 01/03/2026
 * Descrição: model responsavel pelas configurações da tabela referente
 */


namespace App\Models\Status;

use App\Models\produtos;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class status_produto extends Model
{
    // RELACIONAMENTO PRODUTOS
    public function produtos(): HasMany
    {
        return $this->hasMany(produtos::class, 'status_id', 'id');
    }
}
