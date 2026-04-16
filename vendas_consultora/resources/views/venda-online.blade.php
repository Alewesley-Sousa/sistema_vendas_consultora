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
    <a href="{{ url('dashboard') }}" class="back-btn"><i class="fas fa-arrow-left"></i> Voltar ao Dashboard</a>

    <!-- Produtos -->
    <div class="card">
        <h2><i class="fas fa-cart-arrow-down"></i> Seleção de Produtos</h2>
        <table>
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody id="pedido">
                <tr>
                    <td>Perfume Essencial</td>
                    <td>120.00</td>
                    <td><input type="number" value="1" min="0" onchange="atualizarTotal()"></td>
                    <td class="subtotal">120.00</td>
                </tr>
                <tr>
                    <td>Creme Hidratante</td>
                    <td>45.00</td>
                    <td><input type="number" value="2" min="0" onchange="atualizarTotal()"></td>
                    <td class="subtotal">90.00</td>
                </tr>
                <tr>
                    <td>Shampoo Revitalizante</td>
                    <td>35.00</td>
                    <td><input type="number" value="1" min="0" onchange="atualizarTotal()"></td>
                    <td class="subtotal">35.00</td>
                </tr>
            </tbody>
        </table>

        <div class="frete-section">
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

        <div class="total" id="detalhamentoTotal">
            <small id="subtotalProdutos">Produtos: R$ 245,00</small>
            <small id="valorFrete">Frete: R$ 0,00</small>
            <span id="valorTotalFinal">Total: R$ 245,00</span>
        </div>

        <div class="codigo" id="codigoPedido">Link/Código de Pagamento: Aguardando...</div>
        <button onclick="finalizarPedido()">
            <i class="fas fa-paper-plane"></i> Gerar Link de Pagamento
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function atualizarTotal() {
        let linhas = document.querySelectorAll("#pedido tr");
        let somaSubtotal = 0;

        linhas.forEach(linha => {
            let preco = parseFloat(linha.cells[1].innerText);
            let qtdInput = linha.cells[2].querySelector("input").value;
            let qtd = parseInt(qtdInput) || 0;
            let subtotalItem = preco * qtd;
            linha.cells[3].innerText = subtotalItem.toFixed(2);
            somaSubtotal += subtotalItem;
        });

        const frete = parseFloat(document.getElementById("estadoDestino").value) || 0;
        const totalFinal = somaSubtotal + frete;

        document.getElementById("subtotalProdutos").innerText = "Produtos: R$ " + somaSubtotal.toFixed(2).replace(".", ",");
        document.getElementById("valorFrete").innerText = "Frete: R$ " + frete.toFixed(2).replace(".", ",");
        document.getElementById("valorTotalFinal").innerText = "Total: R$ " + totalFinal.toFixed(2).replace(".", ",");
    }

    function gerarCodigoUnico() {
        const prefixo = "PAY-";
        const aleatorio = Math.random().toString(36).substr(2, 9).toUpperCase();
        return prefixo + aleatorio;
    }

    function finalizarPedido() {
        const frete = parseFloat(document.getElementById("estadoDestino").value);
        if (frete === 0) {
            alert("Por favor, selecione um estado para calcular o frete antes de finalizar.");
            return;
        }

        let codigo = gerarCodigoUnico();
        document.getElementById("codigoPedido").innerHTML = `<strong>Código de Transação:</strong> ${codigo}<br><small>Link gerado: https://pagamento.consultora.com/${codigo}</small>`;

        alert("Link de pagamento gerado com sucesso!\nO valor inclui R$ " + frete.toFixed(2) + " de frete.");
    }
</script>
@endpush