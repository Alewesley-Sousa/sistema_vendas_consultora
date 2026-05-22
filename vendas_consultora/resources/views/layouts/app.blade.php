<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Glow Cosmetics')
    </title>

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}">

    {{-- Fonts --}}
    <link
        rel="preconnect"
        href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- Font Awesome --}}
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    {{-- Vite --}}
    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    @stack('styles')
</head>

<body
    class="font-[Inter] bg-[#FFF5F7] text-[#2C3E50] antialiased">

    {{-- Alpine cloak --}}
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div
        class="relative min-h-screen overflow-hidden">

        {{-- Background Layer --}}
        <div
            id="app-background"
            class="absolute inset-0 -z-10">
        </div>

        {{-- Layout --}}
        <div
            class="flex min-h-screen md:p-4 overflow-hidden">

            {{-- Sidebar --}}
            <x-sidebar />

            {{-- Main --}}
            <main
                class="flex-1 overflow-y-auto p-6 md:p-8">

                {{-- Header --}}
                @hasSection('header')
                    <section class="mb-8">
                        @yield('header')
                    </section>
                @endif

                {{-- Content --}}
                <section>
                    @yield('content')
                </section>

            </main>

        </div>

    </div>

    {{-- Global Modals --}}
    @stack('modals')

    {{-- Scripts específicos da página --}}
    @stack('scripts')

</body>
</html>