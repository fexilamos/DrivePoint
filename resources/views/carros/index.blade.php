@extends('layouts.dashboard')

@section('title', 'Lista de Carros')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Lista de Carros</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    {{-- <a href="{{ route('carros.create') }}" class="inline-block mb-4 bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded">Adicionar Carro</a> --}}

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
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-6 rounded">Filtrar</button>
        </div>
    </form>

    <table class="min-w-full bg-white border border-gray-200 rounded shadow">
        <thead class="bg-gray-100">
            <tr>
                <th class="py-2 px-4 border-b text-left">Marca</th>
                <th class="py-2 px-4 border-b text-left">Modelo</th>
                <th class="py-2 px-4 border-b text-left">Ano</th>
                <th class="py-2 px-4 border-b text-left">Matrícula</th>
                <th class="py-2 px-4 border-b text-left">Preço/dia</th>
                <th class="py-2 px-4 border-b text-left">Disponível</th>
                <th class="py-2 px-4 border-b text-left">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($carros as $carro)
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border-b">{{ $carro->marca->nome ?? '' }}</td>
                    <td class="py-2 px-4 border-b">{{ $carro->modelo }}</td>
                    <td class="py-2 px-4 border-b">{{ $carro->ano }}</td>
                    <td class="py-2 px-4 border-b">{{ $carro->matricula }}</td>
                    <td class="py-2 px-4 border-b">{{ number_format($carro->preco_diario ?? $carro->preco_dia, 2) }} €</td>
                    <td class="py-2 px-4 border-b">
                        @if (isset($carro->disponivel))
                            {{ $carro->disponivel ? 'Sim' : 'Não' }}
                        @else
                            Sim
                        @endif
                    </td>
                    <td class="py-2 px-4 border-b relative">
                        <a href="{{ route('carros.show', $carro) }}?data_inicio={{ request('data_inicio') }}&data_fim={{ request('data_fim') }}"
                           class="px-6 py-2 bg-red-100 text-red-700 border border-red-300 rounded-lg hover:bg-red-600 hover:text-white transition">
                           Ver Detalhes
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
