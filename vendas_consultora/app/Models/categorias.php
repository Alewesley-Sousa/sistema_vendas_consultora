<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class categorias extends Model
{
    public $timestamps = false;

    protected $fillable = ['nome', 'descricao'];

    protected $casts = [
        'nome' => 'string',
        'descricao' => 'string'
    ];
}
