<?php

namespace App\Models;

use App\Models\Status\status_solicitacao_saque;
use App\Models\usuarios;
use Illuminate\Database\Eloquent\Model;

class solicitacoes_saque extends Model
{
    public $timestamps = false;

    protected $CREATED_AT = 'data_solicitacao';

    protected $fillable = [
        'consultora_id', 'valor_solicitado', 'status_id'
    ];

    protected $casts = [
        'consultora_id' => 'integer',
        'valor_solicitado' => 'decimal:2',
        'status_id' => 'integer',
        'data_decisao' => 'datetime',
        'data_solicitacao' => 'datetime'
    ];

    // RELACIONAMENTO CONSULTORA
    public function consultora()
    {
        return $this->belongsTo(usuarios::class, 'consultora_id', 'id');
    }

    // RELACIONAMENTO STATUS
    public function status()
    {
        return $this->belongsTo(status_solicitacao_saque::class, 'status_id', 'id');
    }
}
