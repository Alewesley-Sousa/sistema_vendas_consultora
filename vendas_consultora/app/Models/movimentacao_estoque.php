<?php

namespace App\Models;

use App\Models\produtos;
use App\Models\Tipo\tipo_movimentacao_estoque;
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

    // RELACIONAMENTO PRODUTO
    public function produto()
    {
        return $this->belongsTo(produtos::class, 'produto_id', 'id');
    }

    // RELACIONAMENTO TIPO MOVIMENTAÇÃO
    public function tipoMovimentacao()
    {
        return $this->belongsTo(tipo_movimentacao_estoque::class, 'tipo_movimentacao_id', 'id');
    }
}
