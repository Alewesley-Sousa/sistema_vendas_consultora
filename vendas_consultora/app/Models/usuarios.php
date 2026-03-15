<?php

namespace App\Models;

// Importante: Troque 'Model' por 'Authenticatable'
use App\Models\clientes;
use App\Models\comissoes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;

class usuarios extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios'; // Garantir que a tabela esteja correta

    // Troquei guarded por fillable para maior controle
    protected $fillable = [
        'nome', 'cargo', 'email', 'telefone', 'senha', 'cep', 'consultora_id', 'status_id'
    ];

    protected $hidden = [
        'senha', 'remember_token',
    ];

    protected $casts = [
        'cep'   => 'encrypted',
    ];

    public function getAuthPassword()
    {
        return $this->senha;
    }
    // CLIENTES RELACIONAMENTO
    public function clientes(): HasMany
    {
        return $this->hasMany(clientes::class, 'consultora_id', 'id');
    }

    // COMISSAO RELACIONAMENTO
    public function comissao(): HasOne
    {
        return $this->hasOne(comissoes::class, 'consultora_id', 'id');
    }
}