<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Landing Page - Aluguer de Carros</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
<body class="relative text-gray-800 min-h-screen overflow-hidden">

  <!-- Background com efeito Ken Burns -->
  <div class="absolute inset-0 z-0 kenburns-bg bg-cover bg-center" style="background-image: url('/images/background.svg');"></div>

  <!-- Conteúdo acima do fundo -->
  <section class="relative z-10 h-screen flex items-center justify-center bg-white/80">
    <div class="text-center">
      <img src="/images/logo.png" alt="Logotipo" class="mx-auto mb-2 w-80 h-auto">

      {{-- <h1 class="mb-6 text-black text-xl font-semibold">Viajamos juntos.</h1> --}}
      <div class="space-x-4">
        @auth
          <a href="{{ route('dashboard') }}" class="bg-white hover:bg-red-100 text-red-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Entrar</a>
        @else
          <a href="/login" class="bg-white hover:bg-red-100 text-red-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Login</a>
          <a href="/register" class="bg-white hover:bg-red-100 text-red-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Registar</a>
        @endauth
      </div>
    </div>
  </section>

</body>
</html>
