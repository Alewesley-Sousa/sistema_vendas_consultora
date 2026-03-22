@extends('layouts.app')

@section('conteudo')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="bg-white rounded-3xl shadow-lg p-8 border border-slate-100">
        
        <div class="mb-8">
            <h1 id="titulo-pagina" class="text-2xl font-extrabold text-slate-800">
                @if(auth()->user()->cargo === 'distribuidora')
                    {{ isset($id) ? 'Atualizando Usuário' : 'Cadastrando Usuário' }}
                @else
                    Pré-cadastramento de Consultora
                @endif
            </h1>
            <p class="text-slate-500 text-sm">Preencha os dados abaixo com atenção.</p>
        </div>

        <form id="form-usuario" class="space-y-5">
            <div class="form-group">
                <label class="block text-sm font-bold text-slate-700 mb-1">Nome Completo</label>
                <input type="text" name="nome" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition-all" placeholder="Ex: Maria Oliveira" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-group">
                    <label class="block text-sm font-bold text-slate-700 mb-1">E-mail</label>
                    <input type="email" name="email" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition-all" placeholder="email@exemplo.com" required>
                </div>

                <div class="form-group">
                    <label class="block text-sm font-bold text-slate-700 mb-1">CPF</label>
                    <input type="text" id="input-cpf" name="cpf" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition-all" placeholder="000.000.000-00" maxlength="14" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-group">
                    <label class="block text-sm font-bold text-slate-700 mb-1">Telefone</label>
                    <input type="text" id="input-telefone" name="telefone" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition-all" placeholder="(85) 9.9999-9999">
                </div>

                <div class="form-group">
                    <label class="block text-sm font-bold text-slate-700 mb-1">CEP</label>
                    <input type="text" id="input-cep" name="cep" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition-all" placeholder="00000-000" required>
                </div>
            </div>

            <div class="form-group">
                <label class="block text-sm font-bold text-slate-700 mb-1">Senha de Acesso</label>
                <input type="password" name="senha" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition-all" placeholder="Mínimo 8 caracteres">
                @if(isset($id))
                    <small class="text-slate-400 font-medium">Deixe em branco para manter a senha atual.</small>
                @endif
            </div>

            <hr class="border-slate-100 my-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-group">
                    <label class="block text-sm font-bold text-slate-700 mb-1">Status da Conta</label>
                    <select name="status_id" id="status_id" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none appearance-none bg-slate-50 font-medium" 
                        {{ auth()->user()->cargo !== 'distribuidora' ? 'disabled' : 'required' }}>
                        <option value="">Selecione...</option>
                        @foreach($status as $s)
                            <option value="{{ $s->id }}" 
                                {{ auth()->user()->cargo !== 'distribuidora' && $s->id == 3 ? 'selected' : '' }}>
                                {{ $s->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Cargo só aparece para Distribuidora --}}
                @if(auth()->user()->cargo === 'distribuidora')
                <div id="container-cargo" class="form-group">
                    <label class="block text-sm font-bold text-slate-700 mb-1">Cargo no Sistema</label>
                    <select name="cargo" class="w-full px-4 py-3 rounded-xl border border-indigo-200 bg-indigo-50 text-indigo-700 font-bold outline-none">
                        <option value="consultora">Consultora</option>
                        <option value="lider">Líder</option>
                        <option value="distribuidora">Distribuidora</option>
                    </select>
                </div>
                @endif
            </div>

            <div class="pt-6">
                <button type="submit" id="btn-salvar" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold rounded-2xl transition-all shadow-lg shadow-indigo-100 flex items-center justify-center gap-2">
                    <i class="fas fa-check-circle"></i> SALVAR CADASTRO
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    window.usuarioId = @json($id ?? null);
    window.authCargo = @json(auth()->user()->cargo);
</script>
@endsection