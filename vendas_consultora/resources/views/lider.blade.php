@extends('layouts.app')

@section('title', 'Dashboard - Líder')
@section('header-icon', 'fas fa-users')
@section('header-title', 'Dashboard — Líder')

@push('styles')
<style>
    .container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 22px;
    }
    .card {
        background: var(--card-bg);
        border-radius: var(--radius);
        padding: 22px;
        box-shadow: var(--shadow);
        border-top: 5px solid var(--primary);
    }
    .card h2 { margin-top: 0; font-size: 1.15rem; color: var(--dark-sidebar); }
    .metrics { display: flex; gap: 12px; flex-wrap: wrap; }
    .metric { flex: 1; min-width: 120px; background: rgba(0,0,0,0.03); padding: 12px; border-radius: 10px; text-align:center }
    .btn-small { padding: 8px 12px; border-radius: 10px; border: none; background: var(--primary); color: white; cursor: pointer }
</style>
@endpush

@section('content')
    <div class="container">
        <div class="card">
            <h2><i class="fas fa-users"></i> Minha Equipe</h2>
            <p>Visão geral das consultoras da sua equipe, performance e necessidades de apoio.</p>
            <div class="metrics" style="margin-top:12px">
                <div class="metric">
                    <div style="font-weight:700; font-size:1.4rem">{{ $totalConsultoras ?? '-' }}</div>
                    <div style="font-size:0.9rem; color:var(--text-muted)">Consultoras</div>
                </div>
                <div class="metric">
                    <div style="font-weight:700; font-size:1.4rem">{{ $vendasMes ?? '-' }}</div>
                    <div style="font-size:0.9rem; color:var(--text-muted)">Vendas (mês)</div>
                </div>
                <div class="metric">
                    <div style="font-weight:700; font-size:1.4rem">{{ $metaCumprida ?? '-' }}%</div>
                    <div style="font-size:0.9rem; color:var(--text-muted)">Meta média</div>
                </div>
            </div>
            <div style="margin-top:14px">
                <button class="btn-small" onclick="location.href='{{ route('cliente.listar') }}'">Gerenciar Consultoras</button>
                <button class="btn-small" style="margin-left:8px" onclick="location.href='{{ url('relatorios') }}'">Ver Relatórios</button>
            </div>
        </div>

        <div class="card">
            <h2><i class="fas fa-bullseye"></i> Metas da Equipe</h2>
            <p>Defina e acompanhe metas por consultora ou por período.</p>
            <ul>
                <li>Meta total: R$ {{ $metaTotal ?? '0,00' }}</li>
                <li>Consultoras com meta cumprida: {{ $consultorasCumpriram ?? 0 }}</li>
            </ul>
            <button class="btn-small" onclick="location.href='{{ url('relatorios') }}'">Ajustar Metas</button>
        </div>

        <div class="card">
            <h2><i class="fas fa-wallet"></i> Comissões da Equipe</h2>
            <p>Resumo de comissões acumuladas e pendentes para sua equipe.</p>
            <ul>
                <li>Total a pagar: R$ {{ $comissoesTotais ?? '0,00' }}</li>
                <li>Pagamentos pendentes: {{ $comissoesPendentes ?? 0 }}</li>
            </ul>
            <button class="btn-small" onclick="location.href='{{ url('comissao/historico') }}'">Histórico de Comissões</button>
        </div>

        <div class="card">
            <h2><i class="fas fa-chart-line"></i> Performance</h2>
            <p>Gráficos rápidos e ranking interno por vendas.</p>
            <ul>
                <li>Top 3 consultoras do mês</li>
                <li>Consultoras com queda de desempenho</li>
            </ul>
            <button class="btn-small" onclick="location.href='{{ url('relatorios') }}'">Abrir Painel</button>
        </div>

        <div class="card">
            <h2><i class="fas fa-user-plus"></i> Recrutamento</h2>
            <p>Ferramentas rápidas para cadastrar novas consultoras e acompanhar indicações.</p>
            <button class="btn-small" onclick="location.href='{{ url('cadastro-consultora') }}'">Cadastrar Consultora</button>
        </div>
    </div>
@endsection
