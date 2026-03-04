<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class itens_promocao extends Model
{
    public $timestamps = false;

    protected $guarded = [
        'id'
    ];

    protected $casts = [
      'produto_id' => 'integer',
      'promocao_id' => 'integer',
      'quantidade_min' => 'integer',
      'condicao_especial' => 'string'
    ];
}
