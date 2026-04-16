@extends('layouts.app')

@section('title', 'Cadastro de Consultora')
@section('header-icon', 'fas fa-user-tie')
@section('header-title', 'Cadastro de Consultora')

@push('styles')
<style>
    .register-container {
      background: var(--card-bg);
      width: 100%;
      max-width: 600px;
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      overflow: hidden;
      animation: fadeIn 0.6s ease;
    }

    .register-header {
      background: linear-gradient(135deg, var(--dark-sidebar), var(--dark-sidebar-end));
      color: white;
      padding: 30px;
      text-align: center;
      border-bottom: 3px solid var(--gold);
    }

    .register-header h1 {
      margin: 0;
      font-size: 1.8rem;
      letter-spacing: 1px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 15px;
    }

    .register-header h1 i {
      color: var(--gold);
    }

    .register-header p {
      margin: 10px 0 0;
      opacity: 0.8;
      font-size: 0.95rem;
    }

    form {
      padding: 30px;
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
      margin-bottom: 15px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      font-weight: 600;
      margin-bottom: 8px;
      color: var(--dark-sidebar);
      font-size: 0.9rem;
    }

    .form-group input {
      width: 100%;
      padding: 12px;
      border: 1px solid #ddd;
      border-radius: 10px;
      font-size: 1rem;
      box-sizing: border-box;
      transition: border-color 0.3s, box-shadow 0.3s;
    }

    .status {
      background: #fff0f3;
      color: var(--primary);
      padding: 12px;
      border-radius: 10px;
      font-size: 0.9rem;
      margin-bottom: 25px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      font-weight: 600;
      border: 1px solid rgba(255, 111, 97, 0.2);
    }

    .section-title {
      font-size: 1rem;
      color: var(--primary-dark);
      margin: 10px 0 15px;
      border-bottom: 1px solid #eee;
      padding-bottom: 5px;
    }

    button {
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: white;
      border: none;
      padding: 15px;
      border-radius: 10px;
      cursor: pointer;
      font-weight: bold;
      width: 100%;
      font-size: 1.1rem;
      transition: transform 0.2s, box-shadow 0.2s;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    button:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(255, 111, 97, 0.3);
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 600px) {
      .form-row { grid-template-columns: 1fr; gap: 0; }
    }
</style>
@endpush

@section('content')
  <div class="register-container">
    <form id="consultoraForm" method="POST" action="#">
      @csrf
      <div class="section-title">Identificação Pessoal</div>
      <div class="form-group">
        <label>Nome Completo</label>
        <input type="text" id="nome" required placeholder="Ex: Maria Oliveira">
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>CPF</label>
          <input type="text" id="cpf" required maxlength="14" placeholder="000.000.000-00">
        </div>
        <div class="form-group">
          <label>RG</label>
          <input type="text" id="rg" required placeholder="0.000.000">
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>Data de Nascimento</label>
          <input type="date" id="dataNascimento" required>
        </div>
        <div class="form-group">
          <label>Região de Atuação</label>
          <input type="text" id="regiao" required placeholder="Ex: Nordeste / Fortaleza">
        </div>
      </div>

      <div class="section-title">Contato e Acesso</div>
      <div class="form-row">
        <div class="form-group">
          <label>E-mail Corporativo</label>
          <input type="email" id="email" required placeholder="email@exemplo.com">
        </div>
        <div class="form-group">
          <label>Telefone / WhatsApp</label>
          <input type="tel" id="telefone" required placeholder="(85) 99999-9999">
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>CEP</label>
          <input type="text" id="cep" required placeholder="00000-000">
        </div>
        <div class="form-group">
          <label>Senha de Acesso</label>
          <input type="password" id="senha" required placeholder="Mínimo 8 caracteres">
        </div>
      </div>

      <div class="section-title">Dados Bancários (Para Comissões)</div>
      <div class="form-row">
        <div class="form-group">
          <label>Banco</label>
          <input type="text" id="banco" placeholder="Ex: Nubank">
        </div>
        <div class="form-group">
          <label>Agência / Conta</label>
          <input type="text" id="conta" placeholder="0001 / 12345-6">
        </div>
      </div>

      <div class="status">
        <i class="fas fa-info-circle"></i> Status da Conta: Pré-Cadastro
      </div>

      <button type="submit">
        <i class="fas fa-check-circle"></i> Concluir Cadastro
      </button>
    </form>
  </div>
@endsection

@push('scripts')
<script>
    // Máscara de CPF
    document.getElementById('cpf').addEventListener('input', function (e) {
      let value = e.target.value.replace(/\D/g, ''); // Remove tudo que não é dígito
      value = value.replace(/(\d{3})(\d)/, "$1.$2");
      value = value.replace(/(\d{3})(\d)/, "$1.$2");
      value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
      e.target.value = value;
    });

    // Lógica de submissão
    document.getElementById('consultoraForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      const consultora = {
        id: 'CONS-' + Math.floor(Math.random() * 90000 + 10000),
        nome: document.getElementById('nome').value,
        email: document.getElementById('email').value,
        cpf: document.getElementById('cpf').value,
        rg: document.getElementById('rg').value,
        nascimento: document.getElementById('dataNascimento').value,
        regiao: document.getElementById('regiao').value,
        banco: document.getElementById('banco').value,
        conta: document.getElementById('conta').value,
        dataEntrada: new Date().toLocaleDateString('pt-BR'),
        status: 'Em Treinamento',
        vendas: [],
        metas: { objetivo: 5000, alcancado: 0 }
      };

      // Salvar no sistema (localStorage)
      let consultoras = JSON.parse(localStorage.getItem('consultoras')) || [];
      consultoras.push(consultora);
      localStorage.setItem('consultoras', JSON.stringify(consultoras));

      // Feedback e Redirecionamento
      alert('Cadastro realizado com sucesso!\nSeu Código de Consultora é: ' + consultora.id);
      window.location.href = "{{ route('dev.dashboard') }}";
    });
</script>
@endsection
@endpush
