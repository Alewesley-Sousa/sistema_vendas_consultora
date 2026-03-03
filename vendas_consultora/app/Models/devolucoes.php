<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    }
