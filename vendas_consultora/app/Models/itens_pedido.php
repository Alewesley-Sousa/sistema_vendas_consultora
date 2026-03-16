<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class itens_pedido extends Model
{
    public $timestamps = false;

    protected $guarded = [
        'id', 'subtotal', 'preco_unitario'
    ];

    protected $casts = [
        'produto_id' => 'integer',
        'pedido_id' => 'integer',
        'quantidade' => 'integer',
        'subtotal' => 'decimal:2',
        'preco_unitario' => 'decimal:2'
    ];
    
    // RELACIONAMENTO ITENS DEVOLUÇÃO
    public function itensDevolucao(): HasOne
    {
        return $this->hasOne(itens_devolucao::class, 'item_pedido_id', 'id');
    }
}
