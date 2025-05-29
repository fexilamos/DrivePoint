<!DOCTYPE html>
<html lang="pt" x-data="themeSwitcher()" x-init="init()" :class="{ 'dark': darkMode }">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard')</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-white text-gray-900 dark:bg-gray-900 dark:text-gray-100 min-h-screen transition-colors duration-300">

  <!-- Cabeçalho -->
  <header class="bg-red-500 text-white dark:bg-red-600 py-4 shadow">
    <div class="max-w-6xl mx-auto px-6 flex justify-between items-center">

      <h1 class="text-2xl font-bold">DrivePoint</h1>

      <div class="flex items-center space-x-4">
        <!-- Radial Switch com SVG Heroicons -->
<label class="relative inline-flex items-center cursor-pointer">
  <input type="checkbox" class="sr-only peer" x-model="darkMode" @change="toggle()">
  <div class="w-14 h-8 bg-gray-300 dark:bg-gray-700 rounded-full peer-checked:bg-red-500 transition-all duration-300 flex items-center px-1">
    <div class="absolute left-0.5 top-0.5 w-7 h-7 bg-white rounded-full shadow transform peer-checked:translate-x-6 transition-transform duration-300 flex items-center justify-center">
      <template x-if="!darkMode">
        <!-- Sol (Heroicons) -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 3v1m0 16v1m8.66-8.66h1M3.34 12H2m16.95 4.95l.71.71M4.34 4.34l-.71-.71m0 16.95l.71-.71m16.95-16.95l-.71.71M12 7a5 5 0 100 10 5 5 0 000-10z" />
        </svg>
      </template>
      <template x-if="darkMode">
        <!-- Lua (Heroicons) -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-700 dark:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
        </svg>
      </template>
    </div>
  </div>
</label>

        <!-- Botão Logout -->
        <form method="POST" action="/logout">
          @csrf
          <button type="submit" class="hover:bg-red-300 hover:text-red-900 px-4 py-2 rounded">Logout</button>
        </form>
      </div>
    </div>
  </header>

  <!-- Conteúdo -->
  <main class="max-w-6xl mx-auto px-6 py-10">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

      <!-- Card: Dashboard -->
      <a href="{{ route('dashboard') }}" class="bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 p-6 rounded-lg text-center transition shadow">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-red-700 dark:text-red-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10l9-7 9 7v10a1 1 0 01-1 1h-6v-5H10v5H4a1 1 0 01-1-1V10z" />
        </svg>
        <h2 class="text-xl font-semibold mb-1">Dashboard</h2>
        <p class="text-gray-700 dark:text-gray-300">Visão geral e acesso rápido.</p>
      </a>

      <!-- Card: Reservas -->
      <a href="/reservas" class="bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 p-6 rounded-lg text-center transition shadow">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-red-700 dark:text-red-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10m-6 4h6m-6 4h6M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <h2 class="text-xl font-semibold mb-1">Reservas</h2>
        <p class="text-gray-700 dark:text-gray-300">Gerir e consultar reservas.</p>
      </a>

      <!-- Card: Carros -->
      <a href="/carros" class="bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 p-6 rounded-lg text-center transition shadow">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-red-700 dark:text-red-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13l2-5h14l2 5M5 13h14v5a2 2 0 01-2 2H7a2 2 0 01-2-2v-5zM6 16h.01M18 16h.01" />
        </svg>
        <h2 class="text-xl font-semibold mb-1">Carros</h2>
        <p class="text-gray-700 dark:text-gray-300">Listar ou adicionar carros.</p>
      </a>

      <!-- Card: Perfil -->
      <a href="/perfil" class="bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 p-6 rounded-lg text-center transition shadow">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-red-700 dark:text-red-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A8.967 8.967 0 0012 21c2.21 0 4.234-.804 5.879-2.196M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        <h2 class="text-xl font-semibold mb-1">Perfil</h2>
        <p class="text-gray-700 dark:text-gray-300">Atualizar dados da conta.</p>
      </a>

    </div>

    <!-- Conteúdo dinâmico -->
    <div class="mt-10">
      @yield('content')
    </div>
  </main>

  <!-- Script Alpine.js para dark mode toggle -->
  <script>
  function themeSwitcher() {
    return {
      darkMode: false,
      init() {
        this.darkMode = JSON.parse(localStorage.getItem('darkMode')) ?? window.matchMedia('(prefers-color-scheme: dark)').matches;
        if (this.darkMode) {
          document.documentElement.classList.add('dark');
        } else {
          document.documentElement.classList.remove('dark');
        }
      },
      toggle() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('darkMode', JSON.stringify(this.darkMode));
        if (this.darkMode) {
          document.documentElement.classList.add('dark');
        } else {
          document.documentElement.classList.remove('dark');
        }
      }
    }
  }
</script>

  <!-- Rodapé -->
  <footer class="bg-gray-200 dark:bg-gray-800 text-center py-4 mt-10">
    <p class="text-gray-600 dark:text-gray-400">© 2023 DrivePoint. Todos os direitos reservados.</p>
  </footer>
</main>
</div>

</body>
</html>
