@extends('layouts.dashboard')
@section('title', 'Confirmação da Reserva')
@section('content')
<div class="container mx-auto px-4 py-6 max-w-lg">
    <h1 class="text-2xl font-bold mb-6">Confirme os dados da sua reserva</h1>
    <div class="bg-white shadow rounded p-6 mb-4">
        <p><strong>Carro:</strong> {{ $carro->marca->nome ?? '' }} {{ $carro->modelo }} ({{ $carro->ano }})</p>
        <p><strong>Data de Início:</strong> {{ $data_inicio }}</p>
        <p><strong>Data de Fim:</strong> {{ $data_fim }}</p>
        <p><strong>Número de dias:</strong> {{ $dias }}</p>
        <p><strong>Valor a pagar:</strong> €{{ number_format($total, 2) }}</p>
        <p><strong>Local de levantamento:</strong> {{ $local_retirada }}</p>
    </div>
    <form action="{{ route('transaction.process') }}" method="GET">
        <input type="hidden" name="carro_id" value="{{ $carro->id }}">
        <input type="hidden" name="data_inicio" value="{{ $data_inicio }}">
        <input type="hidden" name="data_fim" value="{{ $data_fim }}">
        <input type="hidden" name="total" value="{{ $total }}">
        <input type="hidden" name="local_retirada" value="{{ $local_retirada }}">
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">Confirmar e pagar com PayPal</button>
    </form>
    <a href="{{ url()->previous() }}" class="inline-block mt-4 bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 px-4 rounded">Voltar</a>
</div>
@endsection
