<?php

namespace App\Models;
use App\Models\historico_cargo;
use App\Models\usuarios;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class qualificacao_profissional extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'data_validacao', 'data_referencia'
    ];

    protected $casts = [
        'consultora_id' => 'integer',
        'data_validacao' => 'date',
        'data_referencia' => 'date',
        'total_vendas' => 'decimal:2',
        'total_recrutas_ativos' => 'integer',
        'status' => 'string'
    ];

    // RELACIONAMENTO HISTORICO CARGO
    public function historicoCargo(): HasOne
    {
        return $this->hasOne(historico_cargo::class, 'qualificacao_profissional_id', 'id');
    }

    // RELACIONAMENTO CONSULTORA
    public function usuarios(): BelongsTo
    {
        return $this->belongsTo(usuarios::class, 'consultora_id', 'id');
    }
}
