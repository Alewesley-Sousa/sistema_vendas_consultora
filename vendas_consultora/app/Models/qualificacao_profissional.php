<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class qualificacao_profissional extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'data_validacao', 'data_referencia'
    ];

    protected $casts = [
        'consultora_id' => 'integer',
        'data_validacao' => 'date',
        'data_referencia' => 'date',
        'total_vendas' => 'decimal:2',
        'total_recrutas_ativos' => 'integer',
        'status' => 'string'
    ];
}
