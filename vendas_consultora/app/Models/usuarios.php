<?php
/**
 * Autor: Alewesley-Sousa
 * Data: 01/03/2026
 * Descrição: model responsavel pelas configurações da tabela referente
 */


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class usuarios extends Model
{
    protected $guarded = 
    [
        'id', 'cargo',    'remember_token'
    ];

    protected $hidden = 
    [
        'senha', 'remember_token'
    ];

    protected $casts = 
    [
        'nome' => 'string',
        'cargo' => 'string',
        'email' => 'string',
        'telefone' => 'string',
        'senha' => 'hashed',
        'cep' => 'encrypted',
    ];

    public function getAuthPassword()
    {
        return $this->senha;
    }
}
