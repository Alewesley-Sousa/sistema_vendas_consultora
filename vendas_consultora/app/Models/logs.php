<?php

namespace App\Models;

use App\Models\usuarios;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class logs extends Model
{
    public $timestamps = false; 

    protected $fillable = [
        'usuario_id',
        'acao',
        'entidade_afetada',
        'registro_afetado_id',
        'data_hora',
        'descricao',
        'ip_origem'
    ];

    protected $casts = [
        'usuario_id' => 'integer',
        'registro_afetado_id' => 'integer',
        'entidade_afetada' => 'string',
        'acao' => 'string',
        'detalhes' => 'string',
        'ip_origem' => 'string',
        'data_hora' => 'datetime'
    ];

    // RELACIONAMENTO USUÁRIO
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(usuarios::class, 'usuario_id', 'id');
    }

    
}
