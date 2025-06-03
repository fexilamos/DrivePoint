<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Landing Page - Aluguer de Carros</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-cover bg-center text-gray-800 min-h-screen" style="background-image: url('/images/background.svg');">

  <!-- Landing Page -->
  <section class="h-screen flex items-center justify-center bg-white/80">
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
