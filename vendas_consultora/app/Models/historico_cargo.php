<?php

namespace App\Models;

use App\Models\usuarios;
use App\Models\qualificacao_profissional;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class historico_cargo extends Model
{
    public $timestamps = false;

    protected $CREATED_AT = 'data_mudanca';
    protected $table = 'historico_cargo';
    
    protected $guarded = [
        'id', 'data_mudanca'
    ];

    protected $casts = [
        'consultora_id' => 'integer',
        'qualificacao_profissional_id' => 'integer',
        'cargo_anterior' => 'string',
        'cargo_novo' => 'string',
        'data_mudanca' => 'date'
    ];

    // RELACIONAMENTO CONSULTORA
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(usuarios::class, 'consultora_id', 'id');
    }

    // RELACIONAMENTO QUALIFICACAO PROFISSIONAL
    public function qualificacaoProfissional(): BelongsTo
    {
        return $this->belongsTo(qualificacao_profissional::class, 'qualificacao_profissional_id', 'id');
    }
}
