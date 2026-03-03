<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    
}
