<?php
/**
 * Autor: Alewesley-Sousa
 * Data: 01/03/2026
 * Descrição: model responsavel pelas configurações da tabela referente
 */


namespace App\Models\Tipos;

use Illuminate\Database\Eloquent\Model;
use App\Models\catalogos;

class tipo_catalogo extends Model
{
    public $timestamps = false;

    protected $table = 'tipo_catalogo';

    public function catalogos() {
        return $this->hasMany(catalogos::class, 'tipo_categoria_id', 'id');
    }
}
