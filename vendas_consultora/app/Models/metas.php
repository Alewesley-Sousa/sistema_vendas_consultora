<?php

namespace App\Models;

use App\Models\usuarios;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class metas extends Model
{
    public $timestamps = false;

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'consultora_id' => 'integer',
        'lider_id' => 'integer',
        'status_id' => 'integer',
        'valor_meta' => 'decimal:2',
        'data_referencia' => 'date',
    ];

    // RELACIONAMENTO LIDER/CONSULTORA
    public function lider(): BelongsTo
    {
        return $this->belongsTo(usuarios::class, 'lider_id', 'id');
    }

    public function consultora(): BelongsTo
    {
        return $this->belongsTo(usuarios::class, 'consultora_id', 'id');
    }
}
