@extends('layouts.app')

@section('title', 'Vendas Online - Sistema Consultora')
@section('header-icon', 'fas fa-globe')
@section('header-title', 'Aba de Vendas Online')

@push('styles')
<style>
    :root {
      --secondary: #FF69B4; /* Hot Pink */
      --background: #fdfdfd;
    }

    .card {
      background: var(--card-bg);
      border-radius: var(--radius);
      padding: 35px;
      box-shadow: 0 15px 40px rgba(0,0,0,0.05);
      margin-bottom: 30px;
      border: none;
    }

    h2 {
      margin-top: 0;
      font-size: 1.5rem;
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

    .back-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      color: var(--primary);
      text-decoration: none;
      font-weight: bold;
      margin-bottom: 25px;
      transition: color 0.3s;
    }

    .back-btn:hover {
      color: var(--primary-dark);
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 15px;
      text-align: center;
      border-bottom: 1px solid #eee;
    }

    th {
      background-color: rgba(44, 62, 80, 0.03);
      color: var(--dark-sidebar);
      font-weight: 700;
      text-transform: uppercase;
      font-size: 0.85rem;
      letter-spacing: 0.5px;
    }

    tr:hover {
      background-color: rgba(255, 111, 97, 0.04);
    }

    input[type="number"] {
      width: 60px;
      padding: 8px;
      border: 1px solid #ddd;
      border-radius: 8px;
      text-align: center;
      font-family: inherit;
    }
    
    .btn {
      padding: 10px 15px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
      transition: all 0.3s;
    }
    
    .btn-sm {
      padding: 5px 10px;
      font-size: 0.9rem;
    }
    
    .btn-danger {
      background: #FF6F61;
      color: white;
      border: none;
    }
    
    .btn-danger:hover {
      background: #FF1493;
    }

    .frete-section {
      margin-top: 25px;
      padding: 20px;
      background: #fff;
      border: 1px dashed var(--primary);
      border-radius: 10px;
    }

    .frete-section select {
      width: 100%;
      padding: 12px;
      border-radius: 8px;
      border: 1px solid #ddd;
      margin-top: 10px;
      font-size: 1rem;
      color: var(--text);
    }

    .total {
      text-align: right;
      font-weight: bold;
      margin-top: 25px;
      font-size: 1.4rem;
      color: var(--primary-dark);
      padding: 20px;
      background: #f8f9fa;
      border-radius: 10px;
      display: flex;
      flex-direction: column;
      gap: 5px;
    }

    .total small {
      font-size: 0.9rem;
      color: var(--text-muted);
    }

    .codigo {
      background: #fff9e6;
      color: #856404;
      border: 1px solid rgba(255, 215, 0, 0.3);
      padding: 15px;
      border-radius: 10px;
      text-align: center;
      font-weight: bold;
      margin-top: 20px;
      font-size: 1.1rem;
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
      margin-top: 25px;
      font-size: 1.1rem;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      box-shadow: 0 4px 10px rgba(255, 111, 97, 0.2);
    }

    button:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 15px rgba(255, 111, 97, 0.3);
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@section('content')
<div class="container">
    <a href="{{ url('catalogo-vendas') }}" class="back-btn"><i class="fas fa-arrow-left"></i> Voltar ao Catálogo</a>

    <!-- Carrinho -->
    <div class="card">
        <h2><i class="fas fa-shopping-cart"></i> Carrinho de Compras</h2>
        <div id="cartContainer">
            <div class="text-center py-4">⏳ Carregando carrinho...</div>
        </div>

        <div class="frete-section" id="freteSection" style="display: none;">
            <label for="estadoDestino"><strong><i class="fas fa-truck"></i> Calcular Frete (Destino):</strong></label>
            <select id="estadoDestino" onchange="atualizarTotal()">
                <option value="0">Selecione o estado...</option>
                <option value="15.00">São Paulo (Interior/Capital) - R$ 15,00</option>
                <option value="22.00">Rio de Janeiro - R$ 22,00</option>
                <option value="18.00">Minas Gerais - R$ 18,00</option>
                <option value="25.00">Nordeste (CE, PE, BA) - R$ 25,00</option>
                <option value="30.00">Outros Estados - R$ 30,00</option>
            </select>
        </div>

        <div class="total" id="detalhamentoTotal" style="display: none;">
            <small id="subtotalProdutos">Produtos: R$ 0,00</small>
            <small id="valorFrete">Frete: R$ 0,00</small>
            <span id="valorTotalFinal">Total: R$ 0,00</span>
        </div>

        <button id="finalizarBtn" onclick="finalizarPedido()" style="display: none;">
            <i class="fas fa-paper-plane"></i> Finalizar Pedido
        </button>
    </div>

    <!-- Formulário de Cliente -->
    <div class="card" id="clienteForm" style="display: none;">
        <h2><i class="fas fa-user"></i> Dados do Cliente</h2>
        <form id="checkoutForm">
            <div class="mb-3">
                <label>Nome:</label>
                <input type="text" class="form-control" id="clienteNome" required>
            </div>
            <div class="mb-3">
                <label>Email:</label>
                <input type="email" class="form-control" id="clienteEmail" required>
            </div>
            <div class="mb-3">
                <label>CPF:</label>
                <input type="text" class="form-control" id="clienteCpf" required>
            </div>
            <div class="mb-3">
                <label>Telefone:</label>
                <input type="text" class="form-control" id="clienteTelefone" required>
            </div>
            <div class="mb-3">
                <label>Endereço:</label>
                <textarea class="form-control" id="clienteEndereco" required></textarea>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/modern.js') }}"></script>
<script>
let cartItems = [];

function carregarCarrinho() {
    cartItems = cart.getItems();
    const container = document.getElementById('cartContainer');
    
    if (cartItems.length === 0) {
        container.innerHTML = '<div class="text-center py-4">Seu carrinho está vazio. <a href="{{ url("catalogo-vendas") }}">Voltar ao catálogo</a></div>';
        return;
    }

    let html = '<table><thead><tr><th>Produto</th><th>Preço</th><th>Quantidade</th><th>Subtotal</th><th>Ações</th></tr></thead><tbody>';
    
    cartItems.forEach((item, index) => {
        const subtotal = item.preco * item.quantity;
        html += `
            <tr>
                <td>${item.nome}</td>
                <td>R$ ${parseFloat(item.preco).toFixed(2).replace('.', ',')}</td>
                <td><input type="number" value="${item.quantity}" min="1" onchange="atualizarQuantidade(${index}, this.value)"></td>
                <td class="subtotal">R$ ${subtotal.toFixed(2).replace('.', ',')}</td>
                <td><button onclick="removerItem(${index})" class="btn btn-sm btn-danger">Remover</button></td>
            </tr>
        `;
    });
    
    html += '</tbody></table>';
    container.innerHTML = html;
    
    document.getElementById('freteSection').style.display = 'block';
    document.getElementById('detalhamentoTotal').style.display = 'block';
    document.getElementById('finalizarBtn').style.display = 'block';
    document.getElementById('clienteForm').style.display = 'block';
    
    atualizarTotal();
}

function atualizarQuantidade(index, novaQtd) {
    cart.updateQuantity(cartItems[index].id, parseInt(novaQtd));
    carregarCarrinho();
}

function removerItem(index) {
    cart.removeItem(cartItems[index].id);
    carregarCarrinho();
}

function atualizarTotal() {
    const subtotalProdutos = cart.getTotal();
    const frete = parseFloat(document.getElementById("estadoDestino").value) || 0;
    const totalFinal = subtotalProdutos + frete;

    document.getElementById("subtotalProdutos").innerText = "Produtos: R$ " + subtotalProdutos.toFixed(2).replace(".", ",");
    document.getElementById("valorFrete").innerText = "Frete: R$ " + frete.toFixed(2).replace(".", ",");
    document.getElementById("valorTotalFinal").innerText = "Total: R$ " + totalFinal.toFixed(2).replace(".", ",");
}

async function finalizarPedido() {
    const frete = parseFloat(document.getElementById("estadoDestino").value);
    if (frete === 0) {
        showToast("Por favor, selecione um estado para calcular o frete.", "warning");
        return;
    }

    // Validar formulário
    const nome = document.getElementById('clienteNome').value.trim();
    const email = document.getElementById('clienteEmail').value.trim();
    const cpf = document.getElementById('clienteCpf').value.trim();
    const telefone = document.getElementById('clienteTelefone').value.trim();
    const endereco = document.getElementById('clienteEndereco').value.trim();

    if (!nome || !email || !cpf || !telefone || !endereco) {
        showToast("Preencha todos os dados do cliente.", "warning");
        return;
    }

    if (!isValidEmail(email)) {
        showToast("Email inválido.", "error");
        return;
    }

    if (!isValidCPF(cpf)) {
        showToast("CPF inválido.", "error");
        return;
    }

    // Preparar dados do pedido
    const itens = cartItems.map(item => ({
        produto_id: item.id,
        quantidade: item.quantity,
        preco_unitario: item.preco
    }));

    const pedidoData = {
        cliente_nome: nome,
        cliente_email: email,
        cliente_cpf: cpf,
        cliente_telefone: telefone,
        cliente_endereco: endereco,
        valor_frete: frete,
        itens: itens
    };

    try {
        const response = await fetch('/api/pedidos', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(pedidoData)
        });

        const data = await response.json();
        
        if (data.status === 'success') {
            showToast("Pedido criado com sucesso!", "success");
            cart.clear();
            setTimeout(() => {
                window.location.href = "{{ url('pedidos-clientes') }}";
            }, 2000);
        } else {
            showToast(data.mensagem || "Erro ao criar pedido.", "error");
        }
    } catch (error) {
        showToast("Erro ao processar pedido: " + error.message, "error");
    }
}

document.addEventListener('DOMContentLoaded', carregarCarrinho);
</script>
@endpush