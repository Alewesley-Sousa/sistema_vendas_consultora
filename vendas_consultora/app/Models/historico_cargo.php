<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class historico_cargo extends Model
{
    public $timestamps = false;

    protected $CREATED_AT = 'data_mudanca';

    protected $guarded = [
        'id', 'data_mudanca'
    ];

    protected $casts = [
        'consultora_id' => 'integer',
        'qualificacao_profissional_id' => 'integer',
        'cargo_anterior' => 'string',
        'cargo_novo' => 'string',
        'data_mudanca' => 'date'
    ];
}
