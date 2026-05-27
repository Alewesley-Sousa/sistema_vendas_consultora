<?php

namespace App\Models;

use App\Models\pedidos;
use Illuminate\Database\Eloquent\Model;

class pagamentos extends Model
{
    public $timestamps = false;

    protected $CREATED_AT = 'data_solicitacao';

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'pedido_id' => 'integer',
        'tipo_pagamento' => 'string',
        'valor' => 'decimal:2',
        'status' => 'string',
        'codigo_transacao' => 'string',
        'data_solicitacao' => 'date',
        'data_confirmacao' => 'date'
    ];

    // RELACIONAMENTO PEDIDO
    public function pedido()
    {
        return $this->belongsTo(pedidos::class, 'pedido_id', 'id');
    }
}
