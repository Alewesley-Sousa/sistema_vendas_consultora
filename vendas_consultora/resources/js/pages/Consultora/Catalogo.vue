<template>
  <AppLayout>
    <!-- MUDANÇA: Adicionado dark:text-slate-100 para herança de cor base legível -->
    <div class="relative min-h-screen font-sans antialiased text-[#2C3E50] dark:text-slate-100 pb-36">
      
      <!-- BANNER DE DESTAQUE SUPERIOR -->
      <!-- MUDANÇA: Adicionado dark:bg-slate-950 e ajuste sutil de borda para conter o contraste -->
      <div 
        :class="view === 'detalhes' ? 'p-5 md:p-8 rounded-[1.5rem] md:rounded-[2.5rem]' : 'p-8 rounded-[2.5rem]'"
        class="relative bg-[#2C3E50] dark:bg-slate-950 text-white shadow-2xl overflow-hidden mb-6 border border-white/5 dark:border-slate-800/40 transition-all duration-300"
      >
        <div class="absolute -top-12 -right-12 w-48 h-48 bg-[#FF7665] opacity-10 rounded-full blur-3xl"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
          
          <div class="flex items-center gap-4">
            <button 
              v-if="view === 'detalhes'" 
              @click="voltarParaGrid"
              class="p-2.5 bg-white/10 hover:bg-white/20 active:scale-95 rounded-xl transition-all border border-white/10"
              title="Voltar para coleções"
            >
              <svg class="w-5 h-5 text-[#FFD700]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>

            <div class="border-l-4 border-[#FFD700] pl-4 py-0.5">
              <h1 :class="view === 'detalhes' ? 'text-2xl' : 'text-3xl'" class="font-serif font-black tracking-tighter transition-all">
                Catálogos <span class="text-[#FFD700] italic ml-1">Exclusivos</span>
              </h1>
              <p class="text-[9px] uppercase tracking-[0.3em] text-gray-400 dark:text-slate-500 mt-0.5 font-bold">Glow Cosmetics Business</p>
            </div>
          </div>
          
          <!-- INPUT DE BUSCA NA GRID -->
          <div class="relative w-full md:w-80" v-if="view === 'grid'">
            <!-- MUDANÇA: Ajuste de foco e placeholder para combinar com o contraste escuro -->
            <input 
              type="text" 
              v-model="search" 
              @input="currentPage = 1" 
              placeholder="Buscar coleção..." 
              class="w-full bg-white/10 border border-white/20 dark:border-slate-800 rounded-2xl py-3.5 pl-12 pr-10 text-sm text-white placeholder-gray-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-[#FFD700]"
            >
            <svg class="w-5 h-5 absolute left-4 top-3.5 text-[#FFD700]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2.5" stroke-linecap="round" />
            </svg>
            <button v-if="search" @click="search = ''" class="absolute right-4 top-4 text-gray-400 hover:text-white text-xs font-bold">✕</button>
          </div>

          <!-- INPUT DE BUSCA E FILTROS EM DETALHES -->
          <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto" v-if="view === 'detalhes'">
            <div class="relative flex-1 sm:w-64">
              <input 
                type="text" 
                v-model="searchProd" 
                @input="currentProdPage = 1" 
                placeholder="Buscar produto..." 
                class="w-full bg-white/10 border border-white/20 dark:border-slate-800 rounded-2xl py-2.5 pl-10 pr-8 text-sm text-white focus:outline-none focus:ring-2 focus:ring-[#FFD700]"
              >
              <svg class="w-4 h-4 absolute left-4 top-3 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2" stroke-linecap="round" />
              </svg>
              <button v-if="searchProd" @click="searchProd = ''" class="absolute right-3 top-3 text-gray-400 hover:text-white text-xs">✕</button>
            </div>
            
            <!-- MUDANÇA: Dropdown select adaptado com dark:bg-slate-900 -->
            <select v-model="sortBy" class="bg-[#2C3E50] dark:bg-slate-900 border border-white/20 dark:border-slate-800 rounded-2xl py-2.5 px-4 text-xs font-bold text-white focus:outline-none focus:ring-2 focus:ring-[#FFD700]">
              <option value="nome_asc">Nome (A-Z)</option>
              <option value="nome_desc">Nome (Z-A)</option>
              <option value="preco_asc">Menor Preço</option>
              <option value="preco_desc">Maior Preço</option>
            </select>
          </div>
        </div>
      </div>

      <!-- RECURSO DE NAVEGAÇÃO DE FILTROS/STATUS -->
      <!-- MUDANÇA: Fundo do trilho alterado de gray-100 para dark:bg-slate-900 -->
      <div v-if="view === 'grid' && !loading" class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8 px-2">
        <div class="flex gap-1.5 bg-gray-100 dark:bg-slate-900 p-1 rounded-2xl w-full sm:w-auto border border-transparent dark:border-slate-800/60">
          <!-- MUDANÇA: Botões ativos/inativos adaptados com dark:bg-slate-950 e dark:text-slate-400 -->
          <button 
            @click="filtroStatus = 'todos'" 
            :class="filtroStatus === 'todos' ? 'bg-white dark:bg-slate-950 text-[#2C3E50] dark:text-white shadow-sm font-black' : 'text-gray-500 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white font-bold'"
            class="flex-1 sm:flex-none px-5 py-2.5 rounded-xl text-xs uppercase tracking-wider transition-all"
          >
            Todos ({{ catalogos.length }})
          </button>
          <button 
            @click="filtroStatus = 'ativos'" 
            :class="filtroStatus === 'ativos' ? 'bg-white dark:bg-slate-950 text-green-600 dark:text-emerald-400 shadow-sm font-black' : 'text-gray-500 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white font-bold'"
            class="flex-1 sm:flex-none px-5 py-2.5 rounded-xl text-xs uppercase tracking-wider transition-all"
          >
            Ativos ({{ catalogos.filter(c => !c.encerrado).length }})
          </button>
          <button 
            @click="filtroStatus = 'encerrados'" 
            :class="filtroStatus === 'encerrados' ? 'bg-white dark:bg-slate-950 text-red-500 dark:text-rose-400 shadow-sm font-black' : 'text-gray-500 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white font-bold'"
            class="flex-1 sm:flex-none px-5 py-2.5 rounded-xl text-xs uppercase tracking-wider transition-all"
          >
            Encerrados
          </button>
        </div>
        <p class="text-[11px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest pl-1">Exibindo {{ filteredCatalogos.length }} resultado(s)</p>
      </div>

      <!-- BLOCKS SKELETON LOADERS -->
      <!-- MUDANÇA: Alteração das cores estáticas de animação para variações dark:bg-slate-900 e dark:border-slate-800 -->
      <div v-if="loading" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <div v-for="n in 6" :key="n" class="bg-white dark:bg-slate-900 p-5 rounded-3xl border border-gray-100 dark:border-slate-800/80 animate-pulse space-y-4">
          <div class="h-40 bg-gray-200 dark:bg-slate-950 rounded-2xl w-full"></div>
          <div class="h-5 bg-gray-200 dark:bg-slate-950 rounded-lg w-3/4"></div>
          <div class="h-4 bg-gray-200 dark:bg-slate-950 rounded-lg w-1/2"></div>
          <div class="h-10 bg-gray-200 dark:bg-slate-950 rounded-xl w-full pt-4"></div>
        </div>
      </div>

      <!-- COMPONENTES DE GRID E PRODUTOS (Certifique-se de aplicar dark mode internamente neles também) -->
      <CatalogoGrid 
        v-if="view === 'grid'"
        :view="view" 
        :loading="loading" 
        :paginated-catalogos="paginatedCatalogos"
        @abrir-catalogo="abrirCatalogo"
      />

      <CatalogoProdutos 
        v-if="view === 'detalhes'"
        :view="view"
        :loading="loading"
        :paginated-produtos="paginatedProdutos"
        :carrinho="carrinho"
        @voltar="voltarParaGrid"
        @adicionar-produto="adicionar"
      />

      <!-- MENSAGEM VAZIA (NOT FOUND STATE) -->
      <!-- MUDANÇA: Box adaptado de bg-white para dark:bg-slate-900 e bordas corrigidas -->
      <div v-if="!loading && ((view === 'grid' && filteredCatalogos.length === 0) || (view === 'detalhes' && filteredProdutos.length === 0))" 
           class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-dashed border-gray-200 dark:border-slate-800 p-16 text-center shadow-sm max-w-xl mx-auto my-12 animate-fadeIn"
      >
        <div class="w-16 h-16 bg-gray-50 dark:bg-slate-950 text-gray-400 dark:text-slate-500 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <h4 class="text-lg font-bold text-[#2C3E50] dark:text-slate-200">Nenhum item correspondente</h4>
        <p class="text-sm text-gray-400 dark:text-slate-500 mt-1 max-w-sm mx-auto">Não encontramos registros para os termos pesquisados ou filtros selecionados no momento.</p>
      </div>

      <!-- DRAWERS E INTERFACES FLUTUANTES -->
      <CarrinhoLateral 
        :carrinho="carrinho"
        v-model:cartOpen="cartOpen"
        :total-carrinho="totalCarrinho"
        @alterar-qtd="alterarQtd"
        @abrir-checkout="checkoutModal = true"
      />

      <ModalCheckout 
        v-model:checkoutModal="checkoutModal"
        :carrinho="carrinho"
        :total-carrinho="totalCarrinho"
        :checkout-data="checkoutData"
        :validating="validating"
        @verificar-cpf="verificarCliente"
        @limpar-cliente="limparCliente"
        @finalizar-venda="finalizarVenda"
      />

    </div>
  </AppLayout>
</template>

<script setup>
import { ref, computed, reactive, onMounted } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import Swal from 'sweetalert2'

import CatalogoGrid from './Partials/CatalogoGrid.vue'
import CatalogoProdutos from './Partials/CatalogoProdutos.vue'
import CarrinhoLateral from './Partials/CarrinhoLateral.vue'
import ModalCheckout from './Partials/ModalCheckout.vue'

// ESTADOS REATIVOS
const view = ref('grid')
const loading = ref(false)
const validating = ref(false)
const cartOpen = ref(false)
const checkoutModal = ref(false)
const search = ref('')
const searchProd = ref('')
const sortBy = ref('nome_asc')
const filtroStatus = ref('todos')

const currentPage = ref(1)
const currentProdPage = ref(1)
const perPage = ref(8)
const selectedCatalogo = ref(null)
const carrinho = ref([])
const catalogos = ref([])

// DADOS DO CHECKOUT
const checkoutData = reactive({
  cpf: '',
  nome: '',
  cliente_id: null,
  verificado: false,
  pagamento: 'pix',
  subMetodo: '',
  parcelas: 1
})

onMounted(() => {
  fetchCatalogos()
})

// REQUISIÇÃO REAL: API CATALOGOS
const fetchCatalogos = async () => {
  loading.value = true
  try {
    const response = await fetch('/api/catalogos')
    const result = await response.json()
    const dataRaw = result.data || result
    const hoje = new Date()

    if (Array.isArray(dataRaw)) {
      catalogos.value = dataRaw
        .filter(cat => cat.tipo_catalogo_id !== 1)
        .map(cat => {
          const dataFim = new Date(cat.data_encerramento)
          return {
            id: cat.id,
            titulo: cat.nome,
            validade: dataFim.toLocaleDateString('pt-BR'),
            encerrado: dataFim < hoje,
            descricao: cat.descricao,
            img: cat.imagem_url || null,
            produtos: []
          }
        })
    }
  } catch (e) {
    console.error('Erro ao buscar catálogos:', e)
  } finally {
    loading.value = false
  }
}

// REQUISIÇÃO REAL: API ITENS DO CATÁLOGO
const abrirCatalogo = async (cat) => {
  if (cat.encerrado) return
  selectedCatalogo.value = cat
  loading.value = true
  view.value = 'detalhes'
  
  try {
    const response = await fetch(`/api/catalogos/${cat.id}/itens`)
    const result = await response.json()
    const itensRaw = result.data || result

    if (Array.isArray(itensRaw)) {
      selectedCatalogo.value.produtos = itensRaw.map(item => {
        let rawImg = item.produto.imagem_url
        let finalImg = null

        if (rawImg) {
          if (rawImg.startsWith('http://') || rawImg.startsWith('https://') || rawImg.startsWith('/')) {
            finalImg = rawImg
          } else {
            finalImg = `/storage/${rawImg}`
          }
        }

        return {
          id: item.id, // ID do Item do catálogo usado na transação de pedido
          nome: item.produto.nome,
          preco: parseFloat(item.produto.preco_final),
          img: finalImg,
          estoque: item.estoque_disponivel,
          status: item.status?.nome || 'Ativo'
        }
      })
    }
  } catch (e) {
    console.error('Erro ao abrir catálogo:', e)
  } finally {
    loading.value = false
    window.scrollTo({ top: 0, behavior: 'smooth' })
  }
}

// REQUISIÇÃO REAL: API VERIFICAÇÃO DE CLIENTE PELO CPF
const verificarCliente = async (cleanCPF) => {
  if (cleanCPF.length < 11) {
    return Swal.fire('Ops!', 'O CPF deve ter 11 dígitos.', 'warning')
  }

  validating.value = true
  try {
    const response = await fetch(`/api/cliente/${cleanCPF}`)
    const result = await response.json()

    if (response.ok && (result.data || result.id)) {
      const cliente = result.data || result
      checkoutData.nome = cliente.nome
      checkoutData.cliente_id = cliente.id
      checkoutData.verificado = true
      
      Swal.fire({
        icon: 'success',
        title: 'Cliente Identificado',
        text: `Cliente: ${cliente.nome}`,
        timer: 1500,
        showConfirmButton: false
      })
    } else {
      throw new Error()
    }
  } catch (e) {
    checkoutData.verificado = false
    Swal.fire({
      icon: 'error',
      title: 'Cliente não encontrado',
      text: 'Verifique o CPF ou cadastre um novo cliente.',
      confirmButtonColor: '#2C3E50'
    })
  } finally {
    validating.value = false
  }
}

const limparCliente = () => {
  checkoutData.cpf = ''
  checkoutData.nome = ''
  checkoutData.verificado = false
  checkoutData.cliente_id = null
}

// REQUISIÇÃO REAL: POST ENVIAR PEDIDO E FINALIZAR VENDA
const finalizarVenda = async () => {
  if (!checkoutData.verificado) return Swal.fire('Aviso', 'Valide o CPF primeiro.', 'warning')
  if (carrinho.value.length === 0) return Swal.fire('Aviso', 'Carrinho vazio.', 'info')

  loading.value = true

  let metPag = checkoutData.pagamento
  if (metPag === 'cartao') metPag = checkoutData.subMetodo

  if (!metPag || metPag === 'cartao') {
    loading.value = false
    return Swal.fire('Pagamento', 'Selecione Crédito ou Débito.', 'warning')
  }

  const payload = {
    cliente_id: checkoutData.cliente_id,
    status_id: 1,
    tipo_pagamento: metPag,
    itens: carrinho.value.map(item => ({
      item_catalogo_id: item.id,
      quantidade: item.qtd,
      preco_unitario: item.preco
    }))
  }

  try {
    const tokenMeta = document.querySelector('meta[name="csrf-token"]')
    const csrf = tokenMeta ? tokenMeta.content : ''

    const response = await fetch('/api/pedido', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': csrf
      },
      body: JSON.stringify(payload)
    })

    const res = await response.json()

    if (response.ok && (res.status === 'success' || res.data)) {
      const dataResponse = res.data || res
      const linkPedido = dataResponse.link_cliente
      const textoWhats = encodeURIComponent(`Olá, ${checkoutData.nome}! Seu pedido na Glow Cosmetics foi realizado com sucesso. ✨\n\nConfira os detalhes aqui: ${linkPedido}`)
      const linkWhats = `https://api.whatsapp.com/send?text=${textoWhats}`

      Swal.fire({
        title: '✨ Pedido Realizado!',
        html: `
          <div class="text-left space-y-4">
              <p>Pedido <b>#${dataResponse.id}</b> gerado para ${checkoutData.nome}.</p>
              <div class="p-3 bg-gray-50 rounded-lg border border-dashed text-xs break-all font-mono">
                  ${linkPedido}
              </div>
          </div>
        `,
        icon: 'success',
        showCancelButton: true,
        confirmButtonText: 'Enviar via WhatsApp',
        cancelButtonText: 'Copiar apenas o link',
        confirmButtonColor: '#25D366',
        cancelButtonColor: '#FF7665'
      }).then((resultAction) => {
        if (resultAction.isConfirmed) {
          window.open(linkWhats, '_blank')
        } else if (resultAction.dismiss === Swal.DismissReason.cancel) {
          navigator.clipboard.writeText(linkPedido)
        }
        limparCarrinho()
        checkoutModal.value = false
        fetchCatalogos() // Atualiza os estoques no front
      })
    } else {
      throw new Error(res.mensagem || 'Erro ao processar requisição no servidor.')
    }
  } catch (e) {
    Swal.fire('Erro', e.message, 'error')
  } finally {
    loading.value = false
  }
}

const voltarParaGrid = () => {
  view.value = 'grid'
  selectedCatalogo.value = null
  searchProd.value = ''
  currentProdPage.value = 1
}

const adicionar = (payload) => {
  const { produto, quantidade } = payload
  if (!produto || produto.estoque <= 0 || quantidade <= 0) return

  let item = carrinho.value.find(i => i.id === produto.id)
  
  if (item) {
    const novaQtd = item.qtd + quantidade
    if (novaQtd <= produto.estoque) {
      item.qtd = novaQtd
    } else {
      item.qtd = produto.estoque
      Swal.fire('Estoque Limite', `Limite máximo atingido (${produto.estoque} unidades).`, 'warning')
    }
  } else {
    const qtdFinal = quantidade <= produto.estoque ? quantidade : produto.estoque
    carrinho.value.push({ ...produto, qtd: qtdFinal })
  }
}

const alterarQtd = (id, delta) => {
  let item = carrinho.value.find(i => i.id === id)
  if (item) {
    item.qtd += delta
    if (item.qtd <= 0) {
      carrinho.value = carrinho.value.filter(i => i.id !== id)
    } else if (item.qtd > item.estoque) {
      item.qtd = item.estoque
    }
  }
}

const limparCarrinho = () => {
  carrinho.value = []
  cartOpen.value = false
  limparCliente()
}

// COMPUTEDS
const filteredCatalogos = computed(() => {
  let resultado = catalogos.value
  if (filtroStatus.value === 'ativos') resultado = resultado.filter(c => !c.encerrado)
  if (filtroStatus.value === 'encerrados') resultado = resultado.filter(c => c.encerrado)
  return resultado.filter(i => i.titulo.toLowerCase().includes(search.value.toLowerCase()))
})

const paginatedCatalogos = computed(() => {
  return filteredCatalogos.value.slice((currentPage.value - 1) * perPage.value, currentPage.value * perPage.value)
})

const filteredProdutos = computed(() => {
  if (!selectedCatalogo.value || !selectedCatalogo.value.produtos) return []
  let prods = selectedCatalogo.value.produtos.filter(p => p.nome.toLowerCase().includes(searchProd.value.toLowerCase()))
  return prods.sort((a, b) => {
    if (sortBy.value === 'nome_asc') return a.nome.localeCompare(b.nome)
    if (sortBy.value === 'nome_desc') return b.nome.localeCompare(a.nome)
    if (sortBy.value === 'preco_asc') return a.preco - b.preco
    if (sortBy.value === 'preco_desc') return b.preco - a.preco
    return 0
  })
})

const paginatedProdutos = computed(() => {
  return filteredProdutos.value.slice((currentProdPage.value - 1) * perPage.value, currentProdPage.value * perPage.value)
})

const totalCarrinho = computed(() => {
  return carrinho.value.reduce((sum, item) => sum + (item.preco * item.qtd), 0)
})
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght=900&family=Poppins:wght=400;700;900&display=swap');
.font-serif { font-family: 'Playfair Display', serif; }

.animate-fadeIn {
  animation: fadeIn 0.4s ease-out forwards;
}
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(8px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>