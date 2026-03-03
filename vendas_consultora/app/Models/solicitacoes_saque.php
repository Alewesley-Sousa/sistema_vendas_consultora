<?php

namespace App\Models;

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
}
