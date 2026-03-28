<?php

namespace App\Models;

use App\Models\itens_promocao;
use App\Models\Status\status_promocao;
use App\Models\Tipos\tipo_promocao;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class promocoes extends Model
{

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'data_inicio' => 'datetime',
        'data_fim' => 'datetime',
        'status_id' => 'integer'
    ];

    // RELACIONAMENTO ITENS PROMOÇÃO
    public function itensPromocao(): HasMany
    {
        return $this->hasMany(itens_promocao::class, 'promocao_id', 'id');
    }

    // RELACIONAMENTO STATUS PROMOCAO
    public function status(): BelongsTo
    {
        return $this->belongsTo(status_promocao::class, 'status_id', 'id');
    }

    /**
     * Scope para facilitar pegar só o que está valendo agora
     */
    public function scopeAtivas($query)
    {
        return $query->where('status_id', 1);
    }
}
