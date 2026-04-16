@extends('layouts.app')

@section('title', 'Dashboard - Sistema de Vendas')
@section('header-icon', 'fas fa-chart-line')
@section('header-title', 'Dashboard')

@push('styles')
<style>
    .container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
      gap: 30px;
    }

    .card {
      background: var(--card-bg);
      border-radius: var(--radius);
      padding: 25px;
      box-shadow: var(--shadow);
      transition: all 0.3s ease;
      display: flex;
      flex-direction: column;
      border: none;
      border-top: 5px solid var(--primary);
    }

    .card:hover {
      transform: translateY(-8px);
      box-shadow: 0 15px 35px rgba(255, 111, 97, 0.15);
    }

    h2 {
      margin-top: 0;
      font-size: 1.3rem;
      color: var(--dark-sidebar);
      display: flex;
      align-items: center;
      gap: 12px;
      border-bottom: 2px solid var(--background);
      padding-bottom: 15px;
      margin-bottom: 20px;
    }

    h2 i {
      color: var(--primary);
    }

    .actions {
      display: flex;
      flex-direction: column;
      gap: 12px;
    }

    .actions button {
      background: rgba(255, 111, 97, 0.05);
      color: var(--primary);
      border: 1.5px solid rgba(255, 111, 97, 0.3);
      padding: 12px 18px;
      border-radius: 12px;
      cursor: pointer;
      font-weight: 700;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .actions button:hover {
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      color: white;
      border-color: transparent;
    }

    .btn-filled {
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: white;
      border: none;
      padding: 12px;
      border-radius: 12px;
      font-weight: bold;
      cursor: pointer;
      margin-top: auto;
      transition: all 0.3s ease;
    }

    .btn-filled:hover {
      transform: scale(1.03);
      box-shadow: 0 6px 20px rgba(255, 111, 97, 0.4);
    }

    ul {
      list-style: none;
      padding: 0;
      margin: 0 0 20px 0;
    }

    ul li {
      padding: 8px 0;
      color: var(--text-muted);
    }
</style>
@endpush

@section('content')
  <div class="container">
    <!-- Card de Ações -->
    <div class="card">
      <h2><i class="fas fa-tasks"></i> Ações Rápidas</h2>
      <div class="actions">
        <button onclick="location.href='{{ url('clientes') }}'"><i class="fas fa-users"></i> Clientes</button>
        <button onclick="location.href='{{ url('cadastro-consultora') }}'"><i class="fas fa-user-tie"></i> Nova Consultora</button>
        <button onclick="location.href='{{ url('pedidos-clientes') }}'"><i class="fas fa-cart-plus"></i> Criar Pedido</button>
        <button onclick="location.href='{{ url('relatorios') }}'"><i class="fas fa-history"></i> Relatórios</button>
      </div>
    </div>

    <!-- Histórico de Comissões -->
    <div class="card">
      <h2><i class="fas fa-wallet"></i> Comissões</h2>
      <ul>
        <li>Visualizar registro de histórico</li>
        <li>Ver total acumulado</li>
      </ul>
      <button class="btn-filled" onclick="location.href='{{ url('relatorios') }}'">Abrir Histórico</button>
    </div>

    <!-- Cadastro de Cliente -->
    <div class="card">
      <h2><i class="fas fa-users"></i> Clientes</h2>
      <ul>
        <li>Formulário para cadastrar clientes</li>
        <li>Gestão de base ativa</li>
      </ul>
      <button class="btn-filled" onclick="location.href='{{ url('clientes') }}'">Gerenciar Clientes</button>
    </div>

    <!-- Cadastro de Consultoras -->
    <div class="card">
      <h2><i class="fas fa-id-card"></i> Consultoras</h2>
      <ul>
        <li>Formulário para cadastrar consultoras</li>
        <li>Monitoramento de desempenho</li>
      </ul>
      <button class="btn-filled" onclick="location.href='{{ url('cadastro-consultora') }}'">Gerenciar Equipe</button>
    </div>

    <!-- Estoque da Loja -->
    <div class="card">
      <h2><i class="fas fa-book-open"></i> Catálogo de Vendas</h2>
      <ul>
        <li>Visualizar produtos disponíveis</li>
        <li>Preços e categorias</li>
        <li>Novidades da revista</li>
      </ul>
      <button class="btn-filled" onclick="location.href='{{ url('catalogo-vendas') }}'">Ver Catálogo</button>
    </div>

    <!-- Pedido Link -->
    <div class="card">
      <h2><i class="fas fa-link"></i> Venda Online</h2>
      <ul>
        <li>Ver subtotais e frete</li>
        <li>Gerar link de pagamento</li>
      </ul>
      <button class="btn-filled" onclick="location.href='{{ url('venda-online') }}'">Gerar Link</button>
    </div>
  </div>
@endsection