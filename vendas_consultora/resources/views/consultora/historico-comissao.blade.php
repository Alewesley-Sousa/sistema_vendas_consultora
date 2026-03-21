@extends('layouts.app')
@section('conteudo')
<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Histórico de Comissões</h1>
            <p class="text-sm text-slate-500">Acompanhe seus ganhos e movimentações.</p>
        </div>
        <div id="status-badge" class="hidden animate-pulse px-3 py-1 bg-pink-100 text-pink-600 rounded-full text-xs font-bold">
            Atualizando...
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th id="sort-data" class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider cursor-pointer hover:bg-slate-100 transition-colors">
                            Data <span class="sort-icon text-pink-500"></span>
                        </th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">
                            Referência
                        </th>
                        <th id="sort-valor" class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider cursor-pointer hover:bg-slate-100 transition-colors">
                            Valor <span class="sort-icon text-pink-500"></span>
                        </th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="...">Origem</th> 
                    </tr>
                </thead>
                <tbody id="tabela-comissao-corpo" class="divide-y divide-slate-100 text-sm text-slate-700">
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-400 italic">
                            Carregando registros...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div id="paginacao-historico" class="mt-6 flex justify-center items-center gap-4">
        </div>
</div>
@endsection