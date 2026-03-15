<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Status\status_catalogo;
use App\Models\Tipo\tipo_catalogo;

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

    public function categoriaStatus() {
        return $this->hasOne(status_catalogo::class, 'status_id', 'id');
    }

    public function categoriaTipo() {
        return $this->hasOne(tipo_catalogo::class, 'tipo_categoria_id', 'id');
    }
    
}
