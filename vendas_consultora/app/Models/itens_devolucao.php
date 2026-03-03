<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class itens_devolucao extends Model
{
    public $timestamps = false;
    
    protected $table = 'itens_devolucao';

    protected $fillable = [
        'item_pedido_id',
        'devolucao_id',
        'quantidade',
        'subtotal',
    ];

    protected $casts = [
        'item_pedido_id' => 'integer',
        'devolucao_id' => 'integer',
        'quantidade' => 'integer',
        'subtotal' => 'decimal:2',
    ];
}
