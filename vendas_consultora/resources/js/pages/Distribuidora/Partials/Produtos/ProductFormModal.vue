<template>
  <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto backdrop-blur-sm bg-slate-900/40" role="dialog">
    <div @click="$emit('close')" class="absolute inset-0"></div>
    <div class="relative bg-white dark:bg-slate-900 rounded-2xl text-left shadow-2xl transform transition-all w-full max-w-2xl border border-slate-100 dark:border-slate-800 overflow-hidden animate-fade-in-scale">
      <div class="p-6 sm:p-8 transition-colors">
        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4 mb-6">
          <div>
            <h3 class="text-base font-bold text-slate-900 dark:text-white uppercase tracking-wide font-['JetBrains_Mono']">
              {{ isEdit ? 'Editar Informações' : 'Novo Cosmético' }}
            </h3>
            <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">
              {{ isEdit ? 'Modifique os dados do produto selecionado.' : 'Cadastre o produto definindo nome, categoria, preço e imagem.' }}
            </p>
          </div>
          <button @click="$emit('close')" class="text-slate-400 dark:text-slate-500 hover:text-slate-900 dark:hover:text-white p-1 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
            <span class="material-symbols-outlined text-lg">close</span>
          </button>
        </div>

        <form @submit.prevent="$emit('save', isEdit ? 'edit' : 'create')" class="space-y-5">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
              <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2 font-['JetBrains_Mono']">Nome do Produto</label>
              <input type="text" required v-model="modelData.nome" class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-lg text-sm text-slate-900 dark:text-slate-100 focus:border-slate-400 dark:focus:border-slate-600 focus:ring-0 transition-all outline-none">
            </div>

            <div>
              <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2 font-['JetBrains_Mono']">Categoria</label>
              <select v-model="modelData.categoria_id" required class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-lg text-sm text-slate-900 dark:text-slate-100 focus:border-slate-400 dark:focus:border-slate-600 focus:ring-0 transition-all outline-none">
                <option value="">Selecione uma categoria</option>
                <option v-for="cat in categorias" :key="cat.id" :value="cat.id">{{ cat.nome }}</option>
              </select>
            </div>

            <div>
              <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2 font-['JetBrains_Mono']">Preço de Venda Base</label>
              <input type="text" required v-model="modelData.preco" class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-lg text-sm text-slate-900 dark:text-slate-100 focus:border-slate-400 dark:focus:border-slate-600 focus:ring-0 transition-all outline-none">
            </div>

            <div class="sm:col-span-2">
              <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2 font-['JetBrains_Mono']">Descrição</label>
              <textarea v-model="modelData.descricao" rows="4" class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-lg text-sm text-slate-900 dark:text-slate-100 focus:border-slate-400 dark:focus:border-slate-600 focus:ring-0 transition-all outline-none resize-none"></textarea>
            </div>

            <div class="sm:col-span-2">
              <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2 font-['JetBrains_Mono']">Imagem do Produto</label>
              <input type="file" accept="image/*" :required="!isEdit" ref="fileInput" @change="$emit('image-change', $event)" class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-lg text-sm text-slate-500 dark:text-slate-400 file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-bold file:bg-slate-900 dark:file:bg-slate-100 file:text-white dark:file:text-slate-900 hover:file:opacity-90 transition-all cursor-pointer">

              <div class="mt-3 flex items-start gap-4">
                <div class="w-32 h-32 rounded-xl border border-dashed border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 overflow-hidden flex items-center justify-center shrink-0 shadow-sm">
                  <img v-if="modelData.imagePreview || modelData.currentImageUrl" :src="modelData.imagePreview || modelData.currentImageUrl" class="w-full h-full object-cover" alt="Preview">
                  <div v-else class="text-center px-3">
                    <span class="material-symbols-outlined text-slate-300 dark:text-slate-600 text-2xl">image</span>
                    <p class="mt-1 text-[10px] text-slate-400 dark:text-slate-500 leading-4">Corte 1:1</p>
                  </div>
                </div>
                <div class="text-xs text-slate-400 dark:text-slate-500 leading-5">
                  Selecione uma imagem e ajuste o recorte quadrado antes de enviar.
                </div>
              </div>
            </div>
          </div>

          <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800 mt-2">
            <button type="button" @click="$emit('close')" class="px-4 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 text-xs font-bold uppercase font-['JetBrains_Mono'] rounded-lg transition-all">Cancelar</button>
            <button type="submit" class="px-5 py-2 bg-slate-900 hover:bg-slate-800 dark:bg-slate-100 dark:hover:bg-white text-white dark:text-slate-900 text-xs font-bold uppercase tracking-wide font-['JetBrains_Mono'] rounded-lg transition-all shadow-sm">
              Salvar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
defineProps({ isOpen: Boolean, isEdit: Boolean, modelData: Object, categorias: Array });
defineEmits(['close', 'save', 'image-change']);
const fileInput = ref(null);
defineExpose({ fileInput });
</script>