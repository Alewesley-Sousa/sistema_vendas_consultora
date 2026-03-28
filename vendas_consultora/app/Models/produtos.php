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
use Illuminate\Support\Carbon;

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

    // Adicione isso para que o JSON contenha os campos calculados
    protected $appends = [
        'preco_final',
        'tem_promocao'
    ];

    /**
     * ACCESSOR: preco_final
     * Agora lê o desconto diretamente da tabela pivô (itens_promocao)
     */
    public function getPrecoFinalAttribute()
    {
        $valorOriginal = $this->preco;

        // Buscamos o vínculo ativo que tenha uma promoção pai também ativa e no prazo
        $vinculoPromo = $this->itensPromocao()->where('status_id', 1)->with('promocao', function ($query) {
            $query->where('status_id', 1);
            // ->where('data_inicio', '<=', Carbon::now())
            // ->where('data_fim', '>=', Carbon::now());
            })->first();

        if (!$vinculoPromo) {
            return $valorOriginal;
        }

        // IMPORTANTE: O valor e o tipo agora vêm do $vinculoPromo (itens_promocao)
        $tipoId = $vinculoPromo->tipo_promocao_id;
        $valorDesconto = $vinculoPromo->valor_desconto;

        switch ($tipoId) {
            case 1: // Porcentagem
                return $valorOriginal - ($valorOriginal * ($valorDesconto / 100));

            case 2: // Valor Fixo (Ajustei o ID para 2 conforme o padrão comum)
                $resultado = $valorOriginal - $valorDesconto;
                return $resultado > 0 ? $resultado : 0;

            case 4: // Pague X Leve Y (Combo)
                return $valorOriginal; // Desconto calculado no total do carrinho

            default:
                return $valorOriginal;
        }
    }

    /**
     * ACCESSOR: tem_promocao
     */
    public function getTemPromocaoAttribute(): bool
    {
        return $this->itensPromocao()->with('promocao', function ($query) {
            $query->where('status_id', 1);
            // ->where('data_inicio', '<=', Carbon::now())
            // ->where('data_fim', '>=', Carbon::now());
        })->exists();
    }


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
