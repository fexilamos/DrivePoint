@extends('layouts.dashboard')

@section('title', 'Perfil')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6">Gestão de Reservas</h1>

    {{-- Listagem das reservas do utilizador --}}
    <div class="bg-white shadow rounded-lg p-6 mb-8">
        <h2 class="text-xl font-bold mb-4">Minhas Reservas</h2>
        @if($reservas->isEmpty())
            <p class="text-gray-600">Ainda não tem reservas.</p>
        @else
        <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded shadow">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b text-left">Carro</th>
                    <th class="py-2 px-4 border-b text-left">Data Início</th>
                    <th class="py-2 px-4 border-b text-left">Data Fim</th>
                    <th class="py-2 px-4 border-b text-left">Preço Total</th>
                    <th class="py-2 px-4 border-b text-left">Estado</th>
                    <th class="py-2 px-4 border-b text-left">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservas as $reserva)
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border-b">{{ $reserva->bemLocavel->marca->nome ?? '' }} {{ $reserva->bemLocavel->modelo ?? '' }}</td>
                    <td class="py-2 px-4 border-b">{{ $reserva->data_inicio }}</td>
                    <td class="py-2 px-4 border-b">{{ $reserva->data_fim }}</td>
                    <td class="py-2 px-4 border-b">{{ number_format($reserva->preco_total, 2) }} €</td>
                    <td class="py-2 px-4 border-b">{{ ucfirst($reserva->status ?? 'ativa') }}</td>
                    <td class="py-2 px-4 border-b">
                        <form action="{{ route('reservas.pdf', $reserva->id) }}" method="GET" target="_blank">
                            <button type="submit" class="bg-gray-700 hover:bg-gray-900 text-white px-3 py-1 rounded text-sm">Imprimir PDF</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        @endif
    </div>

    {{-- Formulário de edição de dados do utilizador --}}
    {{-- <div class="bg-white shadow rounded-lg p-6">
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-semibold mb-1">Nome</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded">Guardar</button>
            </div> --}}
        </form>
    </div>
</div>
@endsection
