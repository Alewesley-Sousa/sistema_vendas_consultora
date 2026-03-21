@extends('layouts.app')

@section('conteudo')
<div class="min-h-screen bg-slate-50 py-12 px-4">
    <div class="max-w-xl mx-auto">
        
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 id="titulo-pagina" class="text-2xl font-black text-slate-800 tracking-tight">
                    Carregando...
                </h1>
                <p class="text-slate-500 text-sm">Preencha os dados para salvar no sistema.</p>
            </div>
            <a href="/clientes" class="text-slate-400 hover:text-slate-600 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </a>
        </div>

        <form id="form-cliente" class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <div class="p-8 space-y-6">
                
                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider ml-1">Nome Completo</label>
                    <input type="text" name="nome" placeholder="Ex: Maria Oliveira" required
                        class="w-full px-5 py-3.5 bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white rounded-2xl transition-all outline-none text-slate-700 font-medium">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider ml-1">CPF</label>
                        <input type="text" name="cpf" id="input-cpf" placeholder="000.000.000-00" maxlength="14" required
                            class="w-full px-5 py-3.5 bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white rounded-2xl transition-all outline-none text-slate-700 font-medium">
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider ml-1">Telefone</label>
                        <input type="text" name="telefone" id="input-telefone" placeholder="(85) 9..."
                            class="w-full px-5 py-3.5 bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white rounded-2xl transition-all outline-none text-slate-700 font-medium">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider ml-1">E-mail de Contato</label>
                    <input type="email" name="email" placeholder="cliente@email.com" required
                        class="w-full px-5 py-3.5 bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white rounded-2xl transition-all outline-none text-slate-700 font-medium">
                </div>

                <div class="w-1/2 space-y-1">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider ml-1">CEP</label>
                    <input type="text" name="cep" id="input-cep" placeholder="60000-000" maxlength="9"
                        class="w-full px-5 py-3.5 bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white rounded-2xl transition-all outline-none text-slate-700 font-medium">
                </div>
            </div>

            <div class="p-6 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-400 font-medium">* Campos obrigatórios</span>
                <button type="submit" id="btn-salvar" 
                    class="px-10 py-3.5 bg-slate-900 hover:bg-blue-600 text-white font-bold rounded-2xl transition-all active:scale-95 shadow-lg shadow-slate-200 disabled:opacity-50">
                    Salvar Dados
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    // Passamos o ID se ele vier do Controller (Editar) ou null (Criar)
    window.clienteId = @json($id ?? null);
</script>
@endsection