@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')


  <div x-data="locationFilter()" class="bg-white shadow rounded p-6 max-w-3xl mx-auto">
    <h2 class="text-xl font-semibold mb-4">Pesquisar Carros Disponíveis</h2>
    <form method="GET" action="{{ route('reservas') }}" class="space-y-6">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="flex flex-col md:flex-row md:space-x-6">
          <div class="flex-1 mb-4 md:mb-0">
            <label for="cidade" class="block text-gray-700 font-semibold mb-1">Cidade</label>
            <select name="cidade" id="cidade" x-model="selectedCidade" required
              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" @change="selectedFilial = ''">
              <option value="" disabled>Selecione a cidade</option>
              <template x-for="cidade in uniqueCidades()" :key="cidade">
                <option :value="cidade" x-text="cidade" :selected="cidade === '{{ $selectedCidade }}'"></option>
              </template>
            </select>
          </div>
          <div class="flex-1">
            <label for="filial" class="block text-gray-700 font-semibold mb-1">Filial</label>
            <select name="filial" id="filial" x-model="selectedFilial" required
              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" :disabled="!selectedCidade">
              <option value="" disabled>Selecione a filial</option>
              <template x-for="filial in filteredFiliais()" :key="filial">
                <option :value="filial" x-text="filial" :selected="filial === '{{ $selectedFilial }}'"></option>
              </template>
            </select>
          </div>
        </div>
        <div class="flex flex-col md:flex-row md:space-x-6">
          <div class="flex-1 mb-4 md:mb-0">
            <label for="data_inicio" class="block text-gray-700 font-semibold mb-1">Data de Início</label>
            <input type="date" name="data_inicio" id="data_inicio" required value="{{ old('data_inicio', $dataInicio) }}"
              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" />
          </div>
          <div class="flex-1">
            <label for="data_fim" class="block text-gray-700 font-semibold mb-1">Data de Fim</label>
            <input type="date" name="data_fim" id="data_fim" required value="{{ old('data_fim', $dataFim) }}"
              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" />
          </div>
        </div>
      </div>
      <div>
        <button type="submit"
          class="bg-white hover:bg-red-100 text-red-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Pesquisar</button>
      </div>
    </form>

    @if ($availableCars->isNotEmpty())
      <div class="mt-8">
        <h3 class="text-lg font-semibold mb-4">Carros Disponíveis</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
         @foreach ($availableCars as $carro)
  <div class="border rounded shadow p-4 flex flex-col h-full">
    <img src="{{ asset('images/' . $carro->imagem) }}"
         alt="Imagem do {{ $carro->modelo }}"
         class="mb-3 w-full h-40 md:h-32 lg:h-32 xl:h-32 object-cover object-center rounded aspect-[16/9]">

    <h4 class="font-semibold text-lg mb-2">{{ $carro->marca->nome ?? '' }} {{ $carro->modelo }} ({{ $carro->ano }})</h4>
    <p class="mb-1">Cor: {{ $carro->cor }}</p>
    <p class="mb-1">Preço Diário: €{{ number_format($carro->preco_diario, 2) }}</p>
    <p class="mb-1">Combustível: {{ ucfirst($carro->combustivel) }}</p>
    <p class="mb-1">Transmissão: {{ ucfirst($carro->transmissao) }}</p>
    <a href="{{ route('carros.show', $carro) }}?data_inicio={{ request('data_inicio') }}&data_fim={{ request('data_fim') }}"
   class="bg-white hover:bg-red-100 text-red-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
   Ver Detalhes
</a>

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
  </script>
@endsection
