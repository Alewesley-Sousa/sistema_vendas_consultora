<template>
  <AppAdmin>
    <div
      class="space-y-8 relative font-['Hanken_Grotesk',sans-serif] text-slate-800 dark:text-slate-100 p-1 md:p-4"
    >
      <!-- HEADER -->
      <header class="border-b border-slate-200 dark:border-slate-800 pb-5">
        <div>
          <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
            Gestão de Catálogos & Campanhas
          </h1>

          <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
            Gerencie ciclos promocionais, vitrines e campanhas das consultoras.
          </p>
        </div>
      </header>

      <!-- CARDS -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-fade-in">
        <div
          class="bg-slate-50 dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800 rounded-2xl p-6 flex items-center justify-between transition-all hover:shadow-sm"
        >
          <div>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
              Ciclos Ativos
            </span>

            <h4 class="text-2xl font-bold text-slate-900 dark:text-white mt-1">
              {{ ativos }} Ativo(s)
            </h4>

            <p
              class="text-[11px] text-emerald-600 font-medium mt-0.5 flex items-center gap-1"
            >
              <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
              Campanhas em execução
            </p>
          </div>
        </div>

        <div
          class="bg-slate-50 dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800 rounded-2xl p-6 flex items-center justify-between"
        >
          <div>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
              Produtos em Vitrines
            </span>

            <h4 class="text-2xl font-bold text-slate-900 dark:text-white mt-1">
              {{ totalItens }} Cosméticos
            </h4>
          </div>
        </div>

        <div
          class="bg-slate-50 dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800 rounded-2xl p-6 flex items-center justify-between"
        >
          <div>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
              Média de Recompensa
            </span>

            <h4 class="text-2xl font-bold text-slate-900 dark:text-white mt-1">
              48 Pts médios
            </h4>
          </div>
        </div>
      </div>

      <!-- ACTIONS -->
      <div
        class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pt-4 border-t border-slate-200 dark:border-slate-800"
      >
        <div>
          <h3 class="text-lg font-bold text-slate-900 dark:text-white tracking-tight">
            Lista de Campanhas
          </h3>

          <p class="text-xs text-slate-400">
            Gerencie os ciclos cronológicos e vincule produtos exclusivos.
          </p>
        </div>

        <button
          @click="openModal"
          class="group flex items-center gap-2 px-4 py-3 bg-slate-900 hover:bg-slate-800 dark:bg-white dark:text-slate-900 text-white rounded-xl transition-all shadow-sm active:scale-95 duration-150 text-xs font-semibold uppercase tracking-wider"
        >
          Nova Campanha
        </button>
      </div>

      <!-- LISTA -->
      <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        <div
          v-for="(cat, index) in catalogos"
          :key="cat.id"
          class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-[1.8rem] p-6 flex flex-col justify-between transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.08)]"
          :style="{ animationDelay: `${index * 120}ms` }"
        >
          <div>
            <div class="flex items-center justify-between mb-4">
              <span
                :class="
                  cat.status === 'Ativo'
                    ? 'bg-emerald-50 text-emerald-700 border-emerald-200'
                    : 'bg-slate-100 text-slate-500 border-slate-200'
                "
                class="px-2.5 py-1 rounded-md text-[9px] font-extrabold uppercase tracking-widest border"
              >
                {{ cat.status }}
              </span>

              <button
                @click="removerCatalogo(cat)"
                class="text-slate-300 hover:text-red-500 transition-colors"
              >
                ✕
              </button>
            </div>

            <h4 class="text-base font-bold text-slate-900 dark:text-white tracking-tight">
              {{ cat.nome }}
            </h4>

            <p class="text-xs text-slate-400 mt-2 line-clamp-2 leading-relaxed">
              {{ cat.descricao }}
            </p>

            <div class="mt-6 space-y-2">
              <div
                class="flex items-center justify-between text-[10px] font-semibold text-slate-400"
              >
                <span>Vigência do Ciclo</span>

                <span>
                  {{ cat.status === 'Ativo' ? `${cat.progresso}%` : 'Aguardando' }}
                </span>
              </div>

              <div
                class="w-full h-1.5 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden"
              >
                <div
                  :class="
                    cat.status === 'Ativo'
                      ? 'bg-slate-900 dark:bg-white'
                      : 'bg-slate-300 dark:bg-slate-600'
                  "
                  class="h-full rounded-full transition-all duration-1000"
                  :style="{ width: `${cat.progresso}%` }"
                />
              </div>

              <div class="flex items-center justify-between text-[9px] text-slate-400 pt-1 font-mono">
                <span>{{ cat.publicacao }}</span>
                <span>{{ cat.encerramento }}</span>
              </div>
            </div>
          </div>

          <div
            class="mt-8 pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between"
          >
            <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400">
              <span class="text-slate-800 dark:text-white">
                {{ cat.itens_count }}
              </span>
              Itens vinculados
            </span>

            <button
              @click="openDrawer(cat)"
              class="text-[11px] font-bold text-slate-900 dark:text-white hover:opacity-70 transition"
            >
              Gerenciar Vitrine →
            </button>
          </div>
        </div>
      </div>

      <!-- DRAWER -->
      <Transition
        enter-active-class="transition duration-300 ease-out"
        enter-from-class="translate-x-full"
        enter-to-class="translate-x-0"
        leave-active-class="transition duration-200 ease-in"
        leave-from-class="translate-x-0"
        leave-to-class="translate-x-full"
      >
        <div
          v-if="drawerOpen"
          class="fixed inset-0 z-50 overflow-hidden"
        >
          <div
            class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"
            @click="drawerOpen = false"
          />

          <div class="absolute inset-y-0 right-0 flex max-w-full pl-10">
            <div
              class="pointer-events-auto w-screen max-w-xl bg-white dark:bg-slate-900 border-l border-slate-200 dark:border-slate-800 p-8 flex flex-col shadow-2xl"
            >
              <div class="flex items-start justify-between pb-6 border-b border-slate-100 dark:border-slate-800">
                <div>
                  <span
                    class="text-[9px] font-bold text-slate-400 uppercase tracking-widest"
                  >
                    Painel Relacional
                  </span>

                  <h2 class="text-xl font-bold text-slate-900 dark:text-white">
                    {{ selectedCatalogo.nome }}
                  </h2>
                </div>

                <button
                  @click="drawerOpen = false"
                  class="p-2 text-slate-400 hover:text-slate-600"
                >
                  ✕
                </button>
              </div>

              <!-- ADD PRODUTO -->
              <div
                class="my-6 p-4 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl"
              >
                <input
                  v-model="buscaProduto"
                  type="text"
                  placeholder="Buscar produto..."
                  class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-3 py-2 text-xs"
                />

                <div class="mt-3 max-h-48 overflow-y-auto space-y-2">
                  <button
                    v-for="prod in produtosFiltrados"
                    :key="prod.id"
                    @click="selecionarProduto(prod)"
                    class="w-full text-left px-3 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 text-xs"
                  >
                    {{ prod.nome }}
                  </button>
                </div>

                <button
                  @click="addItem"
                  class="mt-4 w-full h-10 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold"
                >
                  Inserir Produto
                </button>
              </div>

              <!-- ITENS -->
              <div class="flex-1 overflow-y-auto space-y-4">
                <div
                  v-for="item in selectedCatalogo.itens"
                  :key="item.id"
                  class="p-4 border border-slate-200 dark:border-slate-800 rounded-2xl"
                >
                  <div class="flex items-center justify-between">
                    <p class="text-xs font-bold">
                      {{ item.produto }}
                    </p>

                    <button
                      @click="removeItem(item.id)"
                      class="text-red-500 text-xs"
                    >
                      Remover
                    </button>
                  </div>

                  <div class="grid grid-cols-2 gap-3 mt-3">
                    <input
                      v-model.number="item.pontos"
                      type="number"
                      class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl px-3 py-2 text-xs"
                    />

                    <input
                      v-model.number="item.estoque"
                      type="number"
                      class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl px-3 py-2 text-xs"
                    />
                  </div>
                </div>
              </div>

              <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex gap-3">
                <button
                  @click="drawerOpen = false"
                  class="flex-1 py-3 bg-slate-100 dark:bg-slate-800 rounded-xl text-xs font-bold"
                >
                  Voltar
                </button>

                <button
                  @click="salvarVitrine"
                  class="flex-1 py-3 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold"
                >
                  Salvar
                </button>
              </div>
            </div>
          </div>
        </div>
      </Transition>

      <!-- MODAL -->
      <Transition
        enter-active-class="ease-out duration-300"
        enter-from-class="opacity-0 scale-95"
        enter-to-class="opacity-100 scale-100"
        leave-active-class="ease-in duration-200"
        leave-from-class="opacity-100 scale-100"
        leave-to-class="opacity-0 scale-95"
      >
        <div
          v-if="modalOpen"
          class="fixed inset-0 z-50 overflow-y-auto"
        >
          <div
            class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center"
          >
            <div
              @click="modalOpen = false"
              class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm"
            />

            <div
              class="relative inline-block align-middle bg-white dark:bg-slate-900 rounded-[2rem] text-left overflow-hidden shadow-2xl sm:max-w-lg w-full border border-slate-200 dark:border-slate-800 p-8 space-y-6"
            >
              <div>
                <span
                  class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block"
                >
                  Painel Global
                </span>

                <h3 class="text-xl font-bold text-slate-900 dark:text-white">
                  Criar Nova Campanha
                </h3>
              </div>

              <div class="space-y-4">
                <input
                  v-model="novaCampanha.nome"
                  type="text"
                  placeholder="Nome da campanha"
                  class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-xs"
                />

                <textarea
                  v-model="novaCampanha.descricao"
                  rows="3"
                  placeholder="Descrição..."
                  class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl p-4 text-xs"
                />

                <div class="grid grid-cols-2 gap-4">
                  <input
                    v-model="novaCampanha.publicacao"
                    type="datetime-local"
                    class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl px-3 py-2 text-xs"
                  />

                  <input
                    v-model="novaCampanha.encerramento"
                    type="datetime-local"
                    class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl px-3 py-2 text-xs"
                  />
                </div>
              </div>

              <div
                class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3"
              >
                <button
                  @click="modalOpen = false"
                  class="px-5 py-2.5 bg-slate-100 dark:bg-slate-800 rounded-xl text-xs"
                >
                  Cancelar
                </button>

                <button
                  @click="gravarCampanha"
                  :disabled="!novaCampanha.nome"
                  class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs"
                >
                  Gravar Campanha
                </button>
              </div>
            </div>
          </div>
        </div>
      </Transition>
    </div>
  </AppAdmin>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import Swal from 'sweetalert2'

import AppAdmin from '../../Layouts/AdminLayout.vue'

const modalOpen = ref(false)
const drawerOpen = ref(false)

const buscaProduto = ref('')
const novoProdutoId = ref(null)

const catalogos = ref([])
const produtosInventario = ref([])

const selectedCatalogo = ref({
  id: null,
  nome: '',
  itens: []
})

const novaCampanha = ref({
  nome: '',
  tipo: 'Venda Direta Tradicional',
  status: 'Ativo (Publicado)',
  descricao: '',
  publicacao: '',
  encerramento: ''
})

const ativos = computed(() =>
  catalogos.value.filter(c => c.status === 'Ativo').length
)

const totalItens = computed(() =>
  catalogos.value.reduce((acc, curr) => acc + curr.itens_count, 0)
)

const produtosFiltrados = computed(() => {
  if (!buscaProduto.value) {
    return produtosInventario.value
  }

  return produtosInventario.value.filter(prod =>
    prod.nome.toLowerCase().includes(buscaProduto.value.toLowerCase())
  )
})

const csrf = () =>
  document.querySelector('meta[name="csrf-token"]')?.content || ''

function openModal() {
  modalOpen.value = true

  novaCampanha.value = {
    nome: '',
    tipo: 'Venda Direta Tradicional',
    status: 'Ativo (Publicado)',
    descricao: '',
    publicacao: '',
    encerramento: ''
  }
}

function selecionarProduto(prod) {
  novoProdutoId.value = prod.id
  buscaProduto.value = prod.nome
}

function notifyError(message) {
  Swal.fire({
    title: 'Erro',
    text: message,
    icon: 'error',
    confirmButtonColor: '#0F172A'
  })
}

function formatarData(dataIso) {
  if (!dataIso) return null

  const d = new Date(dataIso)

  return `${String(d.getDate()).padStart(2, '0')}/${String(
    d.getMonth() + 1
  ).padStart(2, '0')}/${d.getFullYear()}`
}

async function fetchCatalogos() {
  try {
    const res = await fetch('/api/catalogos', {
      headers: {
        Accept: 'application/json',
        'X-CSRF-TOKEN': csrf()
      }
    })

    const data = await res.json()

    catalogos.value = data.map(c => ({
      id: c.id,
      nome: c.nome,
      descricao: c.descricao || 'Sem descrição.',
      status: c.status_id === 1 ? 'Ativo' : 'Inativo',
      progresso: c.status_id === 1 ? 65 : 0,
      itens_count: c.itens_catalogo_count || 0,
      publicacao: c.data_publicacao || 'A definir',
      encerramento: c.data_encerramento || 'A definir',
      itens: []
    }))
  } catch {
    notifyError('Erro ao carregar catálogos.')
  }
}

async function fetchProdutos() {
  try {
    const res = await fetch('/api/produto')

    const data = await res.json()

    produtosInventario.value = Array.isArray(data)
      ? data
      : data.data || []
  } catch {
    notifyError('Erro ao carregar produtos.')
  }
}

async function openDrawer(catalogo) {
  drawerOpen.value = true

  try {
    const res = await fetch(`/api/catalogos/${catalogo.id}/itens`)

    const data = await res.json()

    selectedCatalogo.value = {
      ...catalogo,
      itens: (data.data || data).map(item => ({
        id: item.id,
        produto_id: item.produto_id,
        produto: item.produto?.nome,
        pontos: item.pontos_necessarios || 0,
        estoque: item.estoque_disponivel || 0,
        originalPontos: item.pontos_necessarios || 0,
        originalEstoque: item.estoque_disponivel || 0
      }))
    }
  } catch {
    notifyError('Erro ao abrir catálogo.')
  }
}

async function addItem() {
  if (!novoProdutoId.value) return

  try {
    const res = await fetch('/api/catalogos/itens', {
      method: 'POST',
      headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrf()
      },
      body: JSON.stringify({
        catalogo_id: selectedCatalogo.value.id,
        produto_id: novoProdutoId.value,
        pontos_necessarios: 10,
        estoque_disponivel: 50,
        status_id: 1
      })
    })

    const item = await res.json()

    selectedCatalogo.value.itens.push({
      id: item.id,
      produto_id: item.produto_id,
      produto: item.produto_nome,
      pontos: item.pontos_necessarios,
      estoque: item.estoque_disponivel,
      originalPontos: item.pontos_necessarios,
      originalEstoque: item.estoque_disponivel
    })

    buscaProduto.value = ''
    novoProdutoId.value = null
  } catch {
    notifyError('Erro ao adicionar item.')
  }
}

async function removeItem(itemId) {
  try {
    await fetch(`/api/catalogos/itens/${itemId}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': csrf()
      }
    })

    selectedCatalogo.value.itens =
      selectedCatalogo.value.itens.filter(i => i.id !== itemId)
  } catch {
    notifyError('Erro ao remover item.')
  }
}

async function salvarVitrine() {
  try {
    await Promise.all(
      selectedCatalogo.value.itens.map(item =>
        fetch(`/api/catalogos/itens/${item.id}`, {
          method: 'PUT',
          headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf()
          },
          body: JSON.stringify({
            pontos_necessarios: item.pontos,
            estoque_disponivel: item.estoque
          })
        })
      )
    )

    drawerOpen.value = false

    Swal.fire({
      title: 'Sucesso',
      text: 'Vitrine salva.',
      icon: 'success',
      confirmButtonColor: '#0F172A'
    })
  } catch {
    notifyError('Erro ao salvar vitrine.')
  }
}

async function gravarCampanha() {
  try {
    await fetch('/api/catalogos', {
      method: 'POST',
      headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrf()
      },
      body: JSON.stringify({
        ...novaCampanha.value,
        data_publicacao: formatarData(novaCampanha.value.publicacao),
        data_encerramento: formatarData(novaCampanha.value.encerramento)
      })
    })

    modalOpen.value = false

    await fetchCatalogos()

    Swal.fire({
      title: 'Sucesso',
      text: 'Campanha criada.',
      icon: 'success',
      confirmButtonColor: '#0F172A'
    })
  } catch {
    notifyError('Erro ao criar campanha.')
  }
}

async function removerCatalogo(catalogo) {
  const confirm = await Swal.fire({
    title: 'Arquivar campanha?',
    text: `"${catalogo.nome}" será removido.`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#DC2626'
  })

  if (!confirm.isConfirmed) return

  try {
    await fetch(`/api/catalogos/${catalogo.id}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': csrf()
      }
    })

    catalogos.value =
      catalogos.value.filter(c => c.id !== catalogo.id)

    Swal.fire({
      title: 'Sucesso',
      text: 'Campanha removida.',
      icon: 'success',
      confirmButtonColor: '#0F172A'
    })
  } catch {
    notifyError('Erro ao remover campanha.')
  }
}

onMounted(() => {
  fetchCatalogos()
  fetchProdutos()
})
</script>

<style scoped>
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(18px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in {
  animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
}
</style>