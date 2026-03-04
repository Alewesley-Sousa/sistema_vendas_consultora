<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class promocoes extends Model
{
    public $timestamps = false;

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'nome' => 'string',
        'desconto' => 'decimal',
        'descricao' => 'string',
        'tipo_promocao_id' => 'integer',
        'data_inicio' => 'date',
        'data_fim' => 'date',
        'status_id' => 'integer'
    ];
}
