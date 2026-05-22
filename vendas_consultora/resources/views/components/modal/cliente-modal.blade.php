@props(['id', 'title', 'subtitle'])

<div
    x-data="clienteModalData()"
    x-show="open"
    @open-modal-{{ $id }}.window="openModal()"
    @close-modal.window="closeModal()"
    @keydown.escape.window="closeModal()"
    x-cloak
    role="dialog"
    aria-modal="true"
    aria-labelledby="modal-title-{{ $id }}"
    class="fixed inset-0 z-[100] flex items-center justify-center p-4">

    <div
        x-show="open"
        x-transition.opacity.duration.300ms
        @click="closeModal()"
        class="fixed inset-0 bg-[#0F1722]/70 backdrop-blur-md">
    </div>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 scale-95 translate-y-8"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-6"
        class="relative z-10 w-full max-w-2xl overflow-hidden rounded-[2.5rem] border border-white/20 bg-white shadow-[0_30px_70px_rgba(0,0,0,0.35)]">

        @include('components.modal.sections.header')

        <div class="max-h-[70vh] overflow-y-auto bg-white px-6 py-6 sm:px-8 sm:py-8">
            @include('components.modal.sections.menu')
            @include('components.modal.sections.consulta')
            @include('components.modal.sections.cadastro')
            @include('components.modal.sections.resultado')
            @include('components.modal.sections.erro')
        </div>

        @include('components.modal.sections.footer')

    </div>
</div>

@once
    @include('components.modal.cliente-modal-data')
@endonce