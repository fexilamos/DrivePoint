<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard')</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <style>
    @keyframes kenburns {
      0% {
        transform: scale(1) translate(0, 0);
      }
      100% {
        transform: scale(1.2) translate(-5%, -5%);
      }
    }

    .kenburns-bg {
      animation: kenburns 20s ease-in-out infinite alternate;
    }
  </style>
</head>
<body class="relative text-gray-900 min-h-screen">

  <!-- Fundo animado -->
  <div class="absolute inset-0 z-0 bg-cover bg-center kenburns-bg" style="background-image: url('/images/background.svg');"></div>

  <!-- Cabeçalho -->
  <header class="relative z-10 bg-red-700 text-white py-4 shadow">
    <div class="max-w-6xl mx-auto px-6 flex justify-between items-center">
      <h1>
        <img src="/images/logo2.png" alt="DrivePoint Logo" class="h-10 max-w-[220px] w-auto inline-block align-middle">
      </h1>

      <div class="flex items-center space-x-4">
        <form method="POST" action="/logout">
          @csrf
          <button type="submit" class="hover:bg-red-300 hover:text-red-900 px-4 py-2 rounded">Logout</button>
        </form>
      </div>
    </div>
  </header>

  <!-- Conteúdo -->
  <main class="relative z-10 max-w-6xl mx-auto px-6 py-10 bg-white/80 rounded-lg shadow-md mt-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

      <!-- Card: Dashboard -->
      <a href="{{ route('dashboard') }}" class="bg-gray-100 hover:bg-gray-200 p-6 rounded-lg text-center transition shadow">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-red-700 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10l9-7 9 7v10a1 1 0 01-1 1h-6v-5H10v5H4a1 1 0 01-1-1V10z" />
        </svg>
        <h2 class="text-xl font-semibold mb-1">Dashboard</h2>
        <p class="text-gray-700">Visão geral e acesso rápido</p>
      </a>

      <!-- Card: Reservas -->
      <a href="/reservas" class="bg-gray-100 hover:bg-gray-200 p-6 rounded-lg text-center transition shadow">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-red-700 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10m-6 4h6m-6 4h6M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <h2 class="text-xl font-semibold mb-1">Reservas</h2>
        <p class="text-gray-700">Efetuar Reserva</p>
      </a>

      <!-- Card: Carros -->
      <a href="/carros" class="bg-gray-100 hover:bg-gray-200 p-6 rounded-lg text-center transition shadow">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-red-700 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zm0 10s7-5.686 7-10a7 7 0 10-14 0c0 4.314 7 10 7 10z"/>
        </svg>
        <h2 class="text-xl font-semibold mb-1">Carros</h2>
        <p class="text-gray-700">Consulte as nossas viaturas</p>
      </a>

      <!-- Card: Perfil -->
      <a href="/perfil" class="bg-gray-100 hover:bg-gray-200 p-6 rounded-lg text-center transition shadow">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-red-700 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A8.967 8.967 0 0012 21c2.21 0 4.234-.804 5.879-2.196M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        <h2 class="text-xl font-semibold mb-1">Perfil</h2>
        <p class="text-gray-700">Gerir o meu Perfil e as minhas reservas</p>
      </a>

    </div>

    <div class="mt-10">
      @yield('content')
    </div>
  </main>

  <footer class="relative z-10 bg-red-700 text-white mt-10">
    <div class="max-w-6xl mx-auto px-6 py-4 flex flex-col md:flex-row items-center md:items-start justify-between">
      <!-- Logo -->
      <div class="flex items-center mb-4 md:mb-0">
        <img src="/images/logo2.png" alt="DrivePoint Logo" class="h-10 w-auto mr-3">
      </div>
      <!-- Links de acesso rápido + direitos reservados -->
      <div class="flex-1 flex flex-col items-center">
        <nav class="flex flex-row justify-center items-center gap-4 mb-2">
          <a href="/dashboard" class="hover:underline hover:text-red-200 transition">Dashboard</a>
          <a href="/reservas" class="hover:underline hover:text-red-200 transition">Reservas</a>
          <a href="/carros" class="hover:underline hover:text-red-200 transition">Carros</a>
          <a href="/perfil" class="hover:underline hover:text-red-200 transition">Perfil</a>
        </nav>
        <p class="text-white text-sm">© 2025 DrivePoint. Todos os direitos reservados.</p>
      </div>
    </div>
  </footer>
</body>
</html>
