<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Redefinir senha</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 flex items-center justify-center p-6">
  <div class="w-full max-w-md bg-white rounded-2xl shadow-md p-6">
    <h2 class="text-2xl font-bold text-slate-800 mb-2">Redefinir senha</h2>
    <p class="text-sm text-slate-600 mb-4">Escolha uma nova senha para sua conta.</p>

    @if ($errors->any())
      <div class="mb-4 p-3 rounded bg-red-50 text-red-700">
        <ul class="list-disc pl-5">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('senha.atualizar') }}" class="space-y-4">
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" name="email" value="{{ old('email', $email) }}">

    <label class="block text-sm font-semibold text-slate-700">Nova senha</label>
    <input type="password" name="password" required
            class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-pink-100" />

    <label class="block text-sm font-semibold text-slate-700">Confirmar nova senha</label>
    <input type="password" name="password_confirmation" required
            class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-pink-100" />

    <button type="submit"
            class="w-full bg-pink-600 hover:bg-pink-700 text-white font-bold py-3 rounded-lg">
        Redefinir senha
    </button>
    </form>
  </div>
</body>
</html>