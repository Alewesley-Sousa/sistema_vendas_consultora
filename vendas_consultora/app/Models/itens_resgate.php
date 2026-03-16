<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class itens_resgate extends Model
{
    public $timestamps = false;

    protected $guarded = [
        'subtotal_pontos', 'id'
    ];

    protected $casts = [
        'quantidade' => 'integer',
        'item_catalogo_id' => 'integer',
        'resgate_id' => 'integer',
        'subtotal_pontos' => 'integer'
    ];

    // RELACIONAMENTO ITEM CATALOGO
    public function itemCatalogo(): BelongsTo
    {
        return $this->belongsTo(itens_catalogo::class, 'item_catalogo_id', 'id');
    }

    // RELACIONAMENTO RESGATE
    public function resgate(): BelongsTo
    {
        return $this->belongsTo(resgates::class, 'resgate_id', 'id');
    }
}
