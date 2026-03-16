<?php

namespace App\Models;

use App\Models\itens_promocao;
use App\Models\Status\status_promocao;
use App\Models\Tipo\tipo_promocao;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class promocoes extends Model
{
    public $timestamps = false;

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'nome' => 'string',
        'desconto' => 'decimal',
        'descricao' => 'string',
        'tipo_promocao_id' => 'integer',
        'data_inicio' => 'date',
        'data_fim' => 'date',
        'status_id' => 'integer'
    ];

    // RELACIONAMENTO ITENS PROMOÇÃO
    public function itensPromocao(): HasMany
    {
        return $this->hasMany(itens_promocao::class, 'promocao_id', 'id');
    }

    // RELACIONAMENTO TIPO PROMOÇÃO
    public function tipoPromocao(): BelongsTo
    {
        return $this->belongsTo(tipo_promocao::class, 'tipo_promocao_id', 'id');
    }

    // RELACIONAMENTO STATUS PROMOCAO
    public function status(): BelongsTo
    {
        return $this->belongsTo(status_promocao::class, 'status_id', 'id');
    }
}
