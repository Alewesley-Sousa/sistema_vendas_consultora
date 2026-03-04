<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class resgates extends Model
{
    public $tiemstamps = false;

    protected $guarded = [
        'id', 'usuario_responsavel'
    ];

    protected $casts = [
        'total_pontos' => 'integer',
        'consultora_id' => 'integer',
        'catalogo_id' => 'integer',
        'status_id' => 'integer',
        'usuario_responsavel' => 'integer'
    ];
}
