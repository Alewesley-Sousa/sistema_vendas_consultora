<?php

namespace App\Models;

use App\Models\pedidos;
use App\Models\produtos;
use App\Models\itens_devolucao;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class itens_pedido extends Model
{
    public $timestamps = false;

	protected $table = 'itens_pedido';
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

    // RELACIONAMENTO PRODUTO
    public function produto(): BelongsTo
    {
        return $this->belongsTo(produtos::class, 'produto_id', 'id');
    }

    // RELACIONAMENTO PEDIDOS
    public function pedido(): BelongsTo
    {
        return $this->belongsTo(pedidos::class, 'pedido_id', 'id');
    }
}
