<?php
/**
 * Autor: Alewesley-Sousa
 * Data: 01/03/2026
 * Descrição: model responsavel pelas configurações da tabela referente
 */


namespace App\Models\Tipos;

use App\Models\historico_comissoes;
use Illuminate\Database\Eloquent\Model;

class tipo_movimentacao_comissao extends Model
{
    public $timestamps = false;
    protected $table = 'tipo_movimentacao_comissao';

    // RELACIONAMENTO HISTÓRICO COMISSÕES
    public function historicoComissoes()
    {
        return $this->hasMany(historico_comissoes::class, 'tipo_movimentacao_id', 'id');
    }
}
