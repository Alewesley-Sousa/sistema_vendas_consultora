<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class comissoes extends Model
{
    protected $fillable = [
        'consultora_id'
    ];

    protected $casts = [
        'consultora_id' => 'integer',
        'saldo_liquido' => 'decimal:2'
    ];
}
