<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class catalogos extends Model
{
    public $timestamps = false;

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'nome' => 'string',
        'tipo_categoria_id' => 'integer',
        'status_id' => 'integer',
        'descricao' => 'string',
        'data_encerramento' => 'date',
        'data_publicacao' => 'date'
    ];
}
