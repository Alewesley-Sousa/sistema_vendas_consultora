<?php
/**
 * Autor: Alewesley-Sousa
 * Data: 01/03/2026
 * Descrição: model responsavel pelas configurações da tabela referente
 */


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class categorias extends Model
{
    public $timestamps = false;

    protected $fillable = ['nome', 'descricao'];

    protected $casts = [
        'nome' => 'string',
        'descricao' => 'string'
    ];
}
