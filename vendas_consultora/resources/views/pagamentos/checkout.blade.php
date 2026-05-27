<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Pagamento - Glow Cosmetics</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    {{-- Importando SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #EDEDED; }
        .ml-shadow { box-shadow: 0 1px 2px 0 rgba(0,0,0,.12); }
    </style>
</head>
<body class="antialiased">

    <header class="bg-[#FFF159] py-3 shadow-sm mb-8">
        <div class="max-w-5xl mx-auto px-4 flex items-center justify-between">
            <h1 class="font-bold text-[#2C3E50] tracking-tight text-xl italic">Glow <span class="font-light">Cosmetics</span></h1>
            <span class="text-xs text-gray-600 font-medium flex items-center gap-1">
                <svg class="w-3.5 h-3.5 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                Checkout Seguro
            </span>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 pb-12">
        
        @if(session('error'))
            <div class="mb-6 bg-white border-l-4 border-red-500 rounded-md p-4 ml-shadow flex items-start gap-3">
                <div class="bg-red-50 p-1.5 rounded-full text-red-500 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="text-sm font-bold text-gray-900">Não foi possível processar a ação</h4>
                    <p class="text-xs text-gray-600 mt-0.5 leading-relaxed">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="mb-6 bg-white border-l-4 border-green-500 rounded-md p-4 ml-shadow flex items-start gap-3">
                <div class="bg-green-50 p-1.5 rounded-full text-green-500 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="text-sm font-bold text-gray-900">Ação concluída com sucesso</h4>
                    <p class="text-xs text-gray-600 mt-0.5 leading-relaxed">{{ session('success') }}</p>
                </div>
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
                        <label class="flex items-center justify-between p-6 bg-blue-50/40 border-l-4 border-[#3483FA] cursor-pointer border-b border-gray-100 transition-colors">
                            <div class="flex items-center gap-4">
                                <input type="radio" name="payment_method" value="pix" class="w-5 h-5 text-[#3483FA] focus:ring-[#3483FA]" checked>
                                <div>
                                    <span class="block font-semibold text-gray-900">Pix</span>
                                    <span class="text-xs text-green-600 font-bold uppercase tracking-wider">Aprovação imediata</span>
                                </div>
                            </div>
                            
                            <svg class="h-7 w-auto text-[#32B1A4]" viewBox="0 0 134 135" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M49.62 108.97c-9.53-9.52-9.53-25 0-34.52l23.51-23.51a5 5 0 0 1 7.07 0l23.51 23.51c9.53 9.52 9.53 25 0 34.52l-23.51 23.51a5 5 0 0 1-7.07 0L49.62 108.97z" fill="currentColor"/>
                                <path d="M84.38 26.03c9.53 9.52 9.53 25 0 34.52L60.87 84.06a5 5 0 0 1-7.07 0L30.29 60.55c-9.53-9.52-9.53-25 0-34.52l23.51-23.51a5 5 0 0 1 7.07 0l23.51 23.51z" fill="currentColor"/>
                            </svg>
                        </label>

                        <label class="flex items-center justify-between p-6 opacity-40 bg-gray-50/50 cursor-not-allowed transition-colors">
                            <div class="flex items-center gap-4">
                                <input type="radio" name="payment_method" class="w-5 h-5 text-gray-400" disabled>
                                <div>
                                    <span class="block font-medium text-gray-700">Cartão de Crédito</span>
                                    <span class="text-xs text-gray-500">Temporariamente em manutenção</span>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/a/a4/Mastercard_2019_logo.svg" class="h-5 opacity-80" alt="Master">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" class="h-4 opacity-80" alt="Visa">
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
                            <div class="w-12 h-12 bg-purple-50 border border-purple-100 rounded flex items-center justify-center text-[9px] text-center p-1 text-purple-700 overflow-hidden font-bold uppercase tracking-tight">
                                {{ Str::limit($item->itemCatalogo->produto->nome, 10, '') }}
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-gray-700 truncate w-36">{{ $item->itemCatalogo->produto->nome }}</p>
                                <p class="text-[11px] text-gray-400">Qtd: {{ $item->quantidade }}</p>
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

                    {{-- Form de Confirmação Interceptado --}}
                    <form id="form-confirmar-pagamento" action="{{ route('pedido.pagar.simulado', $pedido->id) }}" method="POST">
                        @csrf
                        <button type="button" onclick="confirmarPagamentoModal()" class="w-full bg-[#3483FA] hover:bg-[#2968C8] text-white font-semibold py-3.5 rounded-md mt-8 transition-all text-sm shadow-sm active:scale-[0.98]">
                            Confirmar Pagamento
                        </button>
                    </form>
                    
                    <p class="text-[10px] text-gray-400 text-center mt-4 italic leading-normal">
                        Ambiente Seguro Glow Cosmetics.
                    </p>
                </div>
            </div>

        </div>
    </main>

    {{-- Script com texto focado 100% na experiência do cliente --}}
    <script>
        function confirmarPagamentoModal() {
            Swal.fire({
                title: 'Confirmar pagamento?',
                text: "Deseja finalizar a sua compra no valor de R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}? Seus produtos serão preparados para o envio imediatamente.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3483FA', 
                cancelButtonColor: '#E2E8F0',
                confirmButtonText: 'Sim, confirmar',
                cancelButtonText: 'Voltar',
                customClass: {
                    popup: 'rounded-xl',
                    confirmButton: 'font-semibold px-5 py-2.5 rounded-md text-sm',
                    cancelButton: 'font-semibold px-5 py-2.5 rounded-md text-sm !text-gray-600'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Confirmando...',
                        text: 'Aguarde um instante enquanto finalizamos o seu pedido.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    document.getElementById('form-confirmar-pagamento').submit();
                }
            });
        }
    </script>

</body>
</html>