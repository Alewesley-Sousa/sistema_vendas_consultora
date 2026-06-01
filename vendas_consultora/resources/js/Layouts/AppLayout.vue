<template>
  <div class="relative h-dvh overflow-hidden bg-[#FFF5F7] text-[#2C3E50] dark:bg-slate-950 dark:text-slate-100 font-sans antialiased transition-colors duration-300">
    <div id="app-background" class="absolute inset-0 -z-10 dark:opacity-5"></div>

    <div class="flex h-dvh overflow-hidden md:p-4">
      <Sidebar :collapsed="sidebarCollapsed" @toggle="sidebarCollapsed = !sidebarCollapsed" />

      <main 
        class="flex-1 h-dvh overflow-y-auto p-6 pb-28 transition-all duration-300 md:p-8 md:pb-8"
        :class="sidebarCollapsed ? 'md:ml-24' : 'md:ml-[18rem]'"
      >
        <slot />
      </main>
    </div>

    <ModalCliente />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import Sidebar from '@/Components/Sidebar.vue'
import ModalCliente from '@/Pages/Consultora/Partials/ModalCliente.vue'

const sidebarCollapsed = ref(false)
</script>