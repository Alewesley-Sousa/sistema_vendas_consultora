<?php

namespace App\Models;

use App\Models\clientes;
use App\Models\itens_devolucao as ModelsItens_devolucao;
use App\Models\pedidos;
use App\Models\Status\status_devolucao;
use App\Models\Tipo\tipo_devolucao;
use App\Models\Itens_devolucao;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class devolucoes extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'motivo', 'tipo_devolucao_id', 'status_id', 'data_decisao', 'data_solicitacao'
    ];
    
    protected $casts = [
        'pedido_id' => 'integer',
        'cliente_id' => 'integer',
        'motivo' => 'string',
        'tipo_devolucao_id' => 'integer',
        'status_id' => 'integer',
        'data_decisao' => 'datetime',
        'data_solicitacao' => 'datetime',
        'usuario_responsavel' => 'integer'
    ];

    // RELACIONAMENTO PEDIDOS
    public function pedido(): BelongsTo
    {
        return $this->belongsTo(pedidos::class, 'pedido_id', 'id');
    }

    // RELACIONAMENTO CLIENTE
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(clientes::class, 'cliente_id', 'id');
    }

    // RELACIONAMENTO TIPO DEVOLUÇÃO
    public function tipoDevolucao(): BelongsTo
    {
        return $this->belongsTo(tipo_devolucao::class, 'tipo_devolucao_id', 'id');
    }

    //RELACIONAMENTO STATUS DEVOLUÇÃO
    public function statusDevolucao(): BelongsTo
    {
        return $this->belongsTo(status_devolucao::class, 'status_id', 'id');
    }

    // RELACIONAMENTO ITENS DEVOLUÇÃO
    public function itensDevolucao(): HasOne
    {
        return $this->hasOne(Itens_devolucao::class, 'devolucao_id', 'id');
    }
}
