@extends('layouts.appAdmin')
@section('header', 'Solicitações da Distribuidora')

@section('content')
@php
    $itensPorPagina = 5;
    $paginaInicialSaques = request()->query('pagina_saques', 1);
    $paginaInicialCadastros = request()->query('pagina_cadastros', 1);
@endphp

<div x-data="{ 
    tab: 'saques',
    paginaSaques: {{ $paginaInicialSaques }},
    paginaCadastros: {{ $paginaInicialCadastros }},
    saques: [],
    preCadastros: [],
    itensPorPagina: {{ $itensPorPagina }},
    carregando: false,
    
    // Estados do Modal Customizado
    modalConfirmacao: {
        aberto: false,
        id: null,
        statusId: null, // Usado para saques
        decisao: null,  // Usado para pré-cadastros (1=aprovar, 0=recusar)
        tipo: '',       // 'aprovar' ou 'recusar'
        contexto: '',   // 'saque' ou 'cadastro'
        nome: '',       // Nome da consultora / candidata
        detalhe: ''     // Valor do saque ou CPF do cadastro
    },

    // Estados do Toast de Feedback
    toast: {
        visivel: false,
        mensagem: '',
        tipo: 'success' // 'success' ou 'error'
    },
    
    init() {
        this.buscarSaquesPendentes();
        this.buscarPreCadastrosPendentes();
    },

    // Disparador do Toast com Auto-dismiss
    mostrarFeedback(mensagem, tipo = 'success') {
        this.toast.mensagem = mensagem;
        this.toast.tipo = tipo;
        this.toast.visivel = true;
        
        setTimeout(() => {
            this.toast.visivel = false;
        }, 4000);
    },

    async buscarSaquesPendentes() {
        try {
            const response = await fetch('/api/comissao/pendentes', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const resultado = await response.json();
            
            if (resultado.status === 'success') {
                this.saques = resultado.data;
            } else {
                console.error('Erro ao buscar saques:', resultado.message);
            }
        } catch (error) {
            console.error('Erro de conexão com o servidor:', error);
        }
    },

    async buscarPreCadastrosPendentes() {
        try {
            const response = await fetch('/api/usuario/pre-cadastros', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const resultado = await response.json();
            
            if (resultado.status === 'success') {
                this.preCadastros = resultado.data;
            } else {
                console.error('Erro ao buscar pré-cadastros:', resultado.mensagem);
            }
        } catch (error) {
            console.error('Erro de conexão com o servidor:', error);
        }
    },

    confirmarAcaoSaque(saque, statusId) {
        this.modalConfirmacao = {
            aberto: true,
            id: saque.id,
            statusId: statusId,
            decisao: null,
            tipo: statusId === 2 ? 'aprovar' : 'recusar',
            contexto: 'saque',
            nome: saque.consultora ? saque.consultora.nome : 'Sem nome',
            detalhe: 'no valor de R$ ' + parseFloat(saque.valor_solicitado).toFixed(2).replace('.', ',')
        };
    },

    confirmarAcaoCadastro(cadastro, decisao) {
        this.modalConfirmacao = {
            aberto: true,
            id: cadastro.id,
            statusId: null,
            decisao: decisao, // 1 = Aprovar, 0 = Recusar
            tipo: decisao === 1 ? 'aprovar' : 'recusar',
            contexto: 'cadastro',
            nome: cadastro.nome,
            detalhe: 'com o CPF ' + cadastro.cpf
        };
    },

    // Processador Unificado de Confirmações
    async executarAcaoConfirmada() {
        if (this.modalConfirmacao.contexto === 'saque') {
            await this.processarSaque();
        } else if (this.modalConfirmacao.contexto === 'cadastro') {
            await this.processarCadastro();
        }
    },

    async processarSaque() {
        if (this.carregando) return;
        
        const id = this.modalConfirmacao.id;
        const statusId = this.modalConfirmacao.statusId;
        const nomeAlvo = this.modalConfirmacao.nome;
        const acaoTexto = this.modalConfirmacao.tipo === 'aprovar' ? 'aprovada' : 'recusada';
        
        this.carregando = true;
        this.modalConfirmacao.aberto = false; 

        try {
            const response = await fetch(`/api/comissao/processar/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=&quot;csrf-token&quot;]')?.getAttribute('content')
                },
                body: JSON.stringify({ status_id: statusId })
            });

            const resultado = await response.json();

            if (resultado.status === 'success') {
                this.saques = this.saques.filter(s => s.id !== id);
                
                if (this.paginaSaques > this.totalPaginasSaques && this.paginaSaques > 1) {
                    this.paginaSaques--;
                }
                
                this.mostrarFeedback(`Solicitação de ${nomeAlvo} foi ${acaoTexto} com sucesso!`, 'success');
            } else {
                this.mostrarFeedback(resultado.message || 'Ocorreu um erro ao processar a ação.', 'error');
            }
        } catch (error) {
            this.mostrarFeedback('Erro de comunicação com o servidor. Tente novamente.', 'error');
        } finally {
            this.carregando = false;
        }
    },

    async processarCadastro() {
        if (this.carregando) return;

        const id = this.modalConfirmacao.id;
        const decisao = this.modalConfirmacao.decisao;
        const nomeAlvo = this.modalConfirmacao.nome;
        const acaoTexto = decisao === 1 ? 'aprovado' : 'recusado/deletado';

        this.carregando = true;
        this.modalConfirmacao.aberto = false;

        try {
            const response = await fetch(`/api/usuario/${id}/aprovacao`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=&quot;csrf-token&quot;]')?.getAttribute('content')
                },
                body: JSON.stringify({ decisao: decisao })
            });

            const resultado = await response.json();

            if (resultado.status === 'success') {
                // Remove reativamente da lista local
                this.preCadastros = this.preCadastros.filter(c => c.id !== id);

                if (this.paginaCadastros > this.totalPaginasCadastros && this.paginaCadastros > 1) {
                    this.paginaCadastros--;
                }

                this.mostrarFeedback(`O pré-cadastro de ${nomeAlvo} foi ${acaoTexto} com sucesso!`, 'success');
            } else {
                this.mostrarFeedback(resultado.mensagem || 'Erro ao processar o pré-cadastro.', 'error');
            }
        } catch (error) {
            this.mostrarFeedback('Erro de comunicação com o servidor. Tente novamente.', 'error');
        } finally {
            this.carregando = false;
        }
    },
    
    get saquesPagina() {
        const inicio = (this.paginaSaques - 1) * this.itensPorPagina;
        return this.saques.slice(inicio, inicio + this.itensPorPagina);
    },
    get cadastrosPagina() {
        const inicio = (this.paginaCadastros - 1) * this.itensPorPagina;
        return this.preCadastros.slice(inicio, inicio + this.itensPorPagina);
    },
    get totalPaginasSaques() {
        return Math.ceil(this.saques.length / this.itensPorPagina);
    },
    get totalPaginasCadastros() {
        return Math.ceil(this.preCadastros.length / this.itensPorPagina);
    },
    get inicioSaques() {
        return (this.paginaSaques - 1) * this.itensPorPagina;
    },
    get inicioCadastros() {
        return (this.paginaCadastros - 1) * this.itensPorPagina;
    },
    
    mudarPaginaSaques(pagina) {
        if (pagina < 1 || pagina > this.totalPaginasSaques) return;
        this.paginaSaques = pagina;
    },
    mudarPaginaCadastros(pagina) {
        if (pagina < 1 || pagina > this.totalPaginasCadastros) return;
        this.paginaCadastros = pagina;
    },
    formatarData(data) {
        if (!data) return '';
        const partesData = data.split('T')[0].split('-');
        if (partesData.length !== 3) return data;
        const [ano, mes, dia] = partesData;
        return `${dia}/${mes}/${ano}`;
    }
}" class="space-y-6">

    <div class="flex gap-2 p-1 bg-white border border-slate-100 rounded-2xl w-fit shadow-sm">
        <button @click="tab = 'saques'" 
                :class="tab === 'saques' ? 'bg-blue-600 text-white shadow-lg scale-105' : 'text-slate-500 hover:bg-slate-50'"
                class="px-6 py-2.5 rounded-xl text-xs font-bold transition-all duration-300">
            Solicitações de Saque
        </button>
        <button @click="tab = 'cadastros'" 
                :class="tab === 'cadastros' ? 'bg-blue-600 text-white shadow-lg scale-105' : 'text-slate-500 hover:bg-slate-50'"
                class="px-6 py-2.5 rounded-xl text-xs font-bold transition-all duration-300">
            Pré-cadastros
        </button>
    </div>

    <div x-show="tab === 'saques'" 
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 translate-y-8"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-[-20px]"
         x-cloak 
         class="bg-white rounded-3xl border border-slate-100 shadow-lg overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-[#0F172A]">Solicitações de Saque</h3>
                    <p class="text-xs text-slate-400 mt-1" x-text="saques.length + ' solicitação(ões) total'"></p>
                </div>
                <div class="flex items-center gap-2 px-3 py-1.5 bg-blue-100 rounded-lg">
                    <span class="w-2 h-2 bg-blue-600 rounded-full animate-pulse"></span>
                    <span class="text-[10px] font-bold text-blue-600 uppercase">Pendente</span>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-[10px] uppercase text-slate-400 font-bold">
                        <th class="p-4">ID</th>
                        <th class="p-4">Consultora</th>
                        <th class="p-4">Valor</th>
                        <th class="p-4">Data</th>
                        <th class="p-4 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="text-xs text-slate-700">
                    <template x-if="saques.length === 0">
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-400">
                                Nenhuma solicitação de saque pendente encontrada.
                            </td>
                        </tr>
                    </template>

                    <template x-for="(s, index) in saquesPagina" :key="'saque-' + s.id">
                        <tr class="border-t border-slate-50 hover:bg-blue-50 transition-colors cursor-pointer group"
                            :style="'animation-delay: ' + (index * 0.08) + 's'">
                            <td class="p-4 font-bold text-blue-600" x-text="'#' + s.id"></td>
                            <td class="p-4 font-medium" x-text="s.consultora ? s.consultora.nome : 'Sem nome'"></td>
                            <td class="p-4 font-bold text-blue-600" x-text="'R$ ' + parseFloat(s.valor_solicitado).toFixed(2).replace('.', ',')"></td>
                            <td class="p-4 text-slate-500" x-text="formatarData(s.data_solicitacao)"></td>
                            <td class="p-4 text-right space-x-2">
                                <button @click="confirmarAcaoSaque(s, 2)"
                                        :disabled="carregando"
                                        class="px-3 py-1.5 bg-emerald-100 text-emerald-600 rounded-lg font-bold hover:bg-emerald-200 transition-all transform hover:scale-105 active:scale-95 text-[10px]">
                                    Aprovar
                                </button>
                                <button @click="confirmarAcaoSaque(s, 3)"
                                        :disabled="carregando"
                                        class="px-3 py-1.5 bg-red-100 text-red-600 rounded-lg font-bold hover:bg-red-200 transition-all transform hover:scale-105 active:scale-95 text-[10px]">
                                    Recusar
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <template x-if="totalPaginasSaques > 1">
            <div class="p-4 border-t border-slate-100 bg-slate-50 flex items-center justify-between">
                <p class="text-[10px] text-slate-400">
                    <span x-text="'Mostrando ' + (inicioSaques + 1) + ' - ' + Math.min(inicioSaques + itensPorPagina, saques.length) + ' de ' + saques.length"></span>
                </p>
                <div class="flex gap-2">
                    <button @click="mudarPaginaSaques(paginaSaques - 1)" 
                            :disabled="paginaSaques === 1"
                            class="px-3 py-1.5 text-xs font-bold rounded-lg bg-white border border-slate-200 hover:bg-slate-100 transition-all"
                            :class="paginaSaques === 1 ? 'opacity-50 cursor-not-allowed' : ''">
                        Anterior
                    </button>
                    <template x-for="i in totalPaginasSaques">
                        <button @click="mudarPaginaSaques(i)" 
                                class="px-3 py-1.5 text-xs font-bold rounded-lg border border-slate-200 transition-all"
                                :class="paginaSaques === i ? 'bg-blue-600 text-white' : 'bg-white text-slate-500 hover:bg-slate-100'"
                                x-text="i">
                        </button>
                    </template>
                    <button @click="mudarPaginaSaques(paginaSaques + 1)" 
                            :disabled="paginaSaques === totalPaginasSaques"
                            class="px-3 py-1.5 text-xs font-bold rounded-lg bg-white border border-slate-200 hover:bg-slate-100 transition-all"
                            :class="paginaSaques === totalPaginasSaques ? 'opacity-50 cursor-not-allowed' : ''">
                        Próxima
                    </button>
                </div>
            </div>
        </template>
    </div>

    <div x-show="tab === 'cadastros'" 
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 translate-y-8"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-[-20px]"
         x-cloak 
         class="bg-white rounded-3xl border border-slate-100 shadow-lg overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-[#0F172A]">Pré-cadastros</h3>
                    <p class="text-xs text-slate-400 mt-1" x-text="preCadastros.length + ' pré-cadastro(s) total'"></p>
                </div>
                <div class="flex items-center gap-2 px-3 py-1.5 bg-blue-100 rounded-lg">
                    <span class="w-2 h-2 bg-blue-600 rounded-full animate-pulse"></span>
                    <span class="text-[10px] font-bold text-blue-600 uppercase">Pendente</span>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-[10px] uppercase text-slate-400 font-bold">
                        <th class="p-4">ID</th>
                        <th class="p-4">Nome</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Telefone</th>
                        <th class="p-4">CPF</th>
                        <th class="p-4 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="text-xs text-slate-700">
                    <template x-if="preCadastros.length === 0">
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400">
                                Nenhum pré-cadastro pendente encontrado.
                            </td>
                        </tr>
                    </template>

                    <template x-for="(c, index) in cadastrosPagina" :key="'cadastro-' + c.id">
                        <tr class="border-t border-slate-50 hover:bg-blue-50 transition-colors cursor-pointer group"
                            :style="'animation-delay: ' + (index * 0.08) + 's'">
                            <td class="p-4 font-bold text-blue-600" x-text="'#' + c.id"></td>
                            <td class="p-4 font-medium" x-text="c.nome"></td>
                            <td class="p-4 text-slate-500" x-text="c.email"></td>
                            <td class="p-4 text-slate-500" x-text="c.telefone || 'Não informado'"></td>
                            <td class="p-4 font-mono text-[10px] text-slate-600" x-text="c.cpf"></td>
                            <td class="p-4 text-right space-x-2">
                                <button @click="confirmarAcaoCadastro(c, 1)"
                                        :disabled="carregando"
                                        class="px-3 py-1.5 bg-emerald-100 text-emerald-600 rounded-lg font-bold hover:bg-emerald-200 transition-all transform hover:scale-105 active:scale-95 text-[10px]">
                                    Aprovar
                                </button>
                                <button @click="confirmarAcaoCadastro(c, 0)"
                                        :disabled="carregando"
                                        class="px-3 py-1.5 bg-red-100 text-red-600 rounded-lg font-bold hover:bg-red-200 transition-all transform hover:scale-105 active:scale-95 text-[10px]">
                                    Rejeitar
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <template x-if="totalPaginasCadastros > 1">
            <div class="p-4 border-t border-slate-100 bg-slate-50 flex items-center justify-between">
                <p class="text-[10px] text-slate-400">
                    <span x-text="'Mostrando ' + (inicioCadastros + 1) + ' - ' + Math.min(inicioCadastros + itensPorPagina, preCadastros.length) + ' de ' + preCadastros.length"></span>
                </p>
                <div class="flex gap-2">
                    <button @click="mudarPaginaCadastros(paginaCadastros - 1)" 
                            :disabled="paginaCadastros === 1"
                            class="px-3 py-1.5 text-xs font-bold rounded-lg bg-white border border-slate-200 hover:bg-slate-100 transition-all"
                            :class="paginaCadastros === 1 ? 'opacity-50 cursor-not-allowed' : ''">
                        Anterior
                    </button>
                    <template x-for="i in totalPaginasCadastros">
                        <button @click="mudarPaginaCadastros(i)" 
                                class="px-3 py-1.5 text-xs font-bold rounded-lg border border-slate-200 transition-all"
                                :class="paginaCadastros === i ? 'bg-blue-600 text-white' : 'bg-white text-slate-500 hover:bg-slate-100'"
                                x-text="i">
                        </button>
                    </template>
                    <button @click="mudarPaginaCadastros(paginaCadastros + 1)" 
                            :disabled="paginaCadastros === totalPaginasCadastros"
                            class="px-3 py-1.5 text-xs font-bold rounded-lg bg-white border border-slate-200 hover:bg-slate-100 transition-all"
                            :class="paginaCadastros === totalPaginasCadastros ? 'opacity-50 cursor-not-allowed' : ''">
                        Próxima
                    </button>
                </div>
            </div>
        </template>
    </div>

    <div x-show="modalConfirmacao.aberto" 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-x-hidden overflow-y-auto"
         x-cloak>
         
        <div x-show="modalConfirmacao.aberto"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="modalConfirmacao.aberto = false"
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

        <div x-show="modalConfirmacao.aberto"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="relative bg-white rounded-3xl shadow-2xl border border-slate-100 max-w-md w-full p-6 overflow-hidden z-10 text-center space-y-4">
            
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full"
                 :class="modalConfirmacao.tipo === 'aprovar' ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600'">
                 
                 <template x-if="modalConfirmacao.tipo === 'aprovar'">
                     <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                     </svg>
                 </template>
                 <template x-if="modalConfirmacao.tipo === 'recusar'">
                     <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                     </svg>
                 </template>
            </div>

            <div class="space-y-1.5">
                <h3 class="text-base font-bold text-slate-900" 
                    x-text="modalConfirmacao.tipo === 'aprovar' ? 'Confirmar Aprovação' : 'Confirmar Recusa'">
                </h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Você está prestes a <span class="font-semibold" :class="modalConfirmacao.tipo === 'aprovar' ? 'text-emerald-600' : 'text-red-600'" x-text="modalConfirmacao.tipo"></span> 
                    o <span x-text="modalConfirmacao.contexto === 'saque' ? 'solicitação de saque' : 'pré-cadastro'"></span> de 
                    <span class="font-bold text-slate-800" x-text="modalConfirmacao.nome"></span> <span x-text="modalConfirmacao.detalhe"></span>.
                </p>
            </div>

            <div class="bg-slate-50 border border-slate-100 rounded-xl p-3 text-[11px] text-slate-400 text-left">
                <span x-text="modalConfirmacao.contexto === 'saque' 
                    ? 'Esta ação altera permanentemente as comissões e balanços financeiros da consultora envolvida.' 
                    : 'Aprovar o cadastro moverá a consultora para o status Ativo. Recusar irá deletar permanentemente o registro.'">
                </span>
            </div>

            <div class="grid grid-cols-2 gap-3 pt-2">
                <button @click="modalConfirmacao.aberto = false" 
                        class="px-4 py-2.5 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition-all text-xs active:scale-95">
                    Cancelar
                </button>
                <button @click="executarAcaoConfirmada()" 
                        :class="modalConfirmacao.tipo === 'aprovar' ? 'bg-emerald-600 hover:bg-emerald-700 shadow-emerald-200' : 'bg-red-600 hover:bg-red-700 shadow-red-200'"
                        class="px-4 py-2.5 text-white font-bold rounded-xl shadow-lg transition-all text-xs active:scale-95">
                    Confirmar
                </button>
            </div>
        </div>
    </div>

    <div class="fixed top-5 right-5 z-[60] max-w-sm w-full space-y-3 pointer-events-none">
        <div x-show="toast.visivel"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-[-20px] scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="pointer-events-auto bg-white rounded-2xl border border-slate-100 shadow-xl overflow-hidden flex flex-col relative"
             x-cloak>
             
            <div class="p-4 flex items-center gap-3">
                <template x-if="toast.tipo === 'success'">
                    <div class="p-2 bg-emerald-50 text-emerald-600 rounded-xl">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </template>
                
                <template x-if="toast.tipo === 'error'">
                    <div class="p-2 bg-red-50 text-red-600 rounded-xl">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                    </div>
                </template>

                <div class="flex-1">
                    <p class="text-xs font-bold text-slate-800" x-text="toast.mensagem"></p>
                </div>

                <button @click="toast.visivel = false" class="text-slate-400 hover:text-slate-600 transition-colors p-1">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div class="h-1 w-full bg-slate-50 overflow-hidden">
                <div class="h-full transition-all duration-[4000ms] linear"
                     :class="toast.tipo === 'success' ? 'bg-emerald-500' : 'bg-red-500'"
                     :style="toast.visivel ? 'width: 0%; transition-property: width;' : 'width: 100%; transition-property: none;'"></div>
            </div>
        </div>
    </div>

</div>

<style>
[x-cloak] { display: none !important; }

tbody tr {
    opacity: 0;
    animation: slideIn 0.4s ease-out forwards;
}
@keyframes slideIn {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}
.linear {
    transition-timing-function: linear !important;
}
</style>

<script>
document.addEventListener('alpine:init', () => {});
</script>
@endsection
