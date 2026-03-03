<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class itens_catalogo extends Model
{
    public $timestamps = false;

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'preco' => 'decimal:2',
        'pontos_necessarios' => 'integer',
        'status_id' => 'integer',
        'estoque_disponivel' => 'integer',
        'catalogo_id' => 'integer',
        'produto_id' => 'integer'
    ];
}
