<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\solicitacoes_saque;

class SolicitacoesTable extends Component
{
    // Função para aprovar o saque
    public function aprovar($id)
    {
        SolicitacaoSaque::where('id', $id)->update([
            'status_id' => 2, // Aprovada
            'data_decisao' => now()
        ]);
        
        // Opcional: Adicionar um alerta de sucesso para o admin
        // session()->flash('message', 'Saque aprovado com sucesso.');
    }

    // Função para recusar o saque
    public function recusar($id)
    {
        SolicitacaoSaque::where('id', $id)->update([
            'status_id' => 3, // Rejeitada
            'data_decisao' => now()
        ]);
    }

    public function render()
    {
        return view('components.admin.solicitacoes-table', [
            'saques' => solicitacoes_saque::with('consultora')
                        ->where('status_id', 1) // Apenas Pendentes
                        ->latest('data_solicitacao')
                        ->get()
        ]);
    }
}
