<template>
  <div class="relative h-dvh overflow-hidden bg-slate-50 text-[#2C3E50] dark:bg-slate-950 dark:text-slate-100 font-sans antialiased transition-colors duration-300">
    
    <div class="flex h-dvh overflow-hidden md:p-4">
      <!-- Importando e utilizando a nova SidebarAdmin -->
      <SidebarAdmin :collapsed="sidebarCollapsed" @toggle="sidebarCollapsed = !sidebarCollapsed" />

      <!-- Ajuste dinâmico de margem dependendo do estado da sidebar -->
      <main 
        class="flex-1 h-dvh overflow-y-auto p-4 pb-28 transition-all duration-300 md:p-8 md:pb-8"
        :class="sidebarCollapsed ? 'md:ml-24' : 'md:ml-[18rem]'"
      >
        <slot />
      </main>
    </div>

  </div>
</template>

<script setup>
import { ref } from 'vue'
import SidebarAdmin from '@/Components/SidebarAdmin.vue'

const sidebarCollapsed = ref(false)
</script>