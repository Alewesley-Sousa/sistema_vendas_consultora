<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Pagamento - Glow Cosmetics</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #EDEDED; }
        .ml-shadow { box-shadow: 0 1px 2px 0 rgba(0,0,0,.12); }
    </style>
</head>
<body class="antialiased">

    <header class="bg-[#FFF159] py-3 shadow-sm mb-8">
        <div class="max-w-5xl mx-auto px-4 flex items-center justify-between">
            <h1 class="font-bold text-[#2C3E50] tracking-tight text-xl italic">Glow <span class="font-light">Cosmetics</span></h1>
            <span class="text-xs text-gray-600 font-medium">Checkout Seguro</span>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 pb-12">
        
        @if(session('error'))
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded ml-shadow text-sm" role="alert">
                <p class="font-bold">Ops!</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        @if(session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded ml-shadow text-sm" role="alert">
                <p class="font-bold">Sucesso!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-2 space-y-4">
                <div class="bg-white p-6 rounded-md ml-shadow flex items-start gap-4">
                    <div class="bg-gray-100 p-2 rounded-full">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900">Enviar para {{ $pedido->clientes->nome }}</h3>
                        <p class="text-xs text-gray-500">O pedido será processado após a confirmação do pagamento.</p>
                    </div>
                </div>

                <div class="bg-white rounded-md ml-shadow overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="font-semibold text-lg text-gray-800">Como você prefere pagar?</h3>
                    </div>
                    
                    <div class="p-0">
                        <label class="flex items-center justify-between p-6 hover:bg-gray-50 cursor-pointer border-b border-gray-100 transition-colors">
                            <div class="flex items-center gap-4">
                                <input type="radio" name="payment_method" value="pix" class="w-5 h-5 text-blue-600 focus:ring-blue-500" checked>
                                <div>
                                    <span class="block font-medium text-gray-900">Pix</span>
                                    <span class="text-xs text-green-600 font-bold uppercase">Aprovação imediata</span>
                                </div>
                            </div>
                            <img src="https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_Pix.png" class="h-6" alt="Pix">
                        </label>

                        <label class="flex items-center justify-between p-6 opacity-50 cursor-not-allowed transition-colors">
                            <div class="flex items-center gap-4">
                                <input type="radio" name="payment_method" class="w-5 h-5 text-blue-600" disabled>
                                <div>
                                    <span class="block font-medium text-gray-900">Cartão de Crédito</span>
                                    <span class="text-xs text-gray-500">Em manutenção</span>
                                </div>
                            </div>
                            <div class="flex gap-1">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/a/a4/Mastercard_2019_logo.svg" class="h-4" alt="Master">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" class="h-4" alt="Visa">
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-md ml-shadow">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Resumo da compra</h3>
                    
                    <div class="space-y-4 mb-6 border-b border-gray-100 pb-6">
                        @foreach($pedido->itensPedidos as $item)
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gray-50 border border-gray-100 rounded flex items-center justify-center text-[8px] text-center p-1 text-gray-400 overflow-hidden font-bold uppercase">
                                {{ Str::limit($item->itemCatalogo->produto->nome, 10) }}
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-medium text-gray-700 truncate w-32">{{ $item->itemCatalogo->produto->nome }}</p>
                                <p class="text-[10px] text-gray-400">Qtd: {{ $item->quantidade }}</p>
                            </div>
                            <span class="text-xs font-semibold text-gray-600">R$ {{ number_format($item->subtotal, 2, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Produtos ({{ $pedido->itensPedidos->count() }})</span>
                            <span>R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-green-600 font-medium">
                            <span>Frete</span>
                            <span>Grátis</span>
                        </div>
                        <div class="flex justify-between text-xl font-bold text-gray-900 pt-4 border-t border-gray-100">
                            <span>Você paga</span>
                            <span>R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}</span>
                        </div>
                    </div>

                    <form action="{{ route('pedido.pagar.simulado', $pedido->id) }}" method="POST" onsubmit="return confirm('Deseja confirmar o pagamento simulado deste pedido?')">
                        @csrf
                        <button type="submit" class="w-full bg-[#3483FA] hover:bg-[#2968C8] text-white font-semibold py-3.5 rounded-md mt-8 transition-all text-sm shadow-sm active:scale-[0.98]">
                            Confirmar Pagamento
                        </button>
                    </form>
                    
                    <p class="text-[10px] text-gray-400 text-center mt-4 italic">
                        Ambiente de Testes: Esta ação simula a baixa real financeira e de estoque.
                    </p>
                </div>
            </div>

        </div>
    </main>

</body>
</html>
