<?php

namespace App\Models;

use App\Models\usuarios;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function usuarios(): BelongsTo
    {
        return $this->belongsTo(usuarios::class, 'consultora_id', 'id');
    }
}
