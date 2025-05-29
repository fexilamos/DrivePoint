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

    {{-- <a href="{{ route('carros.create') }}" class="inline-block mb-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Adicionar Carro</a> --}}

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
                    <td class="py-2 px-4 border-b">{{ $carro->marca }}</td>
                    <td class="py-2 px-4 border-b">{{ $carro->modelo }}</td>
                    <td class="py-2 px-4 border-b">{{ $carro->ano }}</td>
                    <td class="py-2 px-4 border-b">{{ $carro->matricula }}</td>
                    <td class="py-2 px-4 border-b">{{ number_format($carro->preco_dia, 2) }} €</td>
                    <td class="py-2 px-4 border-b">{{ $carro->disponivel ? 'Sim' : 'Não' }}</td>
                    <td class="py-2 px-4 border-b relative">
                        <div x-data="{ open: false }" class="inline-block text-left">
                            <button @click="open = !open" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-1 px-3 rounded inline-flex items-center">
                                Ações
                                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-32 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                                <div class="py-1">
                                    <a href="{{ route('carros.show', $carro) }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Ver</a>
                                    <a href="{{ route('carros.edit', $carro) }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Editar</a>
                                    <form action="{{ route('carros.destroy', $carro) }}" method="POST" onsubmit="return confirm('Tem a certeza que deseja eliminar este carro?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">Apagar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
