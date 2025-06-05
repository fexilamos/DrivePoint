<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva Finalizada</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-100 p-10">
    <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md text-center">

        @if (session('success'))
            <div class="p-4 mb-4 text-white bg-green-500 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-gray-100 p-6 rounded-md shadow-sm max-w-lg mx-auto">
            <h2 class="text-2xl font-bold mb-4 text-center">Reserva Finalizada com Sucesso</h2>

            @if (isset($reserva))
                <div class="mb-4 text-left">
                    <h3 class="text-lg font-semibold mb-2 text-gray-800">Resumo da Reserva</h3>
                    <ul class="text-gray-700 text-sm space-y-1">
                        <li><strong>Carro:</strong> {{ $reserva->bemLocavel->marca->nome ?? '' }} {{ $reserva->bemLocavel->modelo ?? '' }}</li>
                        <li><strong>Matrícula:</strong> {{ $reserva->bemLocavel->registo_unico_publico ?? $reserva->bemLocavel->matricula ?? '-' }}</li>
                        <li><strong>Data de Início:</strong> {{ $reserva->data_inicio }}</li>
                        <li><strong>Data de Fim:</strong> {{ $reserva->data_fim }}</li>
                        <li><strong>Local de levantamento:</strong> {{ $reserva->local_retirada ?? '-' }}</li>
                        <li><strong>Preço Total:</strong> {{ number_format($reserva->preco_total, 2) }} €</li>
                        <li><strong>Estado:</strong> {{ ucfirst($reserva->status ?? 'ativa') }}</li>
                    </ul>
                    <div class="mt-4 flex flex-row justify-center gap-4">
                        <a href="{{ route('reservas.pdf', $reserva->id) }}" target="_blank" class="bg-white hover:bg-red-100 text-red-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Download PDF</a>
                        <a href="{{ route('profile.edit') }}"
                            class="bg-white hover:bg-red-100 text-red-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
                            Ir para o meu perfil
                        </a>
                    </div>
                </div>
            @endif

            <div class="flex justify-center">

            </div>
        </div>

    </div>
</body>

</html>
