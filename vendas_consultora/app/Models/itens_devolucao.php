<?php

namespace App\Models;

use App\Models\devolucoes;
use App\Models\itens_pedido;
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

    // RELACIONAMENTO ITEM PEDIDO
    public function itemPedido()
    {
        return $this->belongsTo(itens_pedido::class, 'item_pedido_id', 'id');
    }

    // RELACIONAMENTO DEVOLUCAO
    public function devolucao()
    {
        return $this->belongsTo(devolucoes::class, 'devolucao_id', 'id');
    }
}
