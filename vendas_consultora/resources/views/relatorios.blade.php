@extends('layouts.app')

@section('title', 'Relatórios de Performance')
@section('header-icon', 'fas fa-file-invoice-dollar')
@section('header-title', 'Relatórios de Performance')

@push('styles')
<style>
    .back-btn {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      color: var(--primary);
      text-decoration: none;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .kpi-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 20px;
      margin-bottom: 30px;
    }

    .kpi-card {
      background: white;
      padding: 20px;
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      text-align: center;
      border-bottom: 4px solid var(--primary);
    }

    .kpi-card h4 { margin: 0; color: #7f8c8d; font-size: 0.9rem; text-transform: uppercase; }
    .kpi-card .value { font-size: 1.8rem; font-weight: bold; color: var(--dark-sidebar); margin: 10px 0; }
    .kpi-card .trend { font-size: 0.85rem; color: #27ae60; }

    .charts-row {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 25px;
      margin-bottom: 30px;
    }

    .chart-box {
      background: white;
      padding: 25px;
      border-radius: var(--radius);
      box-shadow: var(--shadow);
    }

    .chart-box h3 { margin-top: 0; font-size: 1.1rem; margin-bottom: 20px; color: var(--dark-sidebar); }

    @media (max-width: 768px) {
        .charts-row { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
    <a href="{{ route('dev.dashboard') }}" class="back-btn"><i class="fas fa-arrow-left"></i> Voltar ao Dashboard</a>

    <div class="kpi-grid">
      <div class="kpi-card">
        <h4>Vendas Mensais</h4>
        <div class="value">R$ 62.300</div>
        <div class="trend"><i class="fas fa-caret-up"></i> 12% vs mês anterior</div>
      </div>
      <div class="kpi-card" style="border-bottom-color: var(--primary-dark)">
        <h4>Comissões Geradas</h4>
        <div class="value">R$ 8.540</div>
        <div class="trend"><i class="fas fa-caret-up"></i> 5% vs mês anterior</div>
      </div>
      <div class="kpi-card" style="border-bottom-color: var(--gold)">
        <h4>Meta Atingida</h4>
        <div class="value">124%</div>
        <div class="trend">Status: Superado</div>
      </div>
      <div class="kpi-card" style="border-bottom-color: var(--dark-sidebar)">
        <h4>Ticket Médio</h4>
        <div class="value">R$ 185,00</div>
        <div class="trend"><i class="fas fa-caret-down"></i> 2% vs mês anterior</div>
      </div>
    </div>

    <div class="charts-row">
      <div class="chart-box">
        <h3>Evolução de Vendas (Últimos 6 meses)</h3>
        <canvas id="vendasChart" height="250"></canvas>
      </div>
      <div class="chart-box">
        <h3>Vendas por Categoria</h3>
        <canvas id="categoriaChart" height="250"></canvas>
      </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
      const ctxVendas = document.getElementById('vendasChart').getContext('2d');
      new Chart(ctxVendas, {
        type: 'line',
        data: {
          labels: ['Out', 'Nov', 'Dez', 'Jan', 'Fev', 'Mar'],
          datasets: [{
            label: 'Vendas Totais (R$)',
            data: [42000, 48000, 65000, 52000, 58000, 62300],
            borderColor: '#FF6F61',
            backgroundColor: 'rgba(255, 111, 97, 0.1)',
            fill: true,
            tension: 0.4
          }]
        },
        options: { responsive: true, maintainAspectRatio: false }
      });

      const ctxCat = document.getElementById('categoriaChart').getContext('2d');
      new Chart(ctxCat, {
        type: 'doughnut',
        data: {
          labels: ['Perfumaria', 'Corpo', 'Maquiagem', 'Óleos'],
          datasets: [{
            data: [45, 25, 20, 10],
            backgroundColor: ['#FF6F61', '#FF1493', '#FF69B4', '#FFD700']
          }]
        },
        options: { responsive: true, maintainAspectRatio: false }
      });
    });
</script>
@endpush