<template>
  <AppAdmin>
    <div class="space-y-6 font-['Hanken_Grotesk',sans-serif] text-slate-800 dark:text-slate-100 transition-colors duration-300 p-1 md:p-4">
      <header class="border-b border-slate-100 dark:border-slate-800 pb-5">
        <div>
          <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Gerenciamento de Catálogo</h1>
          <p class="text-sm text-slate-500 dark:text-slate-400">Controle seus produtos, preços, categorias e imagens em um único lugar.</p>
        </div>
      </header>

      <CatalogKpis :totalProdutos="totalProdutos" :totalAtivos="totalAtivos" />

      <CatalogFilters 
        v-model:search="search" 
        :categoryFilter="categoryFilter" 
        :dropdownOpen="dropdownOpen" 
        :categorias="categorias"
        @toggle-dropdown="dropdownOpen = !dropdownOpen"
        @select-category="setCategoryFilter"
        @clear="clearFilters"
        @open-create="abrirCreateModal"
      />

      <CatalogTable 
        :paginatedProdutos="paginatedProdutos"
        :filteredCount="filteredProdutos.length"
        v-model:currentPage="currentPage"
        :totalPages="totalPages"
        :startRecord="startRecord"
        :endRecord="endRecord"
        :resolveImageUrl="resolveImageUrl"
        :getSku="getSku"
        :getCategoriaNome="getCategoriaNome"
        :formatMoney="formatMoney"
        @edit="editarProduto"
        @delete="(p) => excluirProduto(p.id, p.nome)"
      />

      <ProductFormModal 
        :isOpen="openCreateModal || openEditModal" 
        :isEdit="openEditModal" 
        :modelData="openEditModal ? editData : createData" 
        :categorias="categorias"
        ref="formModalRef"
        @close="resetForm"
        @save="salvarProduto"
        @image-change="(e) => handleImageChange(e, openEditModal ? 'edit' : 'create')"
      />

      <CropModal 
        :openCropModal="openCropModal" 
        :cropSource="cropSource" 
        ref="cropModalRef"
        @cancel="cancelCrop"
        @confirmed="handleCropConfirmed"
      />
    </div>
  </AppAdmin>
</template>

<script setup>
import { ref, computed, onMounted, nextTick } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';

import AppAdmin from '../../Layouts/AdminLayout.vue';
import CatalogKpis from './Partials/Produtos/CatalogKpis.vue';
import CatalogFilters from './Partials/Produtos/CatalogFilters.vue';
import CatalogTable from './Partials/Produtos/CatalogTable.vue';
import ProductFormModal from './Partials/Produtos/ProductFormModal.vue';
import CropModal from './Partials/Produtos/CropModal.vue';

const search = ref('');
const categoryFilter = ref('all');
const dropdownOpen = ref(false);
const currentPage = ref(1);
const perPage = ref(5);
const openCreateModal = ref(false);
const openEditModal = ref(false);
const openCropModal = ref(false);
const cropSource = ref('');
const cropTarget = ref(null);

const formModalRef = ref(null);
const cropModalRef = ref(null); 
let tempObjectUrl = null;

const createData = ref({ nome: '', categoria_id: '', preco: '', descricao: '', file: null, imagePreview: '' });
const editData = ref({ id: null, nome: '', categoria_id: '', preco: '', descricao: '', file: null, imagePreview: '', currentImageUrl: '' });
const categorias = ref([]);
const produtos = ref([]);

onMounted(() => {
  window.addEventListener('click', (e) => { if (!e.target.closest('.class-dropdown-container')) dropdownOpen.value = false; });
  carregarCategorias(); carregarProdutos();
});

const carregarCategorias = async () => {
  try { const r = await axios.get('/api/categoria'); categorias.value = r.data.data ?? r.data ?? []; } catch (e) { console.error(e); }
};
const carregarProdutos = async () => {
  try { const r = await axios.get('/api/produto'); produtos.value = r.data.data ?? r.data ?? []; } catch (e) { console.error(e); }
};

const totalProdutos = computed(() => produtos.value.length);
const totalAtivos = computed(() => produtos.value.filter(p => p.status === 'ativo' || p.status === undefined).length);
const filteredProdutos = computed(() => {
  const t = search.value.trim().toLowerCase();
  return produtos.value.filter(p => (t === '' || (p.nome??'').toLowerCase().includes(t) || (p.descricao??'').toLowerCase().includes(t) || getSku(p).toLowerCase().includes(t)) && (categoryFilter.value === 'all' || getCategoriaNome(p).toLowerCase() === categoryFilter.value.toLowerCase()));
});
const paginatedProdutos = computed(() => { const s = (currentPage.value - 1) * perPage.value; return filteredProdutos.value.slice(s, s + perPage.value); });
const totalPages = computed(() => Math.ceil(filteredProdutos.value.length / perPage.value) || 1);
const startRecord = computed(() => filteredProdutos.value.length === 0 ? 0 : (currentPage.value - 1) * perPage.value + 1);
const endRecord = computed(() => { const e = currentPage.value * perPage.value; return e > filteredProdutos.value.length ? filteredProdutos.value.length : e; });

const setCategoryFilter = (name) => { categoryFilter.value = name; dropdownOpen.value = false; currentPage.value = 1; };
const clearFilters = () => { search.value = ''; categoryFilter.value = 'all'; currentPage.value = 1; };
const getCategoriaNome = (p) => p?.categoria?.nome || categorias.value.find(c => String(c.id) === String(p?.categoria_id))?.nome || 'Sem categoria';
const getSku = (p) => p?.sku ?? `GLW-${String(p?.id ?? 0).padStart(3, '0')}`;
const resolveImageUrl = (path) => path ? (path.startsWith('http') || path.startsWith('/') ? path : `/storage/${path}`) : '';
const formatMoney = (v) => new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(v ?? 0);

const abrirCreateModal = () => { resetCreateForm(); openCreateModal.value = true; };
const editarProduto = (p) => {
  resetEditForm();
  editData.value = { id: p.id, nome: p.nome, categoria_id: p.categoria_id, preco: p.preco, descricao: p.descricao, file: null, imagePreview: '', currentImageUrl: resolveImageUrl(p.imagem_url) };
  openEditModal.value = true;
};
const resetCreateForm = () => { createData.value = { nome: '', categoria_id: '', preco: '', descricao: '', file: null, imagePreview: '' }; if(formModalRef.value?.fileInput) formModalRef.value.fileInput.value = ''; };
const resetEditForm = () => { editData.value = { id: null, nome: '', categoria_id: '', preco: '', descricao: '', file: null, imagePreview: '', currentImageUrl: '' }; if(formModalRef.value?.fileInput) formModalRef.value.fileInput.value = ''; };
const resetForm = () => { closeCropModal(true); resetCreateForm(); resetEditForm(); openCreateModal.value = false; openEditModal.value = false; };

const handleImageChange = (event, target) => {
  const file = event.target.files?.[0]; 
  if (!file) return;
  
  cropTarget.value = target;
  if (tempObjectUrl) URL.revokeObjectURL(tempObjectUrl);
  
  cropSource.value = URL.createObjectURL(file); 
  tempObjectUrl = cropSource.value;
  openCropModal.value = true;

  nextTick(() => {
    setTimeout(() => {
      if (cropModalRef.value?.setupCropper) cropModalRef.value.setupCropper();
    }, 150);
  });
};

const handleCropConfirmed = ({ file, previewUrl }) => {
  if (cropTarget.value === 'create') { createData.value.file = file; createData.value.imagePreview = previewUrl; } 
  else { editData.value.file = file; editData.value.imagePreview = previewUrl; }
  closeCropModal(false);
};

const closeCropModal = (clearInput = true) => {
  if (cropModalRef.value?.destroyCropper) cropModalRef.value.destroyCropper();
  if (tempObjectUrl) { URL.revokeObjectURL(tempObjectUrl); tempObjectUrl = null; }
  openCropModal.value = false;
  if (clearInput && formModalRef.value?.fileInput) formModalRef.value.fileInput.value = '';
};

const cancelCrop = () => closeCropModal(true);

const salvarProduto = async (modo) => {
  const isEdit = modo === 'edit'; 
  const source = isEdit ? editData.value : createData.value;
  
  // Extrai o token do meta tag definido no seu layout (app.blade.php)
  const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  try {
    const fd = new FormData(); 
    fd.append('nome', source.nome); 
    fd.append('categoria_id', source.categoria_id); 
    fd.append('preco', source.preco); 
    fd.append('descricao', source.descricao); 
    fd.append('status', 'ativo');
    
    // Adiciona o token diretamente no FormData (solução garantida para 419)
    fd.append('_token', token); 
    
    if (source.file instanceof File) fd.append('imagem', source.file);

    if (isEdit) { 
      fd.append('_method', 'PUT'); 
      await axios.post(`/api/produto/${source.id}`, fd); 
    } else { 
      await axios.post('/api/produto', fd); 
    }
    
    Swal.fire({ 
      icon: 'success', 
      title: 'Sucesso', 
      text: 'Produto salvo com êxito!',
      confirmButtonColor: '#0F172A' 
    }); 
    
    resetForm(); 
    carregarProdutos();
  } catch (e) { 
    console.error('Erro ao salvar:', e);
    Swal.fire({ 
      icon: 'error', 
      title: 'Erro', 
      text: e.response?.status === 419 ? 'Sessão expirada. Recarregue a página.' : 'Falha ao salvar produto.', 
      confirmButtonColor: '#0F172A' 
    }); 
  }
};

const excluirProduto = async (id, nome) => {
  const conf = await Swal.fire({ title: 'Excluir?', text: `"${nome}" sairá do sistema.`, icon: 'warning', showCancelButton: true, confirmButtonColor: '#E11D48' });
  if (!conf.isConfirmed) return;
  try { await axios.delete(`/api/produto/${id}`); carregarProdutos(); } catch (e) { }
};
</script>

<style scoped>
.animate-fade-in-scale { animation: fadeInScale 0.18s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
.animate-fade-in { animation: fadeIn 0.15s ease-out forwards; }
@keyframes fadeInScale { from { opacity: 0; transform: scale(0.97) translateY(4px); } to { opacity: 1; transform: scale(1); } }
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
</style>