<template>

  <!-- MOBILE: STATS BAR -->
  <section class="md:hidden -mx-1">

    <div
      class="flex gap-2 overflow-x-auto
      px-1 pb-1
      snap-x snap-mandatory
      scrollbar-none"
    >

      <!-- TOTAL -->
      <article
        class="group relative
        min-w-[120px]
        snap-start
        rounded-2xl
        border border-slate-200/60
        dark:border-slate-800/80
        bg-white dark:bg-slate-900
        px-3 py-3
        shadow-sm
        hover:shadow-md
        hover:border-slate-300
        transition-all duration-200"
      >
        <div
          class="absolute inset-x-0 top-0 h-px
          bg-gradient-to-r
          from-transparent
          via-sky-400/40
          to-transparent"
        ></div>

        <p
          class="text-[10px]
          uppercase tracking-wider
          font-mono
          text-slate-400"
        >
          Produtos
        </p>

        <p
          class="mt-1
          text-lg
          font-bold
          tracking-tight
          text-slate-900 dark:text-white"
        >
          {{ totalProdutos }}
        </p>
      </article>

      <!-- ATIVOS -->
      <article
        class="group relative
        min-w-[120px]
        snap-start
        rounded-2xl
        border border-slate-200/60
        dark:border-slate-800/80
        bg-white dark:bg-slate-900
        px-3 py-3
        shadow-sm
        hover:shadow-md
        hover:border-slate-300
        transition-all duration-200"
      >
        <div
          class="absolute inset-x-0 top-0 h-px
          bg-gradient-to-r
          from-transparent
          via-emerald-400/40
          to-transparent"
        ></div>

        <p
          class="text-[10px]
          uppercase tracking-wider
          font-mono
          text-slate-400"
        >
          Ativos
        </p>

        <p
          class="mt-1
          text-lg
          font-bold
          tracking-tight
          text-slate-900 dark:text-white"
        >
          {{ totalAtivos }}
        </p>
      </article>

      <!-- PROMO -->
      <article
        class="group relative
        min-w-[120px]
        snap-start
        rounded-2xl
        border border-slate-200/60
        dark:border-slate-800/80
        bg-white dark:bg-slate-900
        px-3 py-3
        shadow-sm
        hover:shadow-md
        hover:border-slate-300
        transition-all duration-200"
      >
        <div
          class="absolute inset-x-0 top-0 h-px
          bg-gradient-to-r
          from-transparent
          via-amber-400/40
          to-transparent"
        ></div>

        <p
          class="text-[10px]
          uppercase tracking-wider
          font-mono
          text-slate-400"
        >
          Promoção
        </p>

        <p
          class="mt-1
          text-lg
          font-bold
          tracking-tight
          text-amber-600 dark:text-amber-400"
        >
          1
        </p>
      </article>

      <!-- ESTOQUE -->
      <article
        class="group relative
        min-w-[120px]
        snap-start
        rounded-2xl
        border border-slate-200/60
        dark:border-slate-800/80
        bg-white dark:bg-slate-900
        px-3 py-3
        shadow-sm
        hover:shadow-md
        hover:border-slate-300
        transition-all duration-200"
      >
        <div
          class="absolute inset-x-0 top-0 h-px
          bg-gradient-to-r
          from-transparent
          via-rose-400/35
          to-transparent"
        ></div>

        <p
          class="text-[10px]
          uppercase tracking-wider
          font-mono
          text-slate-400"
        >
          Estoque
        </p>

        <p
          class="mt-1
          text-lg
          font-bold
          tracking-tight
          text-slate-900 dark:text-white"
        >
          0
        </p>
      </article>

    </div>
  </section>


  <!-- DESKTOP / TABLET -->
  <section
    class="hidden md:grid
    md:grid-cols-2
    xl:grid-cols-4
    gap-3 lg:gap-4"
  >

    <!-- TOTAL -->
    <article
      class="group relative overflow-hidden
      rounded-2xl
      border border-slate-200/60
      dark:border-slate-800/80
      bg-white dark:bg-slate-900
      p-5 lg:p-6
      shadow-sm
      hover:shadow-md
      hover:border-slate-300
      hover:-translate-y-[1px]
      transition-all duration-200"
    >
      <div
        class="absolute inset-x-0 top-0 h-px
        bg-gradient-to-r
        from-transparent
        via-sky-400/40
        to-transparent"
      ></div>

      <div class="space-y-3">

        <div class="flex items-center gap-2">

          <div
            class="w-8 h-8 rounded-xl
            flex items-center justify-center
            bg-slate-100 dark:bg-slate-800"
          >
            <span
              class="material-symbols-outlined
              text-[16px]
              text-slate-500"
            >
              inventory_2
            </span>
          </div>

          <p
            class="text-[11px]
            uppercase tracking-wider
            font-mono
            text-slate-500"
          >
            Total Produtos
          </p>
        </div>

        <p
          class="text-2xl
          font-bold
          tracking-tight
          text-slate-900 dark:text-white"
        >
          {{ totalProdutos }}
        </p>
      </div>
    </article>

    <!-- ATIVOS -->
    <article
      class="group relative overflow-hidden
      rounded-2xl
      border border-slate-200/60
      dark:border-slate-800/80
      bg-white dark:bg-slate-900
      p-5 lg:p-6
      shadow-sm
      hover:shadow-md
      hover:border-slate-300
      hover:-translate-y-[1px]
      transition-all duration-200"
    >
      <div
        class="absolute inset-x-0 top-0 h-px
        bg-gradient-to-r
        from-transparent
        via-emerald-400/40
        to-transparent"
      ></div>

      <div class="space-y-3">

        <div class="flex items-center gap-2">
          <div
            class="w-8 h-8 rounded-xl
            flex items-center justify-center
            bg-emerald-50 dark:bg-emerald-950/30"
          >
            <span
              class="material-symbols-outlined
              text-[16px]
              text-emerald-500"
            >
              check_circle
            </span>
          </div>

          <p
            class="text-[11px]
            uppercase tracking-wider
            font-mono
            text-slate-500"
          >
            Produtos Ativos
          </p>
        </div>

        <p
          class="text-2xl font-bold
          tracking-tight
          text-slate-900 dark:text-white"
        >
          {{ totalAtivos }}
        </p>
      </div>
    </article>

    <!-- PROMO -->
    <article
      class="group relative overflow-hidden
      rounded-2xl
      border border-slate-200/60
      dark:border-slate-800/80
      bg-white dark:bg-slate-900
      p-5 lg:p-6
      shadow-sm
      hover:shadow-md
      hover:border-slate-300
      hover:-translate-y-[1px]
      transition-all duration-200"
    >
      <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-amber-400/40 to-transparent"></div>

      <p class="text-[11px] font-mono uppercase tracking-wider text-slate-500">
        Promoção
      </p>

      <div class="mt-3 flex items-baseline gap-2">
        <p class="text-2xl font-bold text-amber-600 dark:text-amber-400">
          1
        </p>
        <span class="text-xs text-slate-400">
          ativo
        </span>
      </div>
    </article>

    <!-- ESTOQUE -->
    <article
      class="group relative overflow-hidden
      rounded-2xl
      border border-slate-200/60
      dark:border-slate-800/80
      bg-white dark:bg-slate-900
      p-5 lg:p-6
      shadow-sm
      hover:shadow-md
      hover:border-slate-300
      hover:-translate-y-[1px]
      transition-all duration-200"
    >
      <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-rose-400/35 to-transparent"></div>

      <p class="text-[11px] font-mono uppercase tracking-wider text-slate-500">
        Estoque
      </p>

      <div class="mt-3 flex items-baseline gap-2">
        <p class="text-2xl font-bold text-slate-900 dark:text-white">
          0
        </p>
        <span class="text-xs text-slate-400">
          críticos
        </span>
      </div>
    </article>

  </section>

</template>

<script setup>
defineProps({
  totalProdutos: Number,
  totalAtivos: Number
});
</script>