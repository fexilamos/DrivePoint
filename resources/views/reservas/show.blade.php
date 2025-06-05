@extends('layouts.dashboard')

@section('content')
<div class="max-w-2xl mx-auto mt-10 bg-white rounded-lg shadow p-8">
    <h2 class="text-2xl font-bold mb-6 text-center">Detalhe da Reserva</h2>
    <div class="mb-4">
        <span class="font-semibold">Carro:</span>
        {{ $reserva->bemLocavel->marca->nome ?? '-' }} {{ $reserva->bemLocavel->modelo ?? '-' }}
    </div>
    <div class="mb-4">
        <span class="font-semibold">Data de Início:</span> {{ \Carbon\Carbon::parse($reserva->data_inicio)->format('d/m/Y') }}
    </div>
    <div class="mb-4">
        <span class="font-semibold">Data de Fim:</span> {{ \Carbon\Carbon::parse($reserva->data_fim)->format('d/m/Y') }}
    </div>
    <div class="mb-4">
        <span class="font-semibold">Estado:</span> <span class="inline-block px-2 py-1 rounded {{ $reserva->status == 'pago' ? 'bg-green-200 text-green-800' : ($reserva->status == 'cancelado' ? 'bg-red-200 text-red-800' : 'bg-yellow-200 text-yellow-800') }}">{{ ucfirst($reserva->status) }}</span>
    </div>

    <div class="mb-8">
        <span class="font-semibold">Valor Total:</span> {{ number_format($reserva->preco_total, 2, ',', '.') }} €
    </div>
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="{{ route('reservas.pdf', $reserva->id) }}" class="bg-gray-700 hover:bg-gray-800 text-white font-semibold py-2 px-4 rounded shadow text-center">Imprimir PDF</a>
        <form action="{{ route('reservas.cancelar', $reserva->id) }}" method="POST" onsubmit="return confirm('Tem a certeza que deseja cancelar esta reserva?');">
            @csrf
            @method('PATCH')
            <button type="submit" class="bg-white hover:bg-red-100 text-red-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Cancelar Reserva</button>
        </form>
        <form action="{{ route('reservas.enviarEmail', $reserva->id) }}" method="GET">
            <button type="submit" class="bg-white hover:bg-red-100 text-red-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Enviar Email</button>
        </form>
    </div>
    @if(session('success'))
        <div class="bg-white hover:bg-red-100 text-red-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mt-6 p-4 bg-red-100 text-red-800 rounded shadow text-center">{{ session('error') }}</div>
    @endif
    <div class="mt-8 text-center">
        <a href="{{ route('profile.edit') }}" class="text-blue-600 hover:underline">Voltar ao Perfil</a>
    </div>
</div>
@endsection
