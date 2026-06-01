<template>
  <div 
    data-aurora-card 
    class="relative p-[1px] bg-slate-200/60 rounded-2xl overflow-hidden group/aurora transition-all duration-300 hover:shadow-lg"
  >
    <div class="absolute inset-0 opacity-0 group-hover/aurora:opacity-100 bg-aurora-gradient transition-opacity duration-300 pointer-events-none z-0"></div>
    
    <div class="relative z-10 p-6 bg-white rounded-[15px] h-full flex flex-col justify-between">
      <div class="flex items-center justify-between mb-4">
        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ title }}</span>
        <div class="w-9 h-9 rounded-xl bg-slate-50 flex items-center justify-center border border-slate-200/60" :class="color">
          <i class="fa-solid" :class="icon"></i>
        </div>
      </div>
      <div>
        <!-- O valor é formatado dinamicamente enquanto a animação ocorre -->
        <h3 class="text-2xl font-black text-slate-900 tracking-tight">
          {{ prefix }}{{ Number(displayValue).toLocaleString('pt-BR', { minimumFractionDigits: decimals }) }}
        </h3>
        <p class="mt-2 text-[10px] text-slate-400 font-bold uppercase tracking-wide">{{ subtitle }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue';

const props = defineProps({
  title: String,
  targetValue: { type: Number, default: 0 },
  icon: String,
  color: String,
  prefix: { type: String, default: 'R$ ' },
  subtitle: { type: String, default: 'Atualizado agora' },
  decimals: { type: Number, default: 2 }
});

const displayValue = ref(0);

// Lógica de animação (Count-Up)
const animarValor = (valorFinal, duracao = 1200) => {
    const tempoInicial = performance.now();
    const passo = (tempoAtual) => {
        const progresso = Math.min((tempoAtual - tempoInicial) / duracao, 1);
        displayValue.value = progresso * valorFinal;
        if (progresso < 1) requestAnimationFrame(passo);
        else displayValue.value = valorFinal;
    };
    requestAnimationFrame(passo);
};

// Dispara a animação quando o targetValue mudar (carregamento da API)
watch(() => props.targetValue, (newVal) => {
    if (newVal > 0) animarValor(newVal);
});

onMounted(() => {
    if (props.targetValue > 0) animarValor(props.targetValue);
});
</script>