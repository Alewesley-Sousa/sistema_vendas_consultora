<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acompanhar Pedido #{{ $pedido->id }} - Glow Cosmetics</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #EDEDED; }
        .ml-shadow { box-shadow: 0 1px 2px 0 rgba(0,0,0,.12); }
    </style>
</head>
<body class="antialiased">

    <header class="bg-[#FFF159] py-3 shadow-sm mb-8">
        <div class="max-w-3xl mx-auto px-4 flex items-center justify-between">
            <h1 class="font-bold text-[#2C3E50] tracking-tight text-xl italic">Glow <span class="font-light">Cosmetics</span></h1>
            <span class="text-xs text-gray-600 font-medium">Acompanhamento do Cliente</span>
        </div>
    </header>

    <main class="max-w-3xl mx-auto px-4 pb-12">

        @if(session('success'))
            <div class="mb-6 bg-white border-l-4 border-green-500 rounded-md p-4 ml-shadow flex items-start gap-3">
                <div class="bg-green-50 p-1.5 rounded-full text-green-500 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="text-sm font-bold text-gray-900">Pagamento Processado!</h4>
                    <p class="text-xs text-gray-600 mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-md ml-shadow p-6 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 pb-4 mb-4">
                <div>
                    <span class="text-xs text-gray-400 uppercase font-bold tracking-wider">Código do Pedido</span>
                    <h2 class="text-lg font-bold text-gray-800">#{{ $pedido->id }}</h2>
                </div>
                
                <div class="flex flex-col sm:items-end gap-2">
                    <button onclick="salvarLinkPedido()" id="btnCompartilhar" class="inline-flex items-center justify-center gap-2 bg-[#3483FA]/10 hover:bg-[#3483FA]/20 text-[#3483FA] font-semibold text-xs px-4 py-2.5 rounded transition-all active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 100-3 3 3 0 000 3zm0 12a3 3 0 100-3 3 3 0 000 3z"></path>
                        </svg>
                        <span id="txtCompartilhar">Salvar Link do Pedido</span>
                    </button>
                </div>
            </div>
            
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <p class="text-sm text-gray-600">Olá, <strong class="text-gray-900">{{ $pedido->clientes->nome }}</strong>! Acompanhe abaixo o status de entrega do seu pedido.</p>
                <span class="bg-amber-50 border border-amber-200 text-amber-800 text-[11px] font-medium px-2.5 py-1 rounded shrink-0 line-none">
                    ⚠️ Guarde esta página para consultar o status depois
                </span>
            </div>
        </div>

        <div class="bg-white rounded-md ml-shadow p-6">
            <h3 class="font-semibold text-gray-800 border-b border-gray-100 pb-4 mb-6">Status da Entrega</h3>

            @if($pedido->status_id == 7)
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-md p-4 flex items-center gap-3">
                    <svg class="w-6 h-6 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h4 class="font-bold text-sm">Pedido Cancelado</h4>
                        <p class="text-xs text-red-600 mt-0.5">Este pedido foi cancelado e não prosseguirá no fluxo de entrega.</p>
                    </div>
                </div>
            @else
                <div class="relative pl-6 space-y-6 before:absolute before:bottom-2 before:top-2 before:left-2.5 before:w-0.5 before:bg-gray-200">
                    
                    @php
                        $etapas = [
                            1 => ['nome' => 'Aguardando Pagamento', 'desc' => 'Seu pedido está aguardando a confirmação do meio de pagamento.'],
                            2 => ['nome' => 'Pagamento Confirmado', 'desc' => 'Tudo certo! Recebemos seu pagamento e vamos preparar seu pedido.'],
                            3 => ['nome' => 'Separando Pedido', 'desc' => 'Nossa equipe está separando seus cosméticos no estoque.'],
                            4 => ['nome' => 'Pronto para Envio', 'desc' => 'Os produtos já foram embalados com muito carinho e aguardam a transportadora.'],
                            5 => ['nome' => 'Enviado', 'desc' => 'O pedido já está a caminho da sua residência.'],
                            6 => ['nome' => 'Entregue', 'desc' => 'Pacote entregue! Esperamos que ame seus novos produtos Glow.']
                        ];
                    @endphp

                    @foreach($etapas as $id => $dados)
                        @php
                            $concluido = $pedido->status_id >= $id;
                            $atual = $pedido->status_id == $id;
                            $finalEntregue = $pedido->status_id == 6 && $id == 6;
                        @endphp

                        <div class="relative flex items-start gap-4 timeline-item" data-step="{{ $id }}">
                            
                            <div class="indicator-container absolute -left-[21px] mt-1 flex h-4 w-4 items-center justify-center">
                                @if($finalEntregue)
                                    <span class="absolute inline-flex h-full w-full animate-pulse rounded-full bg-green-400 opacity-75 shadow-[0_0_12px_rgba(34,197,94,0.6)]"></span>
                                    <span class="relative inline-flex h-3 w-3 rounded-full bg-green-500 ring-2 ring-green-100"></span>
                                @elseif($atual)
                                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-blue-400 opacity-75"></span>
                                    <span class="relative inline-flex h-3 w-3 rounded-full bg-blue-500 ring-2 ring-blue-100"></span>
                                @elseif($concluido)
                                    <div class="h-3 w-3 rounded-full bg-green-500 border border-green-600"></div>
                                @else
                                    <div class="h-3 w-3 rounded-full bg-white border border-gray-300"></div>
                                @endif
                            </div>

                            <div class="pl-4">
                                <h4 class="step-title text-sm font-semibold transition-colors duration-500
                                    {{ $finalEntregue ? 'text-green-600' : '' }}
                                    {{ $atual && !$finalEntregue ? 'text-blue-600' : '' }}
                                    {{ $concluido && !$atual && !$finalEntregue ? 'text-gray-900' : '' }}
                                    {{ !$concluido ? 'text-gray-400' : '' }}">
                                    {{ $dados['nome'] }}
                                </h4>
                                <p class="step-desc text-xs leading-relaxed mt-0.5 transition-colors duration-500
                                    {{ $concluido ? 'text-gray-600' : 'text-gray-400' }}">
                                    {{ $dados['desc'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="bg-white rounded-md ml-shadow p-6 mt-6">
            <h3 class="font-semibold text-gray-800 border-b border-gray-100 pb-4 mb-4">Itens Comprados</h3>
            <div class="divide-y divide-gray-50">
                @foreach($pedido->itensPedidos as $item)
                    <div class="flex items-center justify-between py-3 text-sm">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-purple-50 text-purple-700 font-bold rounded flex items-center justify-center text-[10px] uppercase">
                                {{ Str::limit($item->itemCatalogo->produto->nome, 2, '') }}
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">{{ $item->itemCatalogo->produto->nome }}</p>
                                <p class="text-[11px] text-gray-400">Quantidade: {{ $item->quantidade }}</p>
                            </div>
                        </div>
                        <span class="font-semibold text-gray-700">R$ {{ number_format($item->subtotal, 2, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>
        </div>

    </main>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let statusAtual = parseInt("{{ $pedido->status_id }}");

            if (statusAtual === 2) {
                const intervaloSimulador = setInterval(() => {
                    if (statusAtual >= 6) {
                        clearInterval(intervaloSimulador);
                        return;
                    }

                    statusAtual++;
                    atualizarTimelineVisual(statusAtual);
                }, 5000);
            }
        });

        function atualizarTimelineVisual(statusId) {
            const itens = document.querySelectorAll('.timeline-item');

            itens.forEach(item => {
                const step = parseInt(item.getAttribute('data-step'));
                const containerIndicador = item.querySelector('.indicator-container');
                const elementoTitulo = item.querySelector('.step-title');
                const elementoDesc = item.querySelector('.step-desc');

                // Se o status chegou no ID 6 (Entregue)
                if (statusId === 6 && step === 6) {
                    containerIndicador.innerHTML = `
                        <span class="absolute inline-flex h-full w-full animate-pulse rounded-full bg-green-400 opacity-75 shadow-[0_0_12px_rgba(34,197,94,0.6)]"></span>
                        <span class="relative inline-flex h-3 w-3 rounded-full bg-green-500 ring-2 ring-green-100"></span>
                    `;
                    elementoTitulo.className = "step-title text-sm font-semibold transition-colors duration-500 text-green-600";
                    elementoDesc.className = "step-desc text-xs leading-relaxed mt-0.5 transition-colors duration-500 text-gray-600";
                
                // Para os outros passos que ficarem ativos durante a contagem
                } else if (step === statusId) {
                    containerIndicador.innerHTML = `
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex h-3 w-3 rounded-full bg-blue-500 ring-2 ring-blue-100"></span>
                    `;
                    elementoTitulo.className = "step-title text-sm font-semibold transition-colors duration-500 text-blue-600";
                    elementoDesc.className = "step-desc text-xs leading-relaxed mt-0.5 transition-colors duration-500 text-gray-600";

                } else if (step < statusId) {
                    containerIndicador.innerHTML = `<div class="h-3 w-3 rounded-full bg-green-500 border border-green-600"></div>`;
                    elementoTitulo.className = "step-title text-sm font-semibold transition-colors duration-500 text-gray-900";
                    elementoDesc.className = "step-desc text-xs leading-relaxed mt-0.5 transition-colors duration-500 text-gray-600";

                } else {
                    containerIndicador.innerHTML = `<div class="h-3 w-3 rounded-full bg-white border border-gray-300"></div>`;
                    elementoTitulo.className = "step-title text-sm font-semibold transition-colors duration-500 text-gray-400";
                    elementoDesc.className = "step-desc text-xs leading-relaxed mt-0.5 transition-colors duration-500 text-gray-400";
                }
            });
        }

        function salvarLinkPedido() {
            const urlAtual = window.location.href;
            const btn = document.getElementById('btnCompartilhar');
            const txt = document.getElementById('txtCompartilhar');

            if (navigator.share) {
                navigator.share({
                    title: 'Acompanhar Pedido - Glow Cosmetics',
                    text: 'Veja o status de entrega do pedido #{{ $pedido->id }}',
                    url: urlAtual
                }).catch((error) => console.log('Erro ao compartilhar:', error));
            } else {
                navigator.clipboard.writeText(urlAtual).then(() => {
                    btn.classList.remove('bg-[#3483FA]/10', 'text-[#3483FA]', 'hover:bg-[#3483FA]/20');
                    btn.classList.add('bg-green-500', 'text-white');
                    txt.innerText = '¡Link Copiado!';

                    setTimeout(() => {
                        btn.classList.remove('bg-green-500', 'text-white');
                        btn.classList.add('bg-[#3483FA]/10', 'text-[#3483FA]', 'hover:bg-[#3483FA]/20');
                        txt.innerText = 'Salvar Link do Pedido';
                    }, 2000);
                }).catch(err => {
                    alert('Por favor, copie a URL do seu navegador para salvar o acesso.');
                });
            }
        }
    </script>

</body>
</html>