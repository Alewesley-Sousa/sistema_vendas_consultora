<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pedidos extends Model
{
    protected $guarded = [
        'id', 'link', 'valor_total', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'usuario_id' => 'integer',
        'cliente_id' => 'integer',
        'link' => 'string',
        'valor_total' => 'decimal',
        'tipo_pagamento' => 'string'
    ];
}
