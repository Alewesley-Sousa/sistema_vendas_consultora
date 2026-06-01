<template>
  <section
    class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/60 dark:border-slate-800/80 overflow-hidden shadow-sm transition-all duration-200"
  >

    <!-- MOBILE CARDS -->
    <div class="md:hidden divide-y divide-slate-200/60 dark:divide-slate-800">

      <template
        v-for="produto in paginatedProdutos"
        :key="produto.id"
      >
        <article
          class="group p-4 transition-all duration-200
          hover:bg-slate-50/70
          dark:hover:bg-slate-800/30
          hover:shadow-md"
        >
          <div class="flex gap-4">

            <!-- imagem -->
            <div
              class="w-20 h-20 rounded-2xl overflow-hidden shrink-0
              bg-slate-100 dark:bg-slate-800
              border border-slate-200/60 dark:border-slate-700/60
              shadow-sm"
            >
              <img
                v-if="produto.imagem_url"
                :src="resolveImageUrl(produto.imagem_url)"
                :alt="produto.nome"
                class="w-full h-full object-cover"
              >

              <div
                v-else
                class="w-full h-full flex items-center justify-center
                text-[10px] font-mono tracking-widest
                text-slate-400"
              >
                GLOW
              </div>
            </div>

            <!-- infos -->
            <div class="flex-1 min-w-0">

              <div class="pr-2">
                <h3
                  class="font-semibold text-[15px]
                  text-slate-900 dark:text-slate-100
                  leading-snug"
                >
                  {{ produto.nome }}
                </h3>

                <p
                  class="mt-1 text-xs
                  font-mono
                  text-slate-400 dark:text-slate-500"
                >
                  SKU: {{ getSku(produto) }}
                </p>
              </div>

              <div
                class="grid grid-cols-2 gap-3
                mt-4"
              >
                <div>
                  <p
                    class="text-[11px]
                    uppercase tracking-wide
                    text-slate-400"
                  >
                    Categoria
                  </p>

                  <p
                    class="mt-1 text-sm
                    text-slate-700 dark:text-slate-300"
                  >
                    {{ getCategoriaNome(produto) }}
                  </p>
                </div>

                <div>
                  <p
                    class="text-[11px]
                    uppercase tracking-wide
                    text-slate-400"
                  >
                    Preço
                  </p>

                  <p
                    class="mt-1 text-sm
                    font-mono tabular-nums
                    font-semibold
                    text-slate-900 dark:text-white"
                  >
                    {{ formatMoney(produto.preco) }}
                  </p>
                </div>
              </div>

              <!-- status -->
              <div class="mt-4">
                <span
                  class="inline-flex items-center gap-2
                  px-2.5 py-1 rounded-full
                  bg-emerald-50 dark:bg-emerald-950/30
                  text-emerald-700 dark:text-emerald-400
                  text-xs font-medium"
                >
                  <span
                    class="w-1.5 h-1.5 rounded-full
                    bg-emerald-500"
                  ></span>
                  Ativo
                </span>
              </div>

            </div>
          </div>

          <!-- actions -->
          <div
            class="flex justify-end gap-2
            mt-5 pt-4
            border-t border-slate-200/60
            dark:border-slate-800"
          >
            <button
              @click="$emit('edit', produto)"
              class="flex items-center gap-2
              px-3 py-2 rounded-xl
              text-slate-500 dark:text-slate-400
              hover:bg-slate-100
              dark:hover:bg-slate-800
              hover:text-slate-900
              dark:hover:text-white
              transition-all duration-200"
            >
              <span class="material-symbols-outlined text-[18px]">
                edit
              </span>
              <span class="text-sm">Editar</span>
            </button>

            <button
              @click="$emit('delete', produto)"
              class="flex items-center gap-2
              px-3 py-2 rounded-xl
              text-slate-500 dark:text-slate-400
              hover:bg-rose-50
              dark:hover:bg-rose-950/20
              hover:text-rose-600
              dark:hover:text-rose-400
              transition-all duration-200"
            >
              <span class="material-symbols-outlined text-[18px]">
                delete
              </span>
              <span class="text-sm">Excluir</span>
            </button>
          </div>
        </article>
      </template>

      <!-- empty -->
      <div
        v-if="filteredCount === 0"
        class="py-14 text-center text-slate-400"
      >
        <span class="material-symbols-outlined text-4xl mb-2 block">
          inventory
        </span>
        Nenhum cosmético encontrado.
      </div>
    </div>

    <!-- DESKTOP TABLE -->
    <div class="hidden md:block overflow-x-auto">
      <table class="w-full text-left">
        <thead
          class="bg-slate-50 dark:bg-slate-950/60
          border-b border-slate-200/60 dark:border-slate-800"
        >
          <tr>
            <th class="px-6 py-4 w-12 text-center">
              <input
                type="checkbox"
                class="rounded border-slate-300"
              >
            </th>

            <th
              class="px-6 py-4 text-xs
              uppercase tracking-wider
              text-slate-400 font-mono"
            >
              Produto
            </th>

            <th
              class="px-6 py-4 text-xs
              uppercase tracking-wider
              text-slate-400 font-mono"
            >
              Categoria
            </th>

            <th
              class="px-6 py-4 text-xs text-right
              uppercase tracking-wider
              text-slate-400 font-mono"
            >
              Preço Base
            </th>

            <th
              class="px-6 py-4 text-xs text-center
              uppercase tracking-wider
              text-slate-400 font-mono"
            >
              Status
            </th>

            <th
              class="px-6 py-4 text-xs text-right
              uppercase tracking-wider
              text-slate-400 font-mono"
            >
              Ações
            </th>
          </tr>
        </thead>

        <tbody
          class="divide-y divide-slate-200/60
          dark:divide-slate-800/60"
        >
          <tr
            v-for="produto in paginatedProdutos"
            :key="produto.id"
            class="
            odd:bg-white
            even:bg-slate-50/35
            dark:odd:bg-slate-900
            dark:even:bg-slate-900/70
            hover:bg-slate-50
            dark:hover:bg-slate-800/30
            hover:shadow-sm
            hover:scale-[1.002]
            transition-all duration-200"
          >
            <td class="px-6 py-5 text-center">
              <input
                type="checkbox"
                class="rounded border-slate-300"
              >
            </td>

            <td class="px-6 py-5">
              <div class="flex items-center gap-4">

                <div
                  class="w-12 h-12 rounded-xl overflow-hidden
                  bg-slate-100 dark:bg-slate-800
                  border border-slate-200/60
                  dark:border-slate-700/60"
                >
                  <img
                    v-if="produto.imagem_url"
                    :src="resolveImageUrl(produto.imagem_url)"
                    :alt="produto.nome"
                    class="w-full h-full object-cover"
                  >

                  <div
                    v-else
                    class="w-full h-full flex items-center justify-center
                    text-[10px] font-mono tracking-widest
                    text-slate-400"
                  >
                    GLOW
                  </div>
                </div>

                <div>
                  <p
                    class="font-semibold
                    text-slate-900 dark:text-slate-100"
                  >
                    {{ produto.nome }}
                  </p>

                  <p
                    class="mt-1 text-xs
                    font-mono
                    text-slate-400"
                  >
                    SKU: {{ getSku(produto) }}
                  </p>
                </div>
              </div>
            </td>

            <td class="px-6 py-5">
              <span
                class="text-sm
                text-slate-600 dark:text-slate-300"
              >
                {{ getCategoriaNome(produto) }}
              </span>
            </td>

            <td
              class="px-6 py-5 text-right
              font-mono tabular-nums
              font-semibold
              text-slate-900 dark:text-white"
            >
              {{ formatMoney(produto.preco) }}
            </td>

            <td class="px-6 py-5 text-center">
              <span
                class="inline-flex items-center gap-2
                px-2.5 py-1 rounded-full
                bg-emerald-50 dark:bg-emerald-950/30
                text-emerald-700 dark:text-emerald-400
                text-xs font-medium"
              >
                <span
                  class="w-1.5 h-1.5 rounded-full
                  bg-emerald-500"
                ></span>
                Ativo
              </span>
            </td>

            <td class="px-6 py-5 text-right">
              <div class="flex justify-end gap-2">
                <button
                  @click="$emit('edit', produto)"
                  class="p-2 rounded-xl
                  text-slate-500 dark:text-slate-400
                  hover:bg-slate-100
                  dark:hover:bg-slate-800
                  hover:text-slate-900
                  dark:hover:text-white
                  transition-all duration-200"
                >
                  <span class="material-symbols-outlined">
                    edit
                  </span>
                </button>

                <button
                  @click="$emit('delete', produto)"
                  class="p-2 rounded-xl
                  text-slate-500 dark:text-slate-400
                  hover:bg-rose-50
                  dark:hover:bg-rose-950/20
                  hover:text-rose-600
                  dark:hover:text-rose-400
                  transition-all duration-200"
                >
                  <span class="material-symbols-outlined">
                    delete
                  </span>
                </button>
              </div>
            </td>
          </tr>

          <tr v-if="filteredCount === 0">
            <td
              colspan="6"
              class="py-16 text-center text-slate-400"
            >
              <span
                class="material-symbols-outlined
                text-3xl block mb-2"
              >
                inventory
              </span>
              Nenhum cosmético encontrado.
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- FOOTER -->
    <footer
      v-if="filteredCount > 0"
      class="px-5 py-4
      bg-slate-50 dark:bg-slate-950/40
      border-t border-slate-200/60
      dark:border-slate-800
      flex flex-col sm:flex-row
      justify-between items-center
      gap-4
      text-xs font-mono
      text-slate-500"
    >
      <div>
        Exibindo
        <span class="font-bold text-slate-900 dark:text-white">
          {{ startRecord }}
        </span>
        —
        <span class="font-bold text-slate-900 dark:text-white">
          {{ endRecord }}
        </span>
        de
        <span class="font-bold text-slate-900 dark:text-white">
          {{ filteredCount }}
        </span>
      </div>

      <div
        class="flex items-center gap-1"
        v-if="totalPages > 1"
      >
        <button
          @click="$emit('update:currentPage', currentPage - 1)"
          :disabled="currentPage === 1"
          class="w-9 h-9 rounded-xl
          border border-slate-200/60
          hover:bg-slate-100
          transition-all duration-200"
        >
          <span class="material-symbols-outlined text-sm">
            chevron_left
          </span>
        </button>

        <button
          v-for="page in totalPages"
          :key="page"
          @click="$emit('update:currentPage', page)"
          class="w-9 h-9 rounded-xl
          font-mono transition-all duration-200"
          :class="currentPage === page
            ? 'bg-slate-900 text-white dark:bg-slate-100 dark:text-slate-900'
            : 'hover:bg-slate-200/60 dark:hover:bg-slate-800'"
        >
          {{ page }}
        </button>

        <button
          @click="$emit('update:currentPage', currentPage + 1)"
          :disabled="currentPage === totalPages"
          class="w-9 h-9 rounded-xl
          border border-slate-200/60
          hover:bg-slate-100
          transition-all duration-200"
        >
          <span class="material-symbols-outlined text-sm">
            chevron_right
          </span>
        </button>
      </div>
    </footer>
  </section>
</template>

<script setup>
defineProps({
  paginatedProdutos: Array,
  filteredCount: Number,
  currentPage: Number,
  totalPages: Number,
  startRecord: Number,
  endRecord: Number,
  resolveImageUrl: Function,
  getSku: Function,
  getCategoriaNome: Function,
  formatMoney: Function
});

defineEmits([
  'update:currentPage',
  'edit',
  'delete'
]);
</script>