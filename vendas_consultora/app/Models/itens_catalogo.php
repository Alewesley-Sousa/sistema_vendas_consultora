<?php

namespace App\Models;

use App\Models\catalogos;
use App\Models\produtos;
use App\Models\Status\status_item_catalogo;
use App\Models\itens_resgate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class itens_catalogo extends Model
{
    public $timestamps = false;

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'preco' => 'decimal:2',
        'pontos_necessarios' => 'integer',
        'status_id' => 'integer',
        'estoque_disponivel' => 'integer',
        'catalogo_id' => 'integer',
        'produto_id' => 'integer'
    ];

    // RELACIONAMENTO CATALOGO
    public function catalogo(): BelongsTo
    {
        return $this->belongsTo(catalogos::class, 'catalogo_id', 'id');
    }

    // RELACIONAMENTO PRODUTO
    public function produto(): BelongsTo
    {
        return $this->belongsTo(produtos::class, 'produto_id', 'id');
    }

    // RELACIONAMENTO STATUS ITENS CATALOGO
    public function status(): BelongsTo
    {
        return $this->belongsTo(status_item_catalogo::class, 'status_id', 'id');
    }

    // RELACIONAMENTO ITENS RESGATE
    public function itensResgate(): HasOne
    {
        return $this->hasOne(itens_resgate::class, 'item_catalogo_id', 'id');
    }
}
