<?php
/**
 * Autor: Alewesley-Sousa
 * Data: 01/03/2026
 * Descrição: model responsavel pelas configurações da tabela referente
 */


namespace App\Models\Status;

use App\Models\resgates;
use Illuminate\Database\Eloquent\Model;

class status_resgate extends Model
{
    // RELACIONAMENTO RESGATE
    public function resgates()
    {
        return $this->hasOne(resgates::class, 'status_id', 'id');
    }
}
