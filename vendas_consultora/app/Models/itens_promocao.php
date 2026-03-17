<?php

namespace App\Models;

use App\Models\produtos;
use App\Models\promocoes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class itens_promocao extends Model
{
    public $timestamps = false;
    protected $table = 'itens_promocao';
    protected $guarded = [
        'id'
    ];

    protected $casts = [
      'produto_id' => 'integer',
      'promocao_id' => 'integer',
      'quantidade_min' => 'integer',
      'condicao_especial' => 'string'
    ];

    // RELACIONAMENTO PRODUTO
    public function produto(): BelongsTo
    {
        return $this->belongsTo(produtos::class, 'produto_id', 'id');
    }

    // RELACIONAMENTO PROMOÇÃO
    public function promocao(): BelongsTo
    {
        return $this->belongsTo(promocoes::class, 'promocao_id', 'id');
    }
}
