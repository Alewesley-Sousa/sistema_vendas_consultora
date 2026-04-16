@extends('layouts.app')

@section('title', 'Pedidos de Clientes')
@section('header-icon', 'fas fa-shopping-basket')
@section('header-title', 'Pedidos de Clientes')

@push('styles')
<style>
    .container {
      max-width: 1000px;
      margin: 0 auto;
      animation: fadeIn 0.6s ease;
    }

    .card {
      background: var(--card-bg);
      border-radius: var(--radius);
      padding: 30px;
      box-shadow: var(--shadow);
      border: none;
      border-top: 5px solid var(--primary);
    }

    h2 {
      margin-top: 0;
      font-size: 1.5rem;
      color: var(--dark-sidebar);
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 25px;
      border-bottom: 2px solid var(--background);
      padding-bottom: 15px;
    }

    h2 i {
      color: var(--secondary);
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
      background-color: #f8f9fa;
      color: var(--dark-sidebar);
      font-weight: 700;
      text-transform: uppercase;
      font-size: 0.85rem;
      letter-spacing: 0.5px;
    }

    tr:hover {
      background-color: rgba(52, 152, 219, 0.02);
    }

    input[type="number"] {
      width: 60px;
      padding: 8px;
      border: 1px solid #ddd;
      border-radius: 8px;
      text-align: center;
      font-family: inherit;
    }

    input[type="number"]:focus {
      border-color: var(--primary);
      outline: none;
      box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
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
    }

    button {
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: white;
      border: none;
      padding: 18px;
      border-radius: 10px;
      cursor: pointer;
      font-weight: bold;
      transition: all 0.3s ease;
      margin-top: 25px;
      width: 100%;
      font-size: 1.1rem;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
      box-shadow: 0 4px 10px rgba(52, 152, 219, 0.2);
    }

    button:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 15px rgba(52, 152, 219, 0.3);
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@section('content')
  <div class="container">
    <div class="card">
      <h2><i class="fas fa-list-ul"></i> Seleção de Produtos</h2>
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
        @forelse($produtos as $produto)
          <tr>
            <td>{{ $produto->nome }}</td>
            <td class="unit-price" data-price="{{ $produto->preco }}">R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
            <td><input type="number" name="itens[{{ $produto->id }}]" value="0" min="0" onchange="atualizarTotal()"></td>
            <td class="subtotal">R$ 0,00</td>
          </tr>
        @empty
          <tr>
            <td colspan="4">Nenhum produto ativo encontrado no catálogo.</td>
          </tr>
        @endforelse
        </tbody>
      </table>

    <div class="total" id="valorTotal">Total: R$ 0,00</div>
      <button type="button" onclick="finalizarPedido()">
        <i class="fas fa-check-circle"></i> Finalizar Pedido
      </button>
    </div>
  </div>
@endsection

@push('scripts')
<script>
    function atualizarTotal() {
      let linhas = document.querySelectorAll("#pedido tr");
      let total = 0;

      linhas.forEach(linha => {
        const preco = parseFloat(linha.querySelector('.unit-price').dataset.price);
        const qtd = parseInt(linha.querySelector('input').value) || 0;
        let subtotal = preco * qtd;
        
        linha.querySelector('.subtotal').innerText = "R$ " + subtotal.toLocaleString('pt-BR', {minimumFractionDigits: 2});
        total += subtotal;
      });

      document.getElementById("valorTotal").innerText = "Total: R$ " + total.toLocaleString('pt-BR', {minimumFractionDigits: 2});
    }

    function finalizarPedido() {
      const inputs = document.querySelectorAll("#pedido input");
      const quantidades = Array.from(inputs).map(i => i.value);
      localStorage.setItem('checkout_quantities', JSON.stringify(quantidades));

      alert("Pedido registrado! Redirecionando para o pagamento.");
      window.location.href = "{{ url('venda-online') }}";
    }
</script>
@endpush
