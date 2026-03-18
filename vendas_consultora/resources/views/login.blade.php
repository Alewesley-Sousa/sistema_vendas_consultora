<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Login - Sistema</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="min-h-screen bg-gray-50 flex items-center justify-center p-6">
  <div class="max-w-4xl w-full flex gap-8 flex-wrap">
    <div class="w-full md:w-1/2 bg-white rounded-2xl shadow-lg p-8 border-t-8 border-pink-600">
      <header class="mb-4">
        <h1 class="text-2xl font-extrabold text-slate-800">Bem-vinda, Consultora</h1>
        <p class="text-pink-500 font-semibold">Acesse sua conta e conquiste seus objetivos!</p>
      </header>

      <form id="loginForm" class="flex flex-col gap-3">
          <div id="error-message" class="hidden mb-3 p-3 bg-red-50 border border-red-200 text-red-800 rounded">
              <ul id="error-list" class="list-disc pl-5"></ul>
          </div>

          <label for="email" class="text-sm font-semibold text-slate-700">Email</label>
          <input id="email" type="email" required autofocus
                class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:outline-none focus:ring-4 focus:ring-pink-100" />

          <label for="password" class="text-sm font-semibold text-slate-700">Senha</label>
          <input id="password" type="password" required
                class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:outline-none focus:ring-4 focus:ring-yellow-100" />

          <div class="flex items-center justify-between mt-2">
              <label for="remember" class="inline-flex items-center text-sm text-slate-700">
                  <input id="remember" type="checkbox" 
                        class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                  <span class="ml-2">Lembrar-me</span>
              </label>
              <a href="{{ route('senha-formulario') }}" class="text-sm text-slate-700 hover:text-pink-600">Esqueceu sua senha?</a>
          </div>

          <div class="mt-3">
              <button type="submit" id="btnEntrar"
                      class="w-full bg-gradient-to-r from-pink-600 via-pink-500 to-rose-400 text-white font-bold py-3 rounded-lg shadow-md hover:translate-y-[-2px] transition-transform">
                Entrar
              </button>
          </div>
      </form>
    </div>

    <aside class="w-full md:w-1/3 bg-white/80 backdrop-blur rounded-2xl p-8 flex flex-col items-center justify-center shadow-sm">
      <div class="px-4 py-2 rounded-full bg-gradient-to-r from-rose-400 to-pink-500 text-white font-extrabold">Meta</div>
      <p class="mt-3 text-slate-800 font-semibold">Empoderamento • Energia • Profissionalismo</p>
    </aside>
  </div>
</body>
</html>