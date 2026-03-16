<?php

namespace App\Models;

// Importante: Troque 'Model' por 'Authenticatable'

use App\Models\clientes;
use App\Models\comissoes;
use App\Models\historico_cargo;
use App\Models\historico_comissoes;
use App\Models\logs;
use App\Models\metas;
use App\Models\pedidos;
use App\Models\qualificacao_profissional;
use App\Models\resgates;
use App\Models\solicitacoes_saque;
use App\Models\Status\status_consultora;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    //RELACIONAMENTO STATUS CONSULTORA
    public function status(): BelongsTo
    {
        return $this->belongsTo(status_consultora::class, 'status_id', 'id');
    }

    // RELACIONAMENTO SOLICITACAO SAQUE
    public function solicitacoesSaque(): HasMany
    {
        return $this->hasMany(solicitacoes_saque::class, 'consultora_id', 'id');
    }

    // RELACIONAMENTO RESGATE
    public function resgates(): HasMany
    {
        return $this->hasMany(resgates::class, 'consultora_id', 'id');
    }

    // RELACIONAMENTO QUALIFICAÇÃO PROFISSIONAL
    public function qualificacaoProfissional(): HasMany
    {
        return $this->hasMany(qualificacao_profissional::class, 'consultora_id', 'id');
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

    // RELACIONAMENTO HISTORICO CARGO
    public function historicoCargo(): HasMany
    {
        return $this->hasMany(historico_cargo::class, 'consultora_id', 'id');
    }

    //RELACIONAMENTO HISTORICO COMISSOES
    public function historicoComissoes(): HasMany
    {
        return $this->hasMany(historico_comissoes::class, 'consultora_id', 'id');
    }

    // RELACIONAMENTO LOGS
    public function logs(): HasMany
    {
        return $this->hasMany(logs::class, 'usuario_id', 'id');
    }

    // RELACIONAMENTO METAS
    public function metasConsultora(): HasMany
    {
        return $this->hasMany(metas::class, 'consultora_id', 'id');
    }

    public function metasLider(): HasMany
    {
        return $this->hasMany(metas::class, 'lider_id', 'id');
    }

    // RELACIONAMENTO PEDIDOS
    public function pedidos(): HasMany
    {
        return $this->hasMany(pedidos::class, 'consultora_id', 'id');
    }
}