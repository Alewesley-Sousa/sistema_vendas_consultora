<div x-show="mostrarAlerta" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 scale-90"
     x-transition:enter-end="opacity-100 scale-100"
     class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-slate-900/60 backdrop-blur-sm">
    
    <div @click.away="mostrarAlerta = false" class="bg-white p-8 rounded-3xl shadow-2xl max-w-sm w-full text-center">
        <div class="w-16 h-16 bg-amber-50 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
        </div>
        <h3 class="text-xl font-black text-slate-800 mb-2 uppercase">Versão Desktop</h3>
        <p class="text-slate-500 text-sm mb-6 font-medium">
            A visualização em Árvore está disponível apenas em computadores para garantir a melhor experiência.
        </p>
        <button @click="mostrarAlerta = false" class="w-full bg-[#1e293b] text-white py-3 rounded-xl font-bold uppercase text-xs tracking-widest shadow-lg active:scale-95 transition-all">
            Entendi
        </button>
    </div>
</div>
