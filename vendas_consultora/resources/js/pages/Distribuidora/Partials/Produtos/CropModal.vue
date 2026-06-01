<template>
  <div
    v-if="openCropModal"
    class="fixed inset-0 z-[70] flex items-center justify-center p-3 sm:p-5 bg-slate-950/70 backdrop-blur-xl animate-fade-in"
    role="dialog"
  >
    <!-- Overlay -->
    <div
      @click="$emit('cancel')"
      class="absolute inset-0"
    ></div>

    <!-- Modal -->
    <div
      class="relative w-full max-w-2xl overflow-hidden rounded-3xl
      border border-slate-200/10 dark:border-slate-800/70
      bg-white/90 dark:bg-slate-900/90
      backdrop-blur-xl
      shadow-[0_25px_80px_-20px_rgba(0,0,0,0.45)]
      ring-1 ring-white/10
      animate-fade-in-scale"
    >
      <!-- Glow -->
      <div
        class="pointer-events-none absolute inset-0 rounded-3xl
        bg-gradient-to-br
        from-indigo-500/5
        via-sky-500/5
        to-purple-500/5"
      ></div>

      <div class="relative p-5 sm:p-7 space-y-6 font-['Inter']">

        <!-- Header -->
        <div
          class="flex items-center justify-between
          border-b border-slate-200/10 dark:border-slate-800/70
          pb-4"
        >
          <div class="flex items-center gap-3">
            <div
              class="flex h-10 w-10 items-center justify-center
              rounded-2xl
              bg-gradient-to-br
              from-indigo-500/15
              to-sky-500/15
              border border-slate-200/10
              shadow-inner"
            >
              <span class="material-symbols-outlined text-slate-700 dark:text-slate-200">
                crop
              </span>
            </div>

            <div>
              <h3
                class="text-lg font-semibold tracking-tight
                text-slate-900 dark:text-white"
              >
                Ajustar imagem
              </h3>

              <p
                class="text-sm text-slate-500 dark:text-slate-400
                font-medium"
              >
                Ajuste e centralize antes de aplicar
              </p>
            </div>
          </div>

          <!-- Close -->
          <button
            type="button"
            @click="$emit('cancel')"
            class="rounded-xl p-2
            text-slate-400
            hover:text-slate-900
            hover:bg-slate-100/70
            dark:hover:bg-slate-800/80
            transition-all duration-200"
          >
            <span class="material-symbols-outlined">close</span>
          </button>
        </div>

        <!-- Crop Container -->
        <div
          class="relative overflow-hidden rounded-2xl
          border border-slate-200/10 dark:border-slate-800
          bg-gradient-to-br
          from-slate-950
          via-slate-900
          to-slate-800
          flex items-center justify-center
          shadow-inner
          h-[52vh]
          sm:h-[430px]"
        >
          <!-- Background texture glow -->
          <div
            class="absolute inset-0
            bg-[radial-gradient(circle_at_top,rgba(99,102,241,0.12),transparent_45%)]"
          ></div>

          <img
            ref="imageElement"
            :src="cropSource"
            class="relative block max-h-full max-w-full"
            alt="Crop"
          />
        </div>

        <!-- Footer -->
        <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-1">

          <!-- Cancel -->
          <button
            type="button"
            @click="$emit('cancel')"
            class="px-5 py-3 rounded-2xl
            font-medium text-sm
            border border-slate-200/10
            bg-slate-100/80
            dark:bg-slate-800/80
            text-slate-700 dark:text-slate-300
            hover:bg-slate-200/80
            dark:hover:bg-slate-700
            hover:shadow-lg
            transition-all duration-200"
          >
            Cancelar
          </button>

          <!-- Apply -->
          <button
            type="button"
            @click="processCrop"
            class="group
            px-5 py-3 rounded-2xl
            text-sm font-semibold
            text-white
            bg-gradient-to-r
            from-slate-900
            via-slate-800
            to-slate-900
            dark:from-white
            dark:via-slate-100
            dark:to-white
            dark:text-slate-900
            shadow-lg shadow-slate-950/20
            hover:shadow-xl
            hover:shadow-indigo-500/20
            hover:-translate-y-[1px]
            active:scale-[0.98]
            transition-all duration-200"
          >
            <span class="flex items-center gap-2">
              <span
                class="material-symbols-outlined text-[18px]
                transition-transform duration-200
                group-hover:rotate-[-4deg]"
              >
                crop
              </span>
              Aplicar corte
            </span>
          </button>

        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onBeforeUnmount, nextTick } from 'vue';
import Cropper from 'cropperjs/dist/cropper.js';
import 'cropperjs/dist/cropper.css';

defineProps({
  openCropModal: Boolean,
  cropSource: String
});

const emit = defineEmits(['cancel', 'confirmed']);

const imageElement = ref(null);
let cropperInstance = null;

const destroyCropper = () => {
  if (
    cropperInstance &&
    typeof cropperInstance.destroy === 'function'
  ) {
    cropperInstance.destroy();
    cropperInstance = null;
  }
};

const setupCropper = () => {
  destroyCropper();

  nextTick(() => {
    if (!imageElement.value) return;

    cropperInstance = new Cropper(
      imageElement.value,
      {
        aspectRatio: 1,
        viewMode: 1,
        dragMode: 'move',
        autoCropArea: 1,
        checkOrientation: false,
        responsive: true,
        background: false
      }
    );
  });
};

const processCrop = () => {
  if (
    !cropperInstance ||
    typeof cropperInstance.getCroppedCanvas !== 'function'
  ) {
    console.error(
      'Cropper não inicializou corretamente.'
    );
    return;
  }

  const canvas =
    cropperInstance.getCroppedCanvas({
      width: 800,
      height: 800,
      imageSmoothingEnabled: true,
      imageSmoothingQuality: 'high'
    });

  if (!canvas) return;

  canvas.toBlob(
    (blob) => {
      if (!blob) return;

      const file = new File(
        [blob],
        `produto_${Date.now()}.jpg`,
        {
          type: 'image/jpeg'
        }
      );

      const previewUrl =
        URL.createObjectURL(blob);

      emit('confirmed', {
        file,
        previewUrl
      });

      destroyCropper();
    },
    'image/jpeg',
    0.9
  );
};

defineExpose({
  setupCropper,
  destroyCropper
});

onBeforeUnmount(destroyCropper);
</script>

<style scoped>
.animate-fade-in-scale {
  animation: fadeInScale .28s cubic-bezier(0.16,1,0.3,1) forwards;
}

.animate-fade-in {
  animation: fadeIn .18s ease-out forwards;
}

@keyframes fadeInScale {
  from {
    opacity: 0;
    transform: translateY(8px) scale(.97);
  }
  to {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}
</style>