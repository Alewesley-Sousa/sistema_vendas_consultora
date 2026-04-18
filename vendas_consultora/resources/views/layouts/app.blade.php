<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Vendas')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --primary: #FF6F61;
            --primary-dark: #FF1493;
            --secondary: #FF69B4;
            --dark-sidebar: #2C3E50;
            --background: #FFF5F7;
            --card-bg: #FFFFFF;
            --text-muted: #5d6d7e;
            --radius: 15px;
            --shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        body {
            font-family: 'Segoe UI', sans-serif;
            background: var(--background);
            margin: 0;
            color: var(--dark-sidebar);
        }
        header {
            background: linear-gradient(135deg, var(--dark-sidebar), #1a252f);
            color: white;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .container-app { padding: 40px; max-width: 1200px; margin: 0 auto; }
    </style>
    @stack('styles')
</head>
<body>
    <header>
        <h1><i class="@yield('header-icon')"></i> @yield('header-title')</h1>
    </header>

    <div class="container-app">
        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>