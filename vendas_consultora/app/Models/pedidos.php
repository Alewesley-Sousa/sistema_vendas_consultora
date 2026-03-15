<?php

namespace App\Models;

use App\Models\devolucoes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class pedidos extends Model
{
    protected $guarded = [
        'id', 'link', 'valor_total', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'usuario_id' => 'integer',
        'cliente_id' => 'integer',
        'link' => 'string',
        'valor_total' => 'decimal:2',
        'tipo_pagamento' => 'string'
    ];

    //RELACIONAMENTO DEVOLUÇÕES
    public function devolucoes(): HasMany
    {
        return $this->hasMany(devolucoes::class, 'pedido_id', 'id');
    }
}
