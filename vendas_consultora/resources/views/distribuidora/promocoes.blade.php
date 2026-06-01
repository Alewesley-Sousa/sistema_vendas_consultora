@extends('layouts.appAdmin')

@section('title', 'Glow | Promoções')

@section('header', 'Gestão de Promoções')

@section('content')
<section class="space-y-6">
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-lg font-bold text-slate-900">Promoções cadastradas</h3>
                <p class="text-xs text-slate-400 mt-1">Acompanhe campanhas ativas, expiradas e seus períodos de vigência.</p>
            </div>

            <button type="button" class="inline-flex items-center justify-center gap-2 rounded-xl bg-slate-900 px-4 py-3 text-xs font-semibold uppercase tracking-wider text-white transition hover:bg-slate-800">
                <span class="text-base leading-none">+</span>
                Nova Promoção
            </button>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Nome</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Status</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Início</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Fim</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($promocoes as $promocao)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-6 py-4 text-sm font-semibold text-slate-900">{{ $promocao['nome'] }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-full px-3 py-1 text-[11px] font-bold {{ $promocao['status'] === 'Ativa' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $promocao['status'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs font-medium text-slate-500">{{ \Carbon\Carbon::parse($promocao['data_inicio'])->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-xs font-medium text-slate-500">{{ \Carbon\Carbon::parse($promocao['data_fim'])->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-sm text-slate-400">Nenhuma promoção cadastrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
