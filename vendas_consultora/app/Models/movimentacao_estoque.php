<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class movimentacao_estoque extends Model
{
    protected $table = 'movimentacao_estoque';

    protected $guarded = [
        'quantidade', 'origem_tipo', 'origem_id', 'usuario_responsavel', 'id'
    ];

    protected $casts = [
        'produto_id' => 'integer',
        'quantidade' => 'integer',
        'origem_tipo' => 'string',
        'origem_id' => 'integer',
        'tipo_movimentacao_id' => 'integer',
        'usuario_responsavel' => 'integer'
    ];
}
