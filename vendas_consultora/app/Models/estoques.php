<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class estoques extends Model
{
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'produto_id' => 'integer',
        'quantidade' => 'integer'
    ];
}
