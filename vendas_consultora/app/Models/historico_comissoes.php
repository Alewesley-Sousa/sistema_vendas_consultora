<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class historico_comissoes extends Model
{
    public $timestamps = false;

    protected $CREATED_AT = 'data_movimentacao';

    protected $guarded = [
        'valor','id', 'usuario_responsavel', 'consultora_id'
    ];

    protected $casts = [
        'consultora_id' => 'integer',
        'pedido_id' => 'integer',
        'tipo_comissao_id' => 'integer',
        'valor' => 'decimal:2',
        'tipo_movimentacao_id' => 'integer',
        'data_movimentacao' => 'datetime',
        'usuario_responsavel' => 'integer'
    ];
}
