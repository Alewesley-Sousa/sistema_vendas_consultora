<?php
/**
 * Autor: Alewesley-Sousa
 * Data: 01/03/2026
 * Descrição: model responsavel pelas configurações da tabela referente
 */


namespace App\Models;

use App\Models\produtos;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class categorias extends Model
{
    public $timestamps = false;

    protected $fillable = ['nome', 'descricao'];

    protected $casts = [
        'nome' => 'string',
        'descricao' => 'string'
    ];

    // RELACIONAMENTO PRODUTOS
    public function produtos(): HasMany
    {
        return $this->hasMany(produtos::class, 'categoria_id', 'id');
    }
}
