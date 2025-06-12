@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')


  @if(isset($randomCars) && $randomCars->count())
  <div class="max-w-6xl mx-auto mt-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Card Veículos Aleatórios -->
      <div class="bg-white shadow-lg rounded-lg p-6 flex flex-col">
        <h2 class="text-xl font-bold mb-4 text-red-700">Sugestão de Viaturas</h2>
        <div class="grid grid-cols-1 gap-4">
          @foreach($randomCars as $carro)
          <div class="flex items-center space-x-4 border-b pb-3 last:border-b-0">
            <img src="{{ asset('images/' . $carro->imagem) }}" alt="{{ $carro->modelo }}" class="w-24 h-16 object-cover rounded border">
            <div class="flex-1 flex flex-col">
              <div class="font-semibold text-gray-800">{{ $carro->marca->nome ?? '' }} {{ $carro->modelo }} ({{ $carro->ano }})</div>
              <div class="text-sm text-gray-600">Cor: {{ $carro->cor }} | Combustível: {{ ucfirst($carro->combustivel) }} | Transmissão: {{ ucfirst($carro->transmissao) }}</div>
              <div class="text-sm text-gray-600">Local de levantamento: <span class="font-semibold">{{ $carro->local_levantamento ?? '-' }}</span></div>
              <div class="flex items-center mt-1">
                <span class="text-red-700 font-bold mr-3">{{ number_format($carro->preco_diario ?? $carro->preco_dia, 2) }} €/dia</span>
                <a href="{{ route('carros.show', $carro) }}" class="bg-white hover:bg-red-100 text-red-800 font-semibold py-1 px-4 border border-gray-400 rounded shadow">Reservar</a>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      <!-- Card Minhas Reservas -->
      <div class="bg-white shadow-lg rounded-lg p-6 flex flex-col">
        <h2 class="text-xl font-bold mb-4 text-red-700">Minhas Reservas</h2>
        @if(isset($userReservations) && $userReservations->count())
        <ul class="divide-y">
          @foreach($userReservations as $reserva)
          <li class="py-3 flex flex-col md:flex-row md:items-center md:justify-between gap-2">
            <div>
              <span class="font-semibold text-gray-800">{{ $reserva->bemLocavel->marca->nome ?? '' }} {{ $reserva->bemLocavel->modelo ?? '' }}</span>
              <span class="text-sm text-gray-600 block md:inline">{{ $reserva->data_inicio }} a {{ $reserva->data_fim }}</span>
              <span class="text-sm block md:inline">Total: <span class="font-bold">{{ number_format($reserva->preco_total, 2) }} €</span> | Estado: <span class="capitalize">{{ $reserva->status ?? 'ativa' }}</span></span>
            </div>
            <a href="{{ route('reservas.show', $reserva) }}" class="bg-white hover:bg-red-100 text-red-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Ver Detalhes</a>
          </li>
          @endforeach
        </ul>
        @else
        <span class="text-gray-500">Ainda não tem reservas.</span>
        @endif
      </div>
    </div>
  </div>
  @endif

  @if(isset($cardsTurismo) && count($cardsTurismo) > 0)
    <div class="max-w-6xl mx-auto mb-8">
      <div x-data="{ idx: 0, total: {{ count($cardsTurismo) }} }" class="bg-white shadow-lg rounded-lg overflow-hidden flex flex-col md:flex-row relative">
        <button @click="idx = idx === 0 ? total-1 : idx-1" class="absolute left-2 top-1/2 -translate-y-1/2 bg-gray-200 hover:bg-gray-300 rounded-full p-2 z-10">
          <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
        </button>
        <template x-for="(card, i) in $store.cardsTurismo" :key="i">
          <div x-show="i === idx" class="flex flex-col md:flex-row w-full">
            <img :src="'/images/' + card.imagem" alt="Turismo" class="w-full md:w-96 h-64 object-cover">
            <div class="p-8 flex-1 flex flex-col justify-between">
              <div>
                <h3 class="text-2xl font-bold mb-4 text-red-700" x-text="card.titulo"></h3>
                <p class="text-gray-700 text-lg" x-text="card.descricao"></p>
              </div>
              <div class="mt-6 flex justify-end">
<a :href="card.link" target="_blank" class="bg-white hover:bg-red-100 text-red-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Vamos viajar!</a>
              </div>
            </div>
          </div>
        </template>
        <button @click="idx = idx === total-1 ? 0 : idx+1" class="absolute right-2 top-1/2 -translate-y-1/2 bg-gray-200 hover:bg-gray-300 rounded-full p-2 z-10">
          <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        </button>
      </div>
      <script>
        document.addEventListener('alpine:init', () => {
          Alpine.store('cardsTurismo', @json($cardsTurismo));
        });
      </script>
    </div>
  @endif


@endsection
