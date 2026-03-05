<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class logs extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'detalhes', 'data_hora'
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
}
