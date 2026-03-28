<?php

namespace App\Models;

use App\Models\produtos;
use App\Models\promocoes;
use App\Models\Status\status_promocao;
use App\Models\Tipos\tipo_promocao;
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
        'tipo_promocao_id' => 'integer', // Novo
        'valor_desconto' => 'decimal:2',  // Novo
        'quantidade_min' => 'integer',
        'status_id' => 'integer'         // Novo
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

    // RELACIONAMENTO TIPO PROMOÇÃO (INDIVIDUAL POR ITEM)
    public function tipoPromocao(): BelongsTo
    {
        return $this->belongsTo(tipo_promocao::class, 'tipo_promocao_id', 'id');
    }
    
    // RELACIONAMENTO STATUS (INDIVIDUAL POR ITEM)
    public function status(): BelongsTo
    {
        return $this->belongsTo(status_promocao::class, 'status_id', 'id');
    }
}
