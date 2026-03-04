<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class itens_resgate extends Model
{
    public $timestamps = false;

    protected $guarded = [
        'subtotal_pontos', 'id'
    ];

    protected $casts = [
        'quantidade' => 'integer',
        'item_catalogo_id' => 'integer',
        'resgate_id' => 'integer',
        'subtotal_pontos' => 'integer'
    ];
}
