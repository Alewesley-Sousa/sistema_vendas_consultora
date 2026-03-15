<?php

namespace App\Models;

use App\Models\usuarios;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class comissoes extends Model
{
    protected $fillable = [
        'consultora_id'
    ];

    protected $casts = [
        'consultora_id' => 'integer',
        'saldo_liquido' => 'decimal:2'
    ];

    public function usuarios(): BelongsTo
    {
        return $this->belongsTo(usuarios::class, 'consultora_id', 'id');
    }
}
