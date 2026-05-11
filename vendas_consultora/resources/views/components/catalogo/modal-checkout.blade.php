<div x-show="checkoutModal" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100"
     class="fixed inset-0 z-[100] flex items-center justify-center p-4">
    
    {{-- Overlay com desfoque --}}
    <div @click="checkoutModal = false" class="absolute inset-0 bg-[#2C3E50]/60 backdrop-blur-md"></div>
    
    {{-- Card do Modal --}}
    <div class="relative bg-white w-full max-w-lg rounded-[3rem] p-8 md:p-10 shadow-[0_30px_100px_rgba(0,0,0,0.25)] overflow-hidden" x-transition>
        
        {{-- Detalhe Decorativo Superior --}}
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-[#FFD700] via-[#FF7665] to-[#FFD700]"></div>

        <h3 class="text-2xl font-serif font-black text-[#2C3E50] mb-8 mt-2 uppercase tracking-tighter">
            Finalizar <span class="text-[#FF7665] italic">Pedido</span>
        </h3>

        <div class="space-y-6">
            {{-- Seção CPF --}}
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase mb-3 ml-2 tracking-widest">Identificação do Cliente</label>
                <div class="flex gap-2 p-1.5 bg-gray-50 rounded-[2rem] border border-gray-100">
                    <input type="text" 
                           x-model="checkoutData.cpf" 
                           @input="formatarCPF"
                           placeholder="000.000.000-00"
                           :disabled="checkoutData.verificado"
                           class="flex-1 bg-transparent border-none rounded-2xl py-3 px-5 text-sm focus:ring-0 placeholder-gray-300 font-bold text-[#2C3E50]">
                    
                    <template x-if="!checkoutData.verificado">
                        <button @click="verificarCliente()" 
                                :disabled="validating || checkoutData.cpf.length < 14" 
                                class="bg-[#2C3E50] text-[#FFD700] px-6 rounded-2xl text-[10px] font-black uppercase transition-all active:scale-95 disabled:opacity-50">
                            <span x-show="!validating">Verificar</span>
                            <span x-show="validating">...</span>
                        </button>
                    </template>
                    
                    <template x-if="checkoutData.verificado">
                        <button @click="limparCliente()" class="bg-red-50 text-red-500 px-6 rounded-2xl text-[10px] font-black uppercase hover:bg-red-100 transition-colors">Trocar</button>
                    </template>
                </div>
            </div>

            {{-- Info Cliente Localizado --}}
            <template x-if="checkoutData.verificado">
                <div class="bg-gradient-to-r from-green-50 to-white p-5 rounded-[2rem] border border-green-100 animate-fadeIn">
                    <div class="flex items-center gap-3">
                        <div class="bg-green-500 text-white p-1 rounded-full">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-green-600 uppercase tracking-widest">Cliente Localizado</p>
                            <p class="text-base font-bold text-[#2C3E50]" x-text="checkoutData.nome"></p>
                        </div>
                    </div>
                </div>
            </template>

            {{-- Forma de Pagamento Estilizada --}}
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase mb-3 ml-2 tracking-widest">Método de Pagamento</label>
                <div class="grid grid-cols-2 gap-4">
                    <button @click="checkoutData.pagamento = 'pix'" 
                            :class="checkoutData.pagamento === 'pix' ? 'border-[#FFD700] bg-white shadow-lg ring-2 ring-[#FFD700]/20' : 'border-gray-100 bg-gray-50 opacity-60'"
                            class="flex flex-col items-center gap-2 p-4 rounded-3xl border-2 transition-all">
                        <svg class="w-6 h-6 text-[#2C3E50]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="text-[10px] font-black uppercase">PIX</span>
                    </button>
                    <button @click="checkoutData.pagamento = 'cartao'" 
                            :class="checkoutData.pagamento === 'cartao' ? 'border-[#FFD700] bg-white shadow-lg ring-2 ring-[#FFD700]/20' : 'border-gray-100 bg-gray-50 opacity-60'"
                            class="flex flex-col items-center gap-2 p-4 rounded-3xl border-2 transition-all">
                        <svg class="w-6 h-6 text-[#2C3E50]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        <span class="text-[10px] font-black uppercase">Cartão</span>
                    </button>
                </div>
            </div>

            {{-- Opções de Cartão --}}
            <template x-if="checkoutData.pagamento === 'cartao'">
                <div class="space-y-4 p-5 bg-gray-50 rounded-[2rem] border border-gray-100 animate-slideDown">
                    <div class="flex justify-center gap-8 font-black text-[10px] uppercase">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="radio" x-model="checkoutData.subMetodo" value="debito" class="text-[#FF7665] focus:ring-[#FF7665]"> 
                            <span class="group-hover:text-[#2C3E50]">Débito</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="radio" x-model="checkoutData.subMetodo" value="credito" class="text-[#FF7665] focus:ring-[#FF7665]"> 
                            <span class="group-hover:text-[#2C3E50]">Crédito</span>
                        </label>
                    </div>
                    
                    <template x-if="checkoutData.subMetodo === 'credito'">
                        <div class="pt-2">
                            <select x-model="checkoutData.parcelas" class="w-full bg-white border border-gray-200 rounded-2xl py-3 px-4 text-xs font-bold text-[#2C3E50] focus:ring-2 focus:ring-[#FFD700]">
                                <template x-for="n in 12" :key="n">
                                    <option :value="n" x-text="n + 'x de R$ ' + (totalCarrinho / n).toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2})"></option>
                                </template>
                            </select>
                        </div>
                    </template>
                </div>
            </template>
        </div>

        {{-- Footer do Modal --}}
        <div class="mt-10 flex flex-col md:flex-row gap-4 items-center">
            <button @click="checkoutModal = false" class="w-full md:w-auto px-8 text-gray-400 font-black uppercase text-[10px] hover:text-[#2C3E50] transition-colors order-2 md:order-1">Voltar</button>
            <button @click="finalizarVenda()" 
                    :disabled="!checkoutData.verificado"
                    :class="checkoutData.verificado ? 'bg-gradient-to-r from-[#2C3E50] to-[#1a252f] shadow-xl shadow-[#2C3E50]/20' : 'bg-gray-200 cursor-not-allowed'"
                    class="w-full md:flex-1 text-[#FFD700] py-5 rounded-[1.5rem] font-black uppercase text-xs tracking-widest transition-all active:scale-95 order-1 md:order-2">
                Finalizar Venda
            </button>
        </div>
    </div>
</div>
