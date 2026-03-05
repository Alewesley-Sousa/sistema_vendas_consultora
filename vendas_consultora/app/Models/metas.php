<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class metas extends Model
{
    public $timestamps = false;

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'consultora_id' => 'integer',
        'lider_id' => 'integer',
        'status_id' => 'integer',
        'valor_meta' => 'decimal:2',
        'data_referencia' => 'date',
    ];
}
