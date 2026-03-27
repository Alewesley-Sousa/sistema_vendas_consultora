<?php

namespace App\Models;

use App\Models\pedidos;
use App\Models\Tipos\tipo_movimentacao_comissao;
use App\Models\Tipos\tipos_comissao;
use App\Models\usuarios;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    // RELACIONAMENTO CONSULTORA
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(usuarios::class, 'consultora_id', 'id');
    }

    //RELACIONAMENTO PEDIDO
    public function pedido(): BelongsTo
    {
        return $this->belongsTo(pedidos::class, 'pedido_id', 'id');
    }

    //RELACIONAMENTO TIPO COMISSÃO
    public function tipoComissao(): BelongsTo
    {
        return $this->belongsTo(tipos_comissao::class, 'tipo_comissao_id', 'id');
    }

    //RELACIONAMENTO TIPO MOVIMENTAÇÃO
    public function tipoMovimentacao(): BelongsTo
    {
        return $this->belongsTo(tipo_movimentacao_comissao::class, 'tipo_movimentacao_id', 'id');
    }
}
