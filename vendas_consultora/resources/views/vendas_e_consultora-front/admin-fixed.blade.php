@extends('layouts.app')

@section('title', 'Painel Administrativo - Protótipo')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    .admin-container {
        max-width: 1200px;
        margin: 16px auto;
        padding: 16px;
        min-height: calc(100vh - 32px);
    }

    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
        background: rgba(255, 255, 255, 0.95);
        padding: 16px;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        border: 1px solid #e8ebfa;
    }

    .admin-title h1 {
        color: #333;
        margin: 0;
        font-size: 28px;
    }

    .admin-title p {
        color: #666;
        margin: 5px 0 0 0;
    }

    .admin-actions {
        display: flex;
        gap: 15px;
    }

    .btn-admin {
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }

    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .dashboard-card {
        background: white;
        border-radius: 14px;
        padding: 18px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: 1px solid #eef1ff;
    }

    .dashboard-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }

    .card-header {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .card-icon {
        font-size: 24px;
        margin-right: 15px;
        color: #667eea;
    }

    .card-title {
        font-size: 18px;
        font-weight: bold;
        color: #333;
        margin: 0;
    }

    .card-value {
        font-size: 32px;
        font-weight: bold;
        color: #667eea;
        margin: 10px 0;
    }

    .card-subtitle {
        color: #666;
        font-size: 14px;
    }

    .users-section {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 14px;
        padding: 18px;
        margin-bottom: 24px;
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.08);
        border: 1px solid #edf0ff;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .section-title {
        font-size: 24px;
        font-weight: bold;
        color: #333;
        margin: 0;
    }

    .users-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 16px;
    }

    .users-table th, .users-table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #e9ecff;
        font-size: 14px;
    }

    .users-table th {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-weight: bold;
    }

    .users-table tr:hover {
        background: rgba(102, 126, 234, 0.05);
    }

    .role-badge {
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .role-admin {
        background: #e74c3c;
        color: white;
    }

    .role-cliente {
        background: #27ae60;
        color: white;
    }

    @media (max-width: 768px) {
        .admin-header {
            flex-direction: column;
            gap: 20px;
            text-align: center;
        }

        .admin-actions {
            flex-wrap: wrap;
            justify-content: center;
        }

        .dashboard-grid {
            grid-template-columns: 1fr;
        }

        .section-header {
            flex-direction: column;
            gap: 15px;
        }
    }
</style>
@endpush

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <div class="admin-title">
            <h1>Painel Administrativo</h1>
            <p>Gerencie usuários e clientes do sistema - PROTÓTIPO</p>
        </div>
        <div class="admin-actions">
            <button class="btn-admin btn-primary" onclick="alert('Funcionalidade em desenvolvimento')">
                <i class="fas fa-user-plus"></i> Adicionar Usuário
            </button>
        </div>
    </div>

    <div class="dashboard-grid">
        <div class="dashboard-card">
            <div class="card-header">
                <div class="card-icon"><i class="fas fa-users"></i></div>
                <h3 class="card-title">Total de Usuários</h3>
            </div>
            <div class="card-value">12</div>
            <div class="card-subtitle">Usuários registrados no sistema</div>
        </div>

        <div class="dashboard-card">
            <div class="card-header">
                <div class="card-icon"><i class="fas fa-user-tie"></i></div>
                <h3 class="card-title">Funcionários</h3>
            </div>
            <div class="card-value">5</div>
            <div class="card-subtitle">Usuários com papel de funcionário</div>
        </div>

        <div class="dashboard-card">
            <div class="card-header">
                <div class="card-icon"><i class="fas fa-user"></i></div>
                <h3 class="card-title">Clientes</h3>
            </div>
            <div class="card-value">7</div>
            <div class="card-subtitle">Usuários com papel de cliente</div>
        </div>

        <div class="dashboard-card">
            <div class="card-header">
                <div class="card-icon"><i class="fas fa-chart-bar"></i></div>
                <h3 class="card-title">Clientes Sistema</h3>
            </div>
            <div class="card-value">23</div>
            <div class="card-subtitle">Clientes cadastrados no sistema</div>
        </div>
    </div>

    <div class="users-section">
        <div class="section-header">
            <h2 class="section-title">Gerenciamento de Usuários</h2>
        </div>
        <table class="users-table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Papel</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Maria Silva</td>
                    <td>maria@exemplo.com</td>
                    <td><span class="role-badge role-admin">Admin</span></td>
                    <td>Ativo</td>
                </tr>
                <tr>
                    <td>João Santos</td>
                    <td>joao@exemplo.com</td>
                    <td><span class="role-badge role-cliente">Cliente</span></td>
                    <td>Ativo</td>
                </tr>
                <tr>
                    <td>Ana Costa</td>
                    <td>ana@exemplo.com</td>
                    <td><span class="role-badge role-cliente">Cliente</span></td>
                    <td>Ativo</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
