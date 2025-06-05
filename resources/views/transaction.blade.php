<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Pagamento por Referência Multibanco</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 py-10 px-4">
    <div class="max-w-md mx-auto bg-white p-8 rounded-xl shadow-md">
        <h2 class="text-2xl font-bold text-center text-red-800 mb-6">
            Pagamento por Referência Multibanco
        </h2>

        <div class="bg-gray-50 border border-gray-300 rounded-lg p-6 mb-6 text-center">
            <div class="mb-4">
                <div class="text-sm font-semibold text-gray-600">Entidade:</div>
                <div class="text-lg font-mono text-gray-800 tracking-wider">12345</div>
            </div>
            <div class="mb-4">
                <div class="text-sm font-semibold text-gray-600">Referência:</div>
                <div class="text-lg font-mono text-gray-800 tracking-wider">
                    {{ session('reserva.ref') ?? '999 999 999' }}
                </div>
            </div>
            <div>
                <div class="text-sm font-semibold text-gray-600">Valor:</div>
                <div class="text-lg font-mono text-gray-800 tracking-wider">
                    {{ session('reserva.total') ? number_format(session('reserva.total'), 2) : '0.00' }} €
                </div>
            </div>
        </div>

        <form action="{{ route('multibanco.confirmar') }}" method="POST" class="text-center">
            @csrf
            <button type="submit"
                class="bg-white hover:bg-red-100 text-red-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow transition duration-200">
                Confirmar Pagamento
            </button>
        </form>
    </div>
</body>
</html>
