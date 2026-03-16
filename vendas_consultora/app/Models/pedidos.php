<?php

namespace App\Models;

use App\Models\clientes;
use App\Models\devolucoes;
use App\Models\itens_pedido;
use App\Models\pagamentos;
use App\Models\usuarios;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    //RELACIONAMENTO HISTORICO COMISSOES
    public function historicoComissoes(): HasMany
    {
        return $this->hasMany(historico_comissoes::class, 'pedido_id', 'id');
    }

    // RELACIONAMENTO ITENS PEDIDOS
    public function itensPedidos(): HasMany
    {
        return $this->hasMany(itens_pedido::class, 'pedido_id', 'id');
    }

    // RELACIONAMENTO PAGAMENTOS
    public function pagamentos(): HasOne
    {
        return $this->hasOne(pagamentos::class, 'pedido_id', 'id');
    }

    // RELACIONAMENTO CLIENTES
    public function clientes(): HasOne
    {
        return $this->hasOne(clientes::class, 'id', 'cliente_id');
    }

    // RELACIONAMENTO CONSULTORA
    public function consultora(): BelongsTo
    {
        return $this->belongsTo(usuarios::class, 'consultora_id', 'id');
    }
}
