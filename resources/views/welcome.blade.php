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

      <h1 class="mb-6 text-black text-xl font-semibold">Faça login ou registe-se para começar</h1>
      <div class="space-x-4">
        <a href="/login" class="px-6 py-2 bg-red-600 text-white rounded-lg shadow hover:bg-red-700 transition">Login</a>
        <a href="/register" class="px-6 py-2 bg-red-100 text-red-700 border border-red-300 rounded-lg hover:bg-red-600 hover:text-white transition">Registar</a>
      </div>
    </div>
  </section>

</body>
</html>
