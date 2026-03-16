<?php

namespace App\Models;

use App\Models\catalogos;
use App\Models\Status\status_resgate;
use App\Models\usuarios;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class resgates extends Model
{
    public $tiemstamps = false;

    protected $guarded = [
        'id', 'usuario_responsavel'
    ];

    protected $casts = [
        'total_pontos' => 'integer',
        'consultora_id' => 'integer',
        'catalogo_id' => 'integer',
        'status_id' => 'integer',
        'usuario_responsavel' => 'integer'
    ];

    // RELACIONAMENTO ITENS RESGATE
    public function itensResgate(): HasMany
    {
        return $this->hasMany(itens_resgate::class, 'resgate_id', 'id');
    }

    // RELACIONAMENTO CONSULTORA
    public function consultora(): BelongsTo
    {
        return $this->belongsTo(usuarios::class, 'consultora_id', 'id');
    }

    // RELACIONAMENTO CATALOGO
    public function catalogo(): BelongsTo
    {
        return $this->belongsTo(catalogos::class, 'catalogo_id', 'id');
    }

    // RELACIONAMENTO STATUS RESGATE
    public function status(): BelongsTo
    {
        return $this->belongsTo(status_resgate::class, 'status_id', 'id');
    }
}
