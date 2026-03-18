<body class="min-h-screen bg-gray-50 flex items-center justify-center p-6">
  <div class="w-full max-w-md bg-white rounded-2xl shadow-md p-6">
    <h2 class="text-2xl font-bold text-slate-800 mb-2">Redefinir senha</h2>
    <p class="text-sm text-slate-600 mb-4">Escolha uma nova senha para sua conta.</p>

    <form id="formAtualizarSenha" class="space-y-4">
      {{-- O Vite e o CSRF estão no Head --}}
      
      <div id="msg-feedback" class="hidden mb-4 p-3 rounded text-sm font-medium">
          <ul id="error-list" class="list-disc pl-5"></ul>
      </div>

      <input type="hidden" name="token" value="{{ $token }}">
      <input type="hidden" name="email" value="{{ $email }}">

      <label class="block text-sm font-semibold text-slate-700">Nova senha</label>
      <input type="password" id="password" required
             class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-pink-100" />

      <label class="block text-sm font-semibold text-slate-700">Confirmar nova senha</label>
      <input type="password" id="password_confirmation" required
             class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-pink-100" />

      <button type="submit" id="btnResetar"
              class="w-full bg-pink-600 hover:bg-pink-700 text-white font-bold py-3 rounded-lg transition">
          Redefinir senha
      </button>
    </form>
  </div>
</body>