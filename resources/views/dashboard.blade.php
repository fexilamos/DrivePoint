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
            <div>
              <div class="font-semibold text-gray-800">{{ $carro->marca->nome ?? '' }} {{ $carro->modelo }} ({{ $carro->ano }})</div>
              <div class="text-sm text-gray-600">Cor: {{ $carro->cor }} | Combustível: {{ ucfirst($carro->combustivel) }} | Transmissão: {{ ucfirst($carro->transmissao) }}</div>
              <div class="text-sm text-gray-600">Local de levantamento: <span class="font-semibold">{{ $carro->local_levantamento ?? '-' }}</span></div>
              <div class="text-red-700 font-bold mt-1">{{ number_format($carro->preco_diario ?? $carro->preco_dia, 2) }} €/dia</div>
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
          <li class="py-3 flex flex-col">
            <span class="font-semibold text-gray-800">{{ $reserva->bemLocavel->marca->nome ?? '' }} {{ $reserva->bemLocavel->modelo ?? '' }}</span>
            <span class="text-sm text-gray-600">{{ $reserva->data_inicio }} a {{ $reserva->data_fim }}</span>
            <span class="text-sm">Total: <span class="font-bold">{{ number_format($reserva->preco_total, 2) }} €</span> | Estado: <span class="capitalize">{{ $reserva->status ?? 'ativa' }}</span></span>
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
<a :href="card.link" target="_blank" class="px-6 py-2 bg-red-100 text-red-700 border border-red-300 rounded-lg hover:bg-red-700 hover:text-white transition">Vamos viajar!</a>
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

  {{-- <div x-data="locationFilter()" class="bg-white shadow rounded p-6 max-w-3xl mx-auto">
    <h2 class="text-xl font-semibold mb-4">Pesquisar Carros Disponíveis</h2>
    <form method="GET" action="{{ route('dashboard') }}" class="space-y-6" @submit="if(!selectedCidade || !selectedFilial) { alert('Por favor, selecione cidade e filial.'); $event.preventDefault(); }">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
          <label for="cidade" class="block text-gray-700 font-semibold mb-1">Cidade</label>
          <select name="cidade" id="cidade" x-model="selectedCidade" required
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" @change="selectedFilial = ''">
            <option value="" disabled>Selecione a cidade</option>
            <template x-for="cidade in uniqueCidades()" :key="cidade">
              <option :value="cidade" x-text="cidade" :selected="cidade === '{{ $selectedCidade }}'"></option>
            </template>
          </select>
        </div>
        <div>
          <label for="filial" class="block text-gray-700 font-semibold mb-1">Filial</label>
          <select name="filial" id="filial" x-model="selectedFilial" required
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" :disabled="!selectedCidade">
            <option value="" disabled>Selecione a filial</option>
            <template x-for="filial in filteredFiliais()" :key="filial">
              <option :value="filial" x-text="filial" :selected="filial === '{{ $selectedFilial }}'"></option>
            </template>
          </select>
        </div>
        <div>
          <label for="data_inicio" class="block text-gray-700 font-semibold mb-1">Data de Início</label>
          <input type="date" name="data_inicio" id="data_inicio" required value="{{ old('data_inicio', $dataInicio) }}"
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>
        <div>
          <label for="data_fim" class="block text-gray-700 font-semibold mb-1">Data de Fim</label>
          <input type="date" name="data_fim" id="data_fim" required value="{{ old('data_fim', $dataFim) }}"
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>
      </div>
      <div>
        <button type="submit"
          class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded">Pesquisar</button>
      </div>
    </form>

    @if ($availableCars->isNotEmpty())
      <div class="mt-8">
        <h3 class="text-lg font-semibold mb-4">Carros Disponíveis</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          @foreach ($availableCars as $carro)
            <div class="border rounded shadow p-4">
              <h4 class="font-semibold text-lg mb-2">{{ $carro->marca->nome ?? '' }} {{ $carro->modelo }} ({{ $carro->ano }})</h4>
              <p class="mb-1">Cor: {{ $carro->cor }}</p>
              <p class="mb-1">Preço Diário: €{{ number_format($carro->preco_diario ?? $carro->preco_dia, 2) }}</p>
              <p class="mb-1">Combustível: {{ ucfirst($carro->combustivel) }}</p>
              <p class="mb-1">Transmissão: {{ ucfirst($carro->transmissao) }}</p>
              <a href="{{ route('carros.show', $carro) }}"
                class="inline-block mt-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-1 px-4 rounded">Ver Detalhes</a>
            </div>
          @endforeach
        </div>
      </div>
    @elseif($selectedCidade && $selectedFilial && $dataInicio && $dataFim)
      <p class="mt-8 text-red-600 font-semibold">Nenhum carro disponível para os critérios selecionados.</p>
    @endif
  </div>

  <script>
    function locationFilter() {
      return {
        selectedCidade: '{{ $selectedCidade ?? '' }}',
        selectedFilial: '{{ $selectedFilial ?? '' }}',
        locations: @json($locations),
        uniqueCidades() {
          const cidades = this.locations.map(loc => loc.cidade);
          return [...new Set(cidades)];
        },
        filteredFiliais() {
          if (!this.selectedCidade) return [];
          const filiais = this.locations
            .filter(loc => loc.cidade === this.selectedCidade)
            .map(loc => loc.filial);
          return [...new Set(filiais)];
        }
      }
    }
  </script> --}}
@endsection
