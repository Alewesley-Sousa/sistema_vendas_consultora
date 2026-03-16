<?php
/**
 * Autor: Alewesley-Sousa
 * Data: 01/03/2026
 * Descrição: model responsavel pelas configurações da tabela referente
 */


namespace App\Models;

use App\Models\categorias;
use App\Models\estoques;
use App\Models\itens_catalogo;
use App\Models\itens_pedido;
use App\Models\itens_promocao;
use App\Models\movimentacao_estoque;
use App\Models\Status\status_produto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    // RELACIONAMENTO CATEGORIA
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(categorias::class, 'categoria_id', 'id');
    }

    // RELACIONAMENTO STATUS PRODUTOS
    public function status(): BelongsTo
    {
        return $this->belongsTo(status_produto::class, 'status_id', 'id');
    }

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

    // RELACIONAMENTO ITENS PEDIDOS
    public function itensPedidos(): HasMany
    {
        return $this->hasMany(itens_pedido::class, 'produto_id', 'id');
    }

    // RELACIONAMENTO ITENS PROMOÇÃO
    public function itensPromocao(): HasMany
    {
        return $this->hasMany(itens_promocao::class, 'produto_id', 'id');
    }

    // RELACIONAMENTO MOVIMENTAÇÃO ESTOQUE
    public function movimentacaoEstoque(): HasMany
    {
        return $this->hasMany(movimentacao_estoque::class, 'produto_id', 'id');
    }
}
