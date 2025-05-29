@extends('layouts.dashboard')

@section('title', 'Detalhes do Carro')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-lg">
    <h1 class="text-3xl font-bold mb-6">Detalhes do Carro</h1>

    <div class="bg-white shadow rounded p-6">
        <h2 class="text-xl font-semibold mb-2">{{ $carro->marca }} {{ $carro->modelo }} ({{ $carro->ano }})</h2>
        <p class="mb-1"><strong>Matrícula:</strong> {{ $carro->matricula }}</p>
        <p class="mb-1"><strong>Preço por dia:</strong> {{ number_format($carro->preco_dia, 2) }} €</p>
        <p class="mb-4"><strong>Disponível:</strong> {{ $carro->disponivel ? 'Sim' : 'Não' }}</p>
        @if ($carro->imagem)
            <img src="{{ asset('storage/' . $carro->imagem) }}" alt="Imagem do carro" class="rounded max-w-full h-auto" />
        @endif
    </div>

    <a href="{{ route('carros.index') }}" class="inline-block mt-6 bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 px-4 rounded">Voltar</a>
</div>
@endsection
