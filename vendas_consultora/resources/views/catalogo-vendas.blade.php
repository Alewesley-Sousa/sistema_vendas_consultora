@extends('layouts.app')

@section('title', 'Catálogo de Vendas')
@section('header-icon', 'fas fa-book-open')
@section('header-title', 'Nosso Catálogo')

@push('styles')
<style>
    .container-catalog {
      animation: fadeIn 0.6s ease;
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

    .back-btn:hover { color: var(--primary-dark); }

    .catalog-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 25px;
    }

    .product-card {
      background: var(--card-bg);
      border-radius: var(--radius);
      overflow: hidden;
      box-shadow: 0 8px 20px rgba(0,0,0,0.03);
      transition: transform 0.3s ease;
      display: flex;
      flex-direction: column;
      border: 1px solid rgba(0,0,0,0.03);
    }

    .product-card:hover { transform: translateY(-5px); }

    .product-image {
      height: 180px;
      background: linear-gradient(to bottom, #ffffff, #f9f9f9);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--primary);
      font-size: 3.5rem;
      opacity: 0.8;
    }

    .product-info {
      padding: 20px;
      flex-grow: 1;
      display: flex;
      flex-direction: column;
    }

    .product-category {
      font-size: 0.75rem;
      color: var(--primary-dark);
      text-transform: uppercase;
      font-weight: 700;
      margin-bottom: 8px;
    }

    .product-name {
      font-size: 1.1rem;
      font-weight: 600;
      margin-bottom: 12px;
      color: var(--dark-sidebar);
    }

    .product-price {
      font-size: 1.3rem;
      color: var(--primary);
      font-weight: 700;
      margin-top: auto;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@section('content')
<div class="container-catalog">
    <a href="{{ route('dev.dashboard') }}" class="back-btn"><i class="fas fa-arrow-left"></i> Voltar ao Dashboard</a>

    <div class="catalog-grid">
      @php
        $itens = [
            ['icon' => 'fas fa-spray-can', 'cat' => 'Perfumaria', 'nome' => 'Perfume Essencial Exclusivo', 'preco' => '145,00'],
            ['icon' => 'fas fa-pump-soap', 'cat' => 'Corpo', 'nome' => 'Hidratante Cereja e Avelã', 'preco' => '54,90'],
            ['icon' => 'fas fa-magic', 'cat' => 'Maquiagem', 'nome' => 'Base Matte Alta Cobertura', 'preco' => '39,00'],
            ['icon' => 'fas fa-wine-bottle', 'cat' => 'Óleos', 'nome' => 'Óleo Sève Amêndoas Doces', 'preco' => '72,00'],
        ];
      @endphp

      @foreach($itens as $item)
      <div class="product-card">
        <div class="product-image"><i class="{{ $item['icon'] }}"></i></div>
        <div class="product-info">
          <span class="product-category">{{ $item['cat'] }}</span>
          <div class="product-name">{{ $item['nome'] }}</div>
          <div class="product-price">R$ {{ $item['preco'] }}</div>
        </div>
      </div>
      @endforeach
    </div>
</div>
@endsection