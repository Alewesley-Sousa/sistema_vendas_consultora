<?php

namespace App\Models;

use App\Models\itens_catalogo;
use App\Models\resgates;
use App\Models\Status\status_catalogo;
use App\Models\Tipos\tipo_catalogo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes; // <-- Importante

class catalogos extends Model
{
    use SoftDeletes; // <-- Habilita o Soft Delete

    public $timestamps = false;

    protected $guarded = [
        'id'
    ];

    // Como você não usa timestamps normais, mapeamos apenas o delete
    const DELETED_AT = 'deleted_at'; 

    protected $casts = [
        'nome'              => 'string',
        'tipo_catalogo_id'  => 'integer',
        'status_id'         => 'integer',
        'descricao'         => 'string',
        'data_encerramento' => 'date',
        'data_publicacao'   => 'date'
    ];

    // Retorna catálogos ativos com prazo expirado
    public function scopeExpirados($query)
    {
        return $query->where('status_id', '1')
                     ->whereNotNull('data_encerramento')
                     ->where('data_encerramento', '<', now());
    }

    // RELACIONAMENTO STATUS CATALOGO
    public function categoriaStatus()
    {
        return $this->belongsTo(status_catalogo::class, 'status_id', 'id');
    }

    // RELACIONAMENTO TIPO CATALOGO
    public function categoriaTipo()
    {
        return $this->belongsTo(tipo_catalogo::class, 'tipo_catalogo_id', 'id');
    }

    // RELACIONAMENTO ITENS CATALOGO
    public function itensCatalogo()
    {
        return $this->hasMany(itens_catalogo::class, 'catalogo_id', 'id');
    }

    // RELACIONAMENTO RESGATE
    public function resgates(): HasMany
    {
        return $this->hasMany(resgates::class, 'catalogo_id', 'id');
    }
}
