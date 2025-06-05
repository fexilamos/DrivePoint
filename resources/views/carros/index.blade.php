@extends('layouts.dashboard')

@section('title', 'Lista de Carros')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10 bg-white/80 rounded-lg shadow-md mt-6">
    <h1 class="text-3xl font-bold mb-6">A nossa gama de carros</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif


    <form method="GET" action="{{ route('carros.index') }}" class="mb-6 flex flex-wrap gap-4 items-end bg-gray-50 p-4 rounded shadow">
        <div>
            <label for="marca" class="block text-gray-700 font-semibold mb-1">Marca</label>
            <select name="marca" id="marca" class="w-40 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                <option value="">Todas</option>
                @foreach ($marcas as $id => $nome)
                    <option value="{{ $nome }}" {{ request('marca') == $nome ? 'selected' : '' }}>{{ $nome }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="cor" class="block text-gray-700 font-semibold mb-1">Cor</label>
            <select name="cor" id="cor" class="w-32 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                <option value="">Todas</option>
                @foreach ($cores as $cor)
                    <option value="{{ $cor }}" {{ request('cor') == $cor ? 'selected' : '' }}>{{ $cor }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="disponivel" class="block text-gray-700 font-semibold mb-1">Disponível</label>
            <select name="disponivel" id="disponivel"
                class="w-32 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                <option value="">Todos</option>
                <option value="1" {{ request('disponivel') === '1' ? 'selected' : '' }}>Sim</option>
                <option value="0" {{ request('disponivel') === '0' ? 'selected' : '' }}>Não</option>
            </select>
        </div>
        <div>
            <button type="submit" class="bg-white hover:bg-red-100 text-red-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Filtrar</button>
        </div>
    </form>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-6">
        @foreach ($carros as $carro)
            <div class="bg-white rounded-lg shadow p-4 flex flex-col">
                <img src="{{ asset('images/' . $carro->imagem) }}" alt="Imagem do {{ $carro->modelo }}" class="w-full h-40 object-cover rounded mb-3 border">
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-red-700 mb-1">{{ $carro->marca->nome ?? '' }} {{ $carro->modelo }} ({{ $carro->ano }})</h3>
                    <p class="text-gray-700 text-sm mb-1">Matrícula: <span class="font-semibold">{{ $carro->matricula ?? $carro->registo_unico_publico ?? '-' }}</span></p>
                    <p class="text-gray-700 text-sm mb-1">Cor: {{ $carro->cor }}</p>
                    <p class="text-gray-700 text-sm mb-1">Preço/dia: <span class="font-semibold">{{ number_format($carro->preco_diario ?? $carro->preco_dia, 2) }} €</span></p>
                    <p class="text-gray-700 text-sm mb-1">Combustível: {{ ucfirst($carro->combustivel) }}</p>
                    <p class="text-gray-700 text-sm mb-1">Transmissão: {{ ucfirst($carro->transmissao) }}</p>
                    <p class="text-gray-700 text-sm mb-1">Disponível: <span class="font-semibold">@if (isset($carro->disponivel)){{ $carro->disponivel ? 'Sim' : 'Não' }}@else Sim @endif</span></p>
                </div>
                <a href="{{ route('carros.show', $carro) }}" class="bg-white hover:bg-red-100 text-red-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Ver Detalhes</a>
            </div>
        @endforeach
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
