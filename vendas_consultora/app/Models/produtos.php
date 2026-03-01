<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class produtos extends Model
{
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];
    
    protected $casts = [
        'nome' => 'string',
        'preco' => 'decimal:2',
        'descricao' => 'string',
        'categoria_id' => 'integer',
        'status_id' => 'integer',
        'imagem_url' => 'string'
    ];
}
