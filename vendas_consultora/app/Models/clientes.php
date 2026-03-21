<?php

namespace App\Models;

use App\Models\devolucoes;
use App\Models\pedidos;
use App\Models\usuarios;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class clientes extends Model
{
    public $timestamps = false;
    const CREATED_AT = 'criado_em';

    protected $fillable = [
        'nome', 'email', 'telefone', 'cep', 'cpf', 'consultora_id'
    ];

    protected $casts = [
        'nome' => 'string',
        'email' => 'string',
        'telefone' => 'string',
        'cep' => 'string',
        'consultora_id' => 'integer',
        'cpf' => 'string'
    ];
    // RELACIONAMENTO CONSULTORA
    public function usuarios(): BelongsTo
    {
        return $this->belongsTo(usuarios::class, 'consultora_id', 'id');
    }

    // RELACIONAMENTO DEVOLUCOES
    public function devolucoes(): HasMany
    {
        return $this->hasMany(devolucoes::class, 'cliente_id', 'id');
    }

    // RELACIONAMENTO PEDIDOS
    public function pedidos(): HasMany
    {
        return $this->hasMany(pedidos::class, 'cliente_id', 'id');
    }
}
