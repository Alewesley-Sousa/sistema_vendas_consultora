<?php
/**
 * Autor: Alewesley-Sousa
 * Data: 01/03/2026
 * Descrição: model responsavel pelas configurações da tabela referente
 */


namespace App\Models;

use App\Models\produtos;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class estoques extends Model
{
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'produto_id' => 'integer',
        'quantidade' => 'integer'
    ];

    // RELACIONAMENTO PRODUTO
    public function produto(): BelongsTo
    {
        return $this->belongsTo(produtos::class, 'produto_id', 'id');
    }
}
