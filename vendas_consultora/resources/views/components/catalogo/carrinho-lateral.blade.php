<div x-show="carrinho.length > 0">
    <button @click="cartOpen = true" class="fixed bottom-10 right-10 bg-[#FF7665] text-white p-5 rounded-full shadow-2xl z-[60]">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-width="2" />
        </svg>
        <span class="absolute top-0 right-0 bg-[#2C3E50] text-white text-[11px] w-7 h-7 flex items-center justify-center rounded-full border-4 border-[#FFF9F9]" 
              x-text="carrinho.reduce((s, i) => s + i.qtd, 0)"></span>
    </button>

    <div x-show="cartOpen" @click="cartOpen = false" class="fixed inset-0 bg-[#2C3E50]/40 backdrop-blur-sm z-[70]"></div>
    
    <div x-show="cartOpen" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="translate-x-full" 
         class="fixed top-0 right-0 h-full w-full max-w-md bg-white shadow-2xl z-[80] p-8 flex flex-col">
        <h2 class="text-2xl font-serif font-black text-[#2C3E50] mb-8">Meu Pedido</h2>
        
        <div class="flex-1 overflow-y-auto custom-scrollbar">
            <template x-for="item in carrinho" :key="item.id">
                <div class="flex items-center gap-4 bg-gray-50 p-4 rounded-2xl mb-4">
                    <div class="flex-1 font-bold text-xs text-[#2C3E50]" x-text="item.nome"></div>
                    <div class="flex items-center border rounded-lg bg-white overflow-hidden">
                        <button @click="alterarQtd(item.id, -1)" class="px-2">-</button>
                        <span class="px-2 text-xs font-bold" x-text="item.qtd"></span>
                        <button @click="alterarQtd(item.id, 1)" class="px-2">+</button>
                    </div>
                </div>
            </template>
        </div>

        <div class="border-t pt-6">
            <div class="flex justify-between mb-6">
                <span class="font-black text-[#2C3E50]">TOTAL</span>
                <span class="text-3xl font-black text-[#E67E73]" x-text="'R$ ' + totalCarrinho.toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span>
            </div>
            <button @click="checkoutModal = true" class="w-full bg-[#E67E73] text-white py-5 rounded-2xl font-black uppercase text-xs tracking-widest shadow-lg">
                Finalizar
            </button>
        </div>
    </div>
</div>
