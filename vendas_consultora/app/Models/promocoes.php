<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\itens_promocao;

class promocoes extends Model
{
    public $timestamps = false;

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'nome' => 'string',
        'desconto' => 'decimal',
        'descricao' => 'string',
        'tipo_promocao_id' => 'integer',
        'data_inicio' => 'date',
        'data_fim' => 'date',
        'status_id' => 'integer'
    ];

    // RELACIONAMENTO ITENS PROMOÇÃO
    public function itensPromocao(): HasMany
    {
        return $this->hasMany(itens_promocao::class, 'promocao_id', 'id');
    }
}
