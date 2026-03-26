@extends('layouts.app-consultora')

@section('conteudo')
<style>
    [x-cloak] { display: none !important; }
    .font-brand-body { font-family: 'Inter', sans-serif; }
    
    /* Decoração abstrata que remete a maquiagem/pó */
    .blob-decoration {
        position: absolute;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255,215,0,0.08) 0%, rgba(255,255,255,0) 70%);
        border-radius: 50%;
        z-index: -1;
    }
</style>

<div x-data="clienteForm" x-cloak class="max-w-5xl mx-auto space-y-6 pb-12 px-4 md:px-0 font-brand-body relative overflow-hidden">
    
    <div class="blob-decoration -top-20 -right-20"></div>
    <div class="blob-decoration -bottom-20 -left-20"></div>

    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('consultora.dashboard') }}" 
               class="h-10 w-10 md:h-12 md:w-12 rounded-xl bg-white shadow-sm border border-[#2C3E50]/5 flex items-center justify-center text-[#2C3E50] hover:bg-[#2C3E50] hover:text-white transition-all duration-300">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-2xl md:text-4xl font-bold text-[#2C3E50]" style="font-family: 'The Seasons', serif;">Novo Cliente</h1>
                <div class="flex items-center gap-2 mt-1">
                    <span class="h-1 w-8 rounded-full bg-[#FFD700]"></span> 
                    <p class="text-[9px] md:text-[11px] uppercase tracking-[0.3em] text-[#FF69B4] font-bold">Registro de Conquista</p>
                </div>
            </div>
        </div>
        
        <div class="hidden md:flex gap-1">
            <div class="w-3 h-3 rounded-full bg-[#FF6F61]"></div>
            <div class="w-3 h-3 rounded-full bg-[#FF69B4]"></div>
            <div class="w-3 h-3 rounded-full bg-[#FFD700]"></div>
        </div>
    </div>

    <div class="flex flex-col md:flex-row gap-8 items-stretch">
        
        <div class="flex-1 bg-white rounded-[2rem] shadow-2xl border border-[#2C3E50]/5 overflow-hidden relative">
            <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-[#FF6F61] via-[#FF69B4] to-[#FFD700]"></div>
            
            <form @submit.prevent="submeter()" class="p-6 md:p-10 space-y-7">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                    
                    <div class="md:col-span-2 group">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-[#2C3E50]/60 mb-2 ml-1">Nome da Estrela</label>
                        <div class="relative">
                            <input type="text" x-model="form.nome" required
                                class="w-full bg-[#FFF5F7] border-2 border-transparent rounded-2xl px-5 py-4 text-[#2C3E50] font-medium outline-none focus:bg-white focus:border-[#FF69B4]/30 transition-all"
                                placeholder="Nome completo">
                        </div>
                    </div>

                    <div class="group">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-[#2C3E50]/60 mb-2 ml-1">WhatsApp</label>
                        <input type="text" x-model="form.telefone" @input="form.telefone = masks.telefone($event.target.value)" required
                            class="w-full bg-[#FFF5F7] border-2 border-transparent rounded-2xl px-5 py-4 text-[#2C3E50] font-medium outline-none focus:bg-white focus:border-[#FFD700]/30 transition-all"
                            placeholder="(00) 00000-0000">
                    </div>

                    <div class="group">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-[#2C3E50]/60 mb-2 ml-1">CPF</label>
                        <input type="text" x-model="form.cpf" @input="form.cpf = masks.cpf($event.target.value)" required
                            class="w-full bg-[#FFF5F7] border-2 border-transparent rounded-2xl px-5 py-4 text-[#2C3E50] font-medium outline-none focus:bg-white focus:border-[#FFD700]/30 transition-all"
                            placeholder="000.000.000-00">
                    </div>

                    <div class="group">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-[#2C3E50]/60 mb-2 ml-1">CEP</label>
                        <input type="text" x-model="form.cep" @input="form.cep = masks.cep($event.target.value)" required
                            class="w-full bg-[#FFF5F7] border-2 border-transparent rounded-2xl px-5 py-4 text-[#2C3E50] font-medium outline-none focus:bg-white focus:border-[#FFD700]/30 transition-all"
                            placeholder="00000-000">
                    </div>
                    
                    <div class="group">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-[#2C3E50]/60 mb-2 ml-1">E-mail</label>
                        <input type="email" x-model="form.email" required
                            class="w-full bg-[#FFF5F7] border-2 border-transparent rounded-2xl px-5 py-4 text-[#2C3E50] font-medium outline-none focus:bg-white focus:border-[#FFD700]/30 transition-all"
                            placeholder="email@exemplo.com">
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" :disabled="loading"
                        class="group w-full bg-[#2C3E50] hover:bg-[#1a252f] text-white py-5 rounded-2xl font-bold uppercase tracking-[0.4em] text-[10px] shadow-lg shadow-[#2C3E50]/20 transition-all active:scale-[0.98] disabled:opacity-70 flex items-center justify-center gap-3 border-none">
                        
                        <template x-if="!loading">
                            <span class="flex items-center gap-3">
                                FINALIZAR CADASTRO
                                <i class="fa-solid fa-arrow-right text-[8px] group-hover:translate-x-1 transition-transform"></i>
                            </span>
                        </template>
                        
                        <template x-if="loading">
                            <i class="fa-solid fa-circle-notch animate-spin"></i>
                        </template>
                    </button>
                </div>
            </form>
        </div>

        <div class="hidden md:flex w-1/3 flex-col gap-4">
            <div class="flex-1 bg-[#2C3E50] rounded-[2rem] p-8 relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-[#FFD700]/10 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                <h3 class="text-white text-2xl mb-4 relative z-10" style="font-family: 'The Seasons', serif;">Excelência no Atendimento</h3>
                <p class="text-white/60 text-xs leading-relaxed italic">"O sucesso é a soma de pequenos esforços repetidos dia após dia."</p>
                <div class="mt-8 pt-8 border-t border-white/10 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full border border-[#FFD700]/30 flex items-center justify-center text-[#FFD700]">
                        <i class="fa-solid fa-gem"></i>
                    </div>
                    <span class="text-[10px] text-white uppercase tracking-widest font-bold">Padrão Ouro</span>
                </div>
            </div>
            
            <div class="h-1/3 bg-[#FFF5F7] border border-[#FF69B4]/10 rounded-[2rem] flex items-center justify-center relative overflow-hidden">
                 <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
                 <i class="fa-solid fa-award text-4xl text-[#FF69B4]/20"></i>
            </div>
        </div>
    </div>

    <div class="fixed top-6 left-4 right-4 md:left-auto md:right-8 z-[110] flex flex-col gap-3 pointer-events-none">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-show="toast.show" 
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="-translate-y-12 opacity-0"
                 x-transition:enter-end="translate-y-0 opacity-100"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="flex items-center gap-4 px-6 py-4 rounded-2xl shadow-2xl border-t-4 text-white pointer-events-auto min-w-[300px]"
                 :class="toast.type === 'success' ? 'bg-[#2C3E50] border-[#FFD700]' : 'bg-[#FF6F61] border-white/20'">
                
                <i class="fa-solid text-lg" :class="toast.type === 'success' ? 'fa-circle-check text-[#FFD700]' : 'fa-circle-exclamation'"></i>
                
                <div class="flex flex-col">
                    <span class="text-[10px] font-bold leading-tight" x-text="toast.message"></span>
                </div>

                <button @click="toast.show = false" class="ml-auto opacity-50 hover:opacity-100 transition-opacity">
                    <i class="fa-solid fa-xmark text-xs"></i>
                </button>
            </div>
        </template>
    </div>
</div>
@endsection
