<?php
/**
 * Autor: Alewesley-Sousa
 * Data: 01/03/2026
 * Descrição: model responsavel pelas configurações da tabela referente
 */


namespace App\Models;

use App\Models\estoques;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class produtos extends Model
{
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];
    
    protected $casts = [
        'nome' => 'string',
        'preco' => 'decimal:2',
        'descricao' => 'string',
        'categoria_id' => 'integer',
        'status_id' => 'integer',
        'imagem_url' => 'string'
    ];

    // RELACIONAMENTO ESTOQUE
    public function estoque(): HasOne
    {
        return $this->hasOne(estoques::class, 'produto_id', 'id');
    }

    // RELACIONAMENTO ITENS CATALOGO
    public function itensCatalogo(): HasMany
    {
        return $this->hasMany(itens_catalogo::class, 'produto_id', 'id');
    }
}
