<?php
/**
 * Autor: Alewesley-Sousa
 * Data: 01/03/2026
 * Descrição: model responsavel pelas configurações da tabela referente
 */

namespace App\Models\Status;

use Illuminate\Database\Eloquent\Model;
use App\Models\catalogos;

class status_catalogo extends Model
{
    public function catalogos() {
        return $this->hasMany(catalogos::class, 'status_id', 'id');
    }
}
