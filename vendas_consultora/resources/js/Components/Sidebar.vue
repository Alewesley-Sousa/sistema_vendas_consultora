<template>
  <div>
    <aside
      class="fixed bottom-0 left-0 z-40 flex w-full transition-all duration-300 md:inset-y-0 md:top-4 md:left-4 md:bottom-auto md:h-[calc(100dvh-2rem)] md:flex-col md:rounded-3xl md:border-none md:pb-0"
      :class="[
        collapsed ? 'md:w-22 md:p-4' : 'md:w-64 md:p-6',
        'bg-[#2C3E50] dark:bg-slate-950 text-gray-300 dark:text-gray-400 shadow-[0_-8px_30px_rgb(0,0,0,0.15)] dark:shadow-[0_-8px_30px_rgba(0,0,0,0.5)] border-t border-white/5 md:border-none pb-safe'
      ]"
    >
      <button
        type="button"
        @click="$emit('toggle')"
        class="absolute -right-3 top-8 hidden rounded-full p-2 shadow-xl transition-all duration-300 hover:scale-110 active:scale-95 md:flex z-50 bg-[#FFD700] text-[#2C3E50] dark:bg-amber-500 dark:text-black"
      >
        <svg
          class="h-4 w-4 transition-transform duration-300"
          :class="collapsed ? 'rotate-180' : ''"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/>
        </svg>
      </button>

      <div class="hidden items-center text-white md:flex md:mb-6" :class="collapsed ? 'justify-center' : 'gap-3 px-2'">
        <div class="rounded-xl bg-[#FFD700] dark:bg-amber-500 p-2 shadow-inner transition-transform duration-300 hover:rotate-12">
          <svg class="h-5 w-5 text-[#2C3E50] dark:text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
          </svg>
        </div>
        <span v-if="!collapsed" class="text-xl font-serif font-black tracking-widest text-white uppercase">
          Glow<span class="text-[#FFD700] dark:text-amber-500 italic font-light lowercase text-xs ml-0.5">biz</span>
        </span>
      </div>

      <div
        class="hidden flex-col items-center transition-all duration-300 md:flex md:mb-6"
        :class="[
          collapsed
            ? 'p-0 bg-transparent border-none shadow-none'
            : 'border rounded-2xl p-4 text-center backdrop-blur-sm bg-white/5 border-white/5 dark:bg-white/10 dark:border-white/10'
        ]"
      >
        <div
          class="relative transition-all duration-300"
          :class="collapsed ? 'h-12 w-12 mb-0' : 'h-16 w-16 mb-3'"
        >
          <img
            :src="`https://ui-avatars.com/api/?name=${encodeURIComponent(userName)}&color=2C3E50&background=FFD700&bold=true`"
            class="h-full w-full rounded-full border-2 p-0.5 object-cover shadow-md transition-all duration-300 border-[#FFD700] dark:border-amber-500"
            alt="Perfil"
          >
          <div
            class="absolute bottom-0 right-0 rounded-full border-2 bg-green-500 animate-pulse transition-all duration-300 border-[#2C3E50] dark:border-slate-950"
            :class="collapsed ? 'h-3 w-3' : 'h-4 w-4'"
          ></div>
        </div>
        
        <template v-if="!collapsed">
          <span
            class="text-[9px] font-black uppercase tracking-[0.2em] px-2.5 py-0.5 rounded-full mb-1 transition-all duration-300 bg-[#FFD700]/10 text-[#FFD700] dark:bg-amber-500/20 dark:text-amber-400"
          >
            {{ userCargo || 'Consultora' }}
          </span>
          <h2 class="text-sm font-semibold text-white truncate max-w-full px-1 transition-all duration-300">
            {{ userName }}
          </h2>
        </template>
      </div>

      <nav
        class="hidden md:block md:space-y-1.5 md:flex-1 transition-all"
        :class="collapsed ? 'md:overflow-visible' : 'md:overflow-y-auto'"
      >
        <Link
          href="/consultora/dashboard"
          class="group relative flex flex-col items-center justify-center rounded-xl py-2 px-3 transition-all duration-200 hover:scale-[1.02] active:scale-98 md:flex-row md:px-4 md:py-3.5"
          :class="[
            $page.component.startsWith('Consultora/Dashboard')
              ? 'text-[#FFD700] dark:text-amber-400 md:bg-white/10 dark:md:bg-white/5 font-bold'
              : 'text-gray-400 hover:text-white md:hover:bg-white/5 dark:md:hover:bg-white/10',
            collapsed ? 'md:justify-center' : 'md:gap-4'
          ]"
        >
          <i class="fa-solid fa-house text-xl md:text-lg"></i>
          <span v-if="!collapsed" class="text-sm">Início</span>
          <span v-else class="absolute left-full top-1/2 -translate-y-1/2 ml-4 hidden md:group-hover:inline-block bg-slate-900 text-white text-xs font-medium px-2.5 py-1.5 rounded-lg opacity-0 pointer-events-none group-hover:opacity-100 transition-opacity duration-200 shadow-xl whitespace-nowrap z-50 border border-white/10">Início</span>
        </Link>

        <Link
          href="/catalogo"
          class="group relative flex flex-col items-center justify-center rounded-xl py-2 px-3 md:flex-row md:px-4 md:py-3.5 transition-all duration-200 hover:scale-[1.02] active:scale-98 text-gray-400 hover:text-white md:hover:bg-white/5 dark:md:hover:bg-white/10"
          :class="collapsed ? 'md:justify-center' : 'md:gap-4'"
        >
          <i class="fa-solid fa-book-open text-xl md:text-lg transition-colors group-hover:text-[#FFD700]"></i>
          <span v-if="!collapsed" class="text-sm">Catálogo</span>
          <span v-else class="absolute left-full top-1/2 -translate-y-1/2 ml-4 hidden md:group-hover:inline-block bg-slate-900 text-white text-xs font-medium px-2.5 py-1.5 rounded-lg opacity-0 pointer-events-none group-hover:opacity-100 transition-opacity duration-200 shadow-xl whitespace-nowrap z-50 border border-white/10">Catálogo</span>
        </Link>

        <Link
          href="/rede/arvore"
          class="group relative flex flex-col items-center justify-center rounded-xl py-2 px-3 md:flex-row md:px-4 md:py-3.5 transition-all duration-200 hover:scale-[1.02] active:scale-98 text-gray-400 hover:text-white md:hover:bg-white/5 dark:md:hover:bg-white/10"
          :class="collapsed ? 'md:justify-center' : 'md:gap-4'"
        >
          <i class="fa-solid fa-users text-xl md:text-lg group-hover:text-[#FFD700]"></i>
          <span v-if="!collapsed" class="text-sm">Rede</span>
          <span v-else class="absolute left-full top-1/2 -translate-y-1/2 ml-4 hidden md:group-hover:inline-block bg-slate-900 text-white text-xs font-medium px-2.5 py-1.5 rounded-lg opacity-0 pointer-events-none group-hover:opacity-100 transition-opacity duration-200 shadow-xl whitespace-nowrap z-50 border border-white/10">Rede</span>
        </Link>

        <button
          @click="abrirModalClientes"
          class="group relative flex flex-col items-center justify-center rounded-xl py-2 px-3 md:flex-row md:px-4 md:py-3.5 transition-all duration-200 hover:scale-[1.02] active:scale-98 text-gray-400 hover:text-white md:hover:bg-white/5 dark:md:hover:bg-white/10 w-full"
          :class="collapsed ? 'md:justify-center' : 'md:gap-4'"
        >
          <i class="fa-solid fa-user-group text-xl md:text-lg group-hover:text-[#FFD700]"></i>
          <span v-if="!collapsed" class="text-sm">Clientes</span>
          <span v-else class="absolute left-full top-1/2 -translate-y-1/2 ml-4 hidden md:group-hover:inline-block bg-slate-900 text-white text-xs font-medium px-2.5 py-1.5 rounded-lg opacity-0 pointer-events-none group-hover:opacity-100 transition-opacity duration-200 shadow-xl whitespace-nowrap z-50 border border-white/10">Clientes</span>
        </button>

        <button
          type="button"
          @click="showConfigModal = true"
          class="group relative flex flex-col items-center justify-center rounded-xl py-2 px-3 text-gray-400 hover:text-[#FFD700] dark:hover:text-amber-400 transition-all duration-200 md:flex-row md:w-full md:px-4 md:py-3.5 md:hover:bg-white/5 dark:md:hover:bg-white/10 hover:scale-[1.02] active:scale-95"
          :class="collapsed ? 'md:justify-center' : 'md:gap-4'"
        >
          <i class="fa-solid fa-gear text-xl md:text-lg transition-transform duration-500 group-hover:rotate-90"></i>
          <span v-if="!collapsed" class="text-sm">Configurações</span>
          <span v-else class="absolute left-full top-1/2 -translate-y-1/2 ml-4 hidden md:group-hover:inline-block bg-slate-900 text-white text-xs font-medium px-2.5 py-1.5 rounded-lg opacity-0 pointer-events-none group-hover:opacity-100 transition-opacity duration-200 shadow-xl whitespace-nowrap z-50 border border-white/10">Configurações</span>
        </button>
      </nav>

      <div class="hidden mt-auto border-t border-white/5 pt-4 md:block">
        <button
          type="button"
          @click="logout"
          class="group relative flex w-full items-center rounded-xl px-4 py-3.5 text-red-400/80 hover:text-red-400 hover:bg-red-500/10 active:scale-95 transition-all duration-200 hover:scale-[1.02]"
          :class="collapsed ? 'md:justify-center' : 'md:gap-3.5'"
        >
          <i class="fa-solid fa-power-off text-lg transition-transform group-hover:scale-110"></i>
          <span v-if="!collapsed" class="text-sm font-semibold tracking-wide">Sair do App</span>
          <span v-if="collapsed" class="absolute left-full top-1/2 -translate-y-1/2 ml-4 hidden md:group-hover:inline-block bg-red-950/90 text-red-400 text-xs font-medium px-2.5 py-1.5 rounded-lg opacity-0 pointer-events-none group-hover:opacity-100 transition-opacity duration-200 shadow-xl whitespace-nowrap z-50 border border-red-500/20">Sair do App</span>
        </button>
      </div>

      <div class="flex w-full items-center justify-between px-6 py-2 md:hidden relative">
        <Link 
          href="/consultora/dashboard" 
          class="flex flex-col items-center gap-1 min-w-[60px] py-1 text-gray-400"
          :class="{ 'text-[#FFD700] dark:text-amber-400 font-bold': $page.component.startsWith('Consultora/Dashboard') }"
        >
          <i class="fa-solid fa-house text-xl"></i>
          <span class="text-[11px] font-medium tracking-wide">Início</span>
        </Link>

        <div class="relative -top-5 flex justify-center items-center">
          <div class="absolute bottom-0 flex justify-center items-center w-0 h-0 overflow-visible z-50">
            
            <Link
              href="/catalogo"
              class="radial-btn transition-all duration-300"
              :class="mobileMenuOpen ? 'open opacity-100 scale-100' : 'opacity-0 scale-50'"
              style="--angle: 210deg; --dist: 110px;"
            >
              <i class="fa-solid fa-book-open text-base"></i>
              <span class="absolute -bottom-6 text-[10px] font-bold uppercase whitespace-nowrap text-white">Catálogo</span>
            </Link>

            <Link
              href="/rede/arvore"
              class="radial-btn transition-all duration-300"
              :class="mobileMenuOpen ? 'open opacity-100 scale-100' : 'opacity-0 scale-50'"
              style="--angle: 270deg; --dist: 115px;"
            >
              <i class="fa-solid fa-users text-base"></i>
              <span class="absolute -bottom-6 text-[10px] font-bold uppercase whitespace-nowrap text-white">Rede</span>
            </Link>

            <button
              @click="abrirModalClientes(); mobileMenuOpen = false"
              class="radial-btn transition-all duration-300"
              :class="mobileMenuOpen ? 'open opacity-100 scale-100' : 'opacity-0 scale-50'"
              style="--angle: 330deg; --dist: 110px;"
            >
              <i class="fa-solid fa-user-group text-base"></i>
              <span class="absolute -bottom-6 text-[10px] font-bold uppercase whitespace-nowrap text-white">Clientes</span>
            </button>
          </div>

          <button 
            @click="mobileMenuOpen = !mobileMenuOpen"
            type="button"
            class="w-15 h-15 rounded-full bg-white dark:bg-slate-900 border-4 border-[#2C3E50] dark:border-slate-950 flex items-center justify-center shadow-xl text-[#2C3E50] dark:text-white transition-all duration-300 active:scale-90 z-50"
            :class="mobileMenuOpen ? 'rotate-90 scale-105' : ''"
          >
            <i :class="mobileMenuOpen ? 'fa-solid fa-xmark text-xl' : 'fa-solid fa-bars text-xl'"></i>
          </button>
        </div>

        <button 
          @click="showConfigModal = true" 
          class="flex flex-col items-center gap-1 min-w-[60px] py-1 text-gray-400 hover:text-white"
        >
          <i class="fa-solid fa-gear text-xl"></i>
          <span class="text-[11px] font-medium tracking-wide">Aparência</span>
        </button>
      </div>
    </aside>

    <div 
      v-if="mobileMenuOpen" 
      @click="mobileMenuOpen = false" 
      class="fixed inset-0 bg-black/40 dark:bg-black/70 backdrop-blur-xs z-30 md:hidden transition-opacity duration-300"
    ></div>

    <Teleport to="body">
      <Transition
        enter-active-class="transition duration-300 ease-out"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition duration-200 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
      >
        <div v-if="showConfigModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
          <Transition
            enter-active-class="transition duration-300 ease-out"
            enter-from-class="opacity-0 scale-95 translate-y-4"
            enter-to-class="opacity-100 scale-100 translate-y-0"
            leave-active-class="transition duration-200 ease-in"
            leave-from-class="opacity-100 scale-100 translate-y-0"
            leave-to-class="opacity-0 scale-95 translate-y-4"
          >
            <div class="relative w-full max-w-md overflow-hidden rounded-3xl bg-white dark:bg-slate-900 p-6 text-slate-800 dark:text-slate-100 shadow-2xl border border-slate-100 dark:border-slate-800 transition-all duration-300">
              <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4 mb-6">
                <div class="flex items-center gap-3">
                  <div class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300">
                    <i class="fa-solid fa-sliders text-lg"></i>
                  </div>
                  <h3 class="text-lg font-bold tracking-tight">Preferências do Sistema</h3>
                </div>
                <button @click="showConfigModal = false" class="rounded-full p-1.5 text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                  <i class="fa-solid fa-xmark text-lg"></i>
                </button>
              </div>

              <div class="space-y-4">
                <div class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-100 dark:border-slate-800/60">
                  <div class="flex flex-col gap-0.5">
                    <span class="text-sm font-semibold">Aparência Visual</span>
                    <span class="text-xs text-slate-400 dark:text-slate-500">Alternar entre modo claro e escuro</span>
                  </div>

                  <button
                    type="button"
                    @click="toggleDarkMode"
                    class="group relative flex items-center justify-between rounded-full p-1 w-24 h-10 transition-all duration-300 active:scale-95 shadow-inner"
                    :class="isDark ? 'bg-amber-500/20 border border-amber-500/30' : 'bg-slate-200 border border-slate-300/60'"
                  >
                    <div
                      class="absolute top-1 bottom-1 w-8 rounded-full shadow-md transition-all duration-300 flex items-center justify-center"
                      :class="[isDark ? 'left-14 bg-amber-500 text-black' : 'left-1 bg-white text-slate-600']"
                    >
                      <i :class="isDark ? 'fa-solid fa-sun text-xs' : 'fa-solid fa-moon text-xs'"></i>
                    </div>
                    <span class="text-[9px] font-bold uppercase tracking-wider pl-3 transition-opacity duration-200" :class="isDark ? 'opacity-100 text-amber-400' : 'opacity-0'">Dark</span>
                    <span class="text-[9px] font-bold uppercase tracking-wider pr-3 transition-opacity duration-200" :class="!isDark ? 'opacity-100 text-slate-500' : 'opacity-0'">Light</span>
                  </button>
                </div>

                <button
                  @click="logout"
                  class="w-full mt-2 flex items-center justify-center gap-2 p-3.5 rounded-2xl bg-red-500/10 text-red-500 font-bold text-xs uppercase tracking-wider md:hidden border border-red-500/20"
                >
                  <i class="fa-solid fa-power-off"></i>
                  Sair da Conta
                </button>
              </div>

              <div class="mt-8 flex justify-end">
                <button
                  @click="showConfigModal = false"
                  class="px-5 py-2.5 rounded-xl font-medium text-sm bg-slate-900 text-white dark:bg-white dark:text-slate-900 hover:opacity-90 active:scale-98 transition-all"
                >
                  Concluído
                </button>
              </div>
            </div>
          </Transition>
        </div>
      </Transition>
    </Teleport>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { usePage, Link, router } from '@inertiajs/vue3'

defineProps({
  collapsed: Boolean
})

defineEmits(['toggle'])

const page = usePage()
const isDark = ref(false)
const showConfigModal = ref(false)
const mobileMenuOpen = ref(false)

const userName = computed(() => page.props.auth?.user?.nome || 'Usuário')
const userCargo = computed(() => (page.props.auth?.user?.cargo || '').toLowerCase())

const toggleDarkMode = () => {
  isDark.value = !isDark.value
  updateTheme()
}

const updateTheme = () => {
  if (isDark.value) {
    document.documentElement.classList.add('dark')
    localStorage.theme = 'dark'
  } else {
    document.documentElement.classList.remove('dark')
    localStorage.theme = 'light'
  }
}

onMounted(() => {
  const savedTheme = localStorage.theme
  const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches
 
  if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
    isDark.value = true
  } else {
    isDark.value = false
  }
  updateTheme()
})

const abrirModalClientes = () => {
  window.dispatchEvent(new CustomEvent('open-modal-cliente'))
}

const logout = () => {
  router.post('/logout')
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght=900&display=swap');

.font-serif {
  font-family: 'Playfair Display', serif;
}

nav::-webkit-scrollbar {
  width: 4px;
}
nav::-webkit-scrollbar-track {
  background: transparent;
}
nav::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.1);
  border-radius: 10px;
}

.radial-btn {
  position: absolute;
  width: 52px;
  height: 52px;
  border-radius: 99px;
  background-color: #34495e;
  color: #ffffff;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  box-shadow: 0 6px 16px rgba(0, 0, 0, 0.35);
  top: -26px;
  left: -26px;
  transform: translate(0, 0) scale(0.1);
  opacity: 0;
  pointer-events: none;
  transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.2), opacity 0.3s ease;
}

.dark .radial-btn {
  background-color: #1e293b;
  border: 1px solid rgba(255, 255, 255, 0.05);
  color: #f1f5f9;
}

.radial-btn:active {
  transform: scale(0.95);
}

.radial-btn.open {
  pointer-events: auto;
  opacity: 1;
  transform: translate(
    calc(cos(var(--angle)) * var(--dist)),
    calc(sin(var(--angle)) * var(--dist))
  ) scale(1);
}
</style>