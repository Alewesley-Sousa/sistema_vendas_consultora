<?php
/**
 * Autor: Alewesley-Sousa
 * Data: 01/03/2026
 * Descrição: model responsavel pelas configurações da tabela referente
 */


namespace App\Models\Status;

use App\Models\metas;
use Illuminate\Database\Eloquent\Model;

class status_meta extends Model
{
    // RELACIONAMENTO METAS
    public function metas()
    {
        return $this->hasMany(metas::class, 'status_id', 'id');
    }
}
