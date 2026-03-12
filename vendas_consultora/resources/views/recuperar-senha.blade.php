<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Recuperar senha</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 flex items-center justify-center p-6">
  <div class="w-full max-w-md bg-white rounded-2xl shadow-md p-6">
    <h2 class="text-2xl font-bold text-slate-800 mb-2">Recuperar senha</h2>
    <p class="text-sm text-slate-600 mb-4">Informe seu e-mail e enviaremos um link para redefinir sua senha.</p>

    @if (session('status'))
      <div class="mb-4 p-3 rounded bg-green-50 text-green-700">
        {{ session('status') }}
      </div>
    @endif

    @if ($errors->any())
      <div class="mb-4 p-3 rounded bg-red-50 text-red-700">
        <ul class="list-disc pl-5">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('senha-email') }}" class="space-y-4">
      @csrf

      <label class="block text-sm font-semibold text-slate-700">Email</label>
      <input type="email" name="email" value="{{ old('email') }}" required autofocus
             class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-pink-100" />

      <div>
        <button type="submit"
                class="w-full bg-pink-600 hover:bg-pink-700 text-white font-bold py-3 rounded-lg transition">
          Enviar link de recuperação
        </button>
      </div>

      <div class="text-center text-sm text-slate-600">
        <a href="{{ route('login') }}" class="text-pink-600 hover:underline">Voltar ao login</a>
      </div>
    </form>
  </div>
</body>
</html>