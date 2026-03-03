<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class clientes extends Model
{
    public $timestamps = false;
    const CREATED_AT = 'criado_em';

    protected $fillable = [
        'nome', 'email', 'telefone', 'cep', 'cpf'
    ];

    protected $casts = [
        'nome' => 'string',
        'email' => 'string',
        'telefone' => 'string',
        'cep' => 'string',
        'consultora_id' => 'integer',
        'cpf' => 'string'
    ];
}
