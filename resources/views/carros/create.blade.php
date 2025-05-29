@extends('layouts.dashboard')

@section('title', 'Adicionar Novo Carro')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-lg">
    <h1 class="text-3xl font-bold mb-6">Adicionar Novo Carro</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('carros.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div>
            <label for="marca" class="block text-gray-700 font-semibold mb-2">Marca</label>
            <input type="text" name="marca" id="marca" value="{{ old('marca') }}" required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <div>
            <label for="modelo" class="block text-gray-700 font-semibold mb-2">Modelo</label>
            <input type="text" name="modelo" id="modelo" value="{{ old('modelo') }}" required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <div>
            <label for="ano" class="block text-gray-700 font-semibold mb-2">Ano</label>
            <input type="number" name="ano" id="ano" value="{{ old('ano') }}" required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <div>
            <label for="matricula" class="block text-gray-700 font-semibold mb-2">Matrícula</label>
            <input type="text" name="matricula" id="matricula" value="{{ old('matricula') }}" required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <div>
            <label for="preco_dia" class="block text-gray-700 font-semibold mb-2">Preço por Dia (€)</label>
            <input type="number" step="0.01" name="preco_dia" id="preco_dia" value="{{ old('preco_dia') }}" required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <div>
            <label for="imagem" class="block text-gray-700 font-semibold mb-2">Imagem do Carro</label>
            <input type="file" name="imagem" id="imagem"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <div class="flex items-center">
            <input type="checkbox" name="disponivel" id="disponivel" checked
                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" />
            <label for="disponivel" class="ml-2 block text-gray-700 font-semibold">Disponível</label>
        </div>

        <div class="flex space-x-4">
            <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">Guardar Carro</button>
            <a href="{{ route('carros.index') }}"
                class="bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 px-4 rounded">Cancelar</a>
        </div>
    </form>
</div>
@endsection
