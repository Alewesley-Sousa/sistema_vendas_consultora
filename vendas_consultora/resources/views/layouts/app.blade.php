<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>{{ config('app.name', 'Sistema de Vendas') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        #global-loader {
            display: flex;
            transition: opacity 0.3s ease;
        }
        #global-loader.hidden {
            display: none;
            opacity: 0;
        }
    </style>
</head>
<body class="antialiased font-sans">

    <div id="global-loader" class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-white/80 backdrop-blur-sm">
        <div class="h-12 w-12 animate-spin rounded-full border-4 border-gray-200 border-t-[#2C3E50]"></div>
        <p class="mt-4 font-medium text-gray-700">Carregando...</p>
    </div>

    <div class="min-h-screen bg-gray-50 flex items-center justify-center">
        <main class="w-full flex justify-center p-4 md:p-8">
            @yield('conteudo')
        </main>
    </div>

    <script>
        window.addEventListener('load', () => {
            const loader = document.getElementById('global-loader');
            loader.classList.add('hidden');
        });
    </script>
</body>
</html>