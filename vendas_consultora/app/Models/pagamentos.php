<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pagamentos extends Model
{
    public $timestamps = false;

    protected $CREATED_AT = 'data_solicitacao';

    protected $guarded = [
        'id', 'valor', 'codigo_transacao'
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
}
