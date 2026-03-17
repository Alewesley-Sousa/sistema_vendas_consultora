<?php
/**
 * Autor: Alewesley-Sousa
 * Data: 01/03/2026
 * Descrição: model responsavel pelas configurações da tabela referente
 */


namespace App\Models\Status;

use App\Models\usuarios;
use Illuminate\Database\Eloquent\Model;

class status_consultora extends Model
{
    // RELACIONAMENTO USUARIO
    public function usuarios()
    {
        return $this->hasMany(usuarios::class, 'status_id', 'id');
    }
}
