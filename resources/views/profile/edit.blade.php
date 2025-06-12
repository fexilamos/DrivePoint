@extends('layouts.dashboard')

@section('title', 'Perfil')

@section('content')
<div class="max-w-6xl mx-auto py-8">

    <div class="bg-white shadow rounded-lg p-6 max-w-lg mx-auto mb-8">
        <h2 class="text-xl font-bold mb-4">Editar Perfil</h2>
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
                <button type="submit" class="bg-white hover:bg-red-100 text-red-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Guardar</button>
            </div>
            @if(session('status') === 'profile-updated')
                <div class="mt-4 p-2 bg-green-100 text-green-800 rounded">Perfil atualizado com sucesso!</div>
            @endif
            @if($errors->any())
                <div class="mt-4 p-2 bg-red-100 text-red-800 rounded">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
        </form>
    </div>

    <h1 class="text-3xl font-bold mb-6">Gestão de Reservas</h1>

    <div class="bg-white shadow rounded-lg p-6 mb-8">
        <h2 class="text-xl font-bold mb-4">As Minhas Reservas</h2>
        @if($reservas->isEmpty())
            <p class="text-gray-600">Ainda não tem reservas.</p>
        @else
        <div class="overflow-x-auto">
        <table class="w-full min-w-[900px] bg-white border border-gray-200 rounded shadow">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b text-left whitespace-nowrap">ID</th>
                    <th class="py-2 px-4 border-b text-left whitespace-nowrap">Carro</th>
                    <th class="py-2 px-4 border-b text-left whitespace-nowrap">Data Início</th>
                    <th class="py-2 px-4 border-b text-left whitespace-nowrap">Data Fim</th>
                    <th class="py-2 px-4 border-b text-left whitespace-nowrap">Preço Total</th>
                    <th class="py-2 px-4 border-b text-left whitespace-nowrap">Estado</th>
                    <th class="py-2 px-4 border-b text-left whitespace-nowrap">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservas as $reserva)
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border-b whitespace-nowrap">{{ $reserva->id }}</td>
                    <td class="py-2 px-4 border-b whitespace-nowrap">{{ $reserva->bemLocavel->marca->nome ?? '' }} {{ $reserva->bemLocavel->modelo ?? '' }}</td>
                    <td class="py-2 px-4 border-b whitespace-nowrap">{{ $reserva->data_inicio }}</td>
                    <td class="py-2 px-4 border-b whitespace-nowrap">{{ $reserva->data_fim }}</td>
                    <td class="py-2 px-4 border-b whitespace-nowrap">{{ number_format($reserva->preco_total, 2) }} €</td>
                    <td class="py-2 px-4 border-b whitespace-nowrap">{{ ucfirst($reserva->status ?? 'ativa') }}</td>
                    <td class="py-2 px-4 border-b whitespace-nowrap">
                        <a href="{{ route('reservas.show', $reserva->id) }}" class="bg-white hover:bg-red-100 text-red-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Consultar Reserva</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        @endif
    </div>
</div>
@endsection
