<?php
/**
 * Autor: Alewesley-Sousa
 * Data: 01/03/2026
 * Descrição: model responsavel pelas configurações da tabela referente
 */


namespace App\Models\Status;

use App\Models\pedidos;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class status_pedido extends Model
{
    // RELACIONAMENTO PEDIDO
    public function pedidos(): HasMany
    {
        return $this->hasMany(pedidos::class, 'status_id', 'id');
    }
}
