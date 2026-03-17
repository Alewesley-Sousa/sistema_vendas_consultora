<?php

namespace App\Models;

use App\Models\itens_catalogo;
use App\Models\resgates;
use App\Models\Status\status_catalogo;
use App\Models\Tipo\tipo_catalogo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class catalogos extends Model
{
    public $timestamps = false;

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'nome' => 'string',
        'tipo_categoria_id' => 'integer',
        'status_id' => 'integer',
        'descricao' => 'string',
        'data_encerramento' => 'date',
        'data_publicacao' => 'date'
    ];

    // RELACIONAMENTO STATUS CATEGORIA
    public function categoriaStatus() {
        return $this->belongsTo(status_catalogo::class, 'status_id', 'id');
    }

    // RELACIONAMENTO TIPO CATEGORIA
    public function categoriaTipo() {
        return $this->belongsTo(tipo_catalogo::class, 'tipo_categoria_id', 'id');
    }

    // RELACIONAMENTO ITENS CATALOGO
    public function itensCatalogo() {
        return $this->hasMany(itens_catalogo::class, 'catalogo_id', 'id');
    }

    // RELACIONAMENTO RESGATE
    public function resgates(): HasMany
    {
        return $this->hasMany(resgates::class, 'catalogo_id', 'id');
    }
}
