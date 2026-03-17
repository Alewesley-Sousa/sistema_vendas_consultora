<?php
/**
 * Autor: Alewesley-Sousa
 * Data: 01/03/2026
 * Descrição: model responsavel pelas configurações da tabela referente
 */


namespace App\Models\Tipos;

use App\Models\devolucoes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class tipo_devolucao extends Model
{
    public $timestamps = false;
    protected $table = 'tipo_devolucao';
    
    // RELACIONAMENTO DEVOLUCAO
    public function devolucao(): HasMany
    {
        return $this->hasMany(devolucoes::class, 'tipo_devolucao_id', 'id');
    }
}
