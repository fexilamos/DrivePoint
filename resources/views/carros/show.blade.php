@extends('layouts.dashboard')

@section('title', 'Detalhes do Carro')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-lg">
    <h1 class="text-3xl font-bold mb-6">Detalhes do Carro</h1>

    <div class="bg-white shadow rounded p-6">
        <h2 class="text-xl font-semibold mb-2">{{ $carro->marca->nome ?? '' }} {{ $carro->modelo }} ({{ $carro->ano }})</h2>
        <p class="mb-1"><strong>Matrícula:</strong> {{ $carro->registo_unico_publico ?? $carro->matricula ?? '-' }}</p>
       <p class="mb-1"><strong>Cor:</strong> {{ $carro->cor }}</p>
       <p class="mb-1"><strong>Combustível:</strong> {{ ucfirst($carro->combustivel) }}</p>
       <p class="mb-1"><strong>Transmissão:</strong> {{ ucfirst($carro->transmissao) }}</p>
       <p class="mb-1"><strong>Localização:</strong> {{ $carro->localizacoes->first()->cidade ?? '-' }}
    @if($carro->localizacoes->first())
        @if($carro->localizacoes->first()->filial), {{ $carro->localizacoes->first()->filial }}@endif
        @if($carro->localizacoes->first()->posicao), {{ $carro->localizacoes->first()->posicao }}@endif
    @endif
</p>
        <p class="mb-1"><strong>Preço por dia:</strong> {{ number_format($carro->preco_diario ?? $carro->preco_dia, 2) }} €</p>
        @if ($data_inicio && $data_fim)
            @php
                $dias = \Carbon\Carbon::parse($data_inicio)->diffInDays(\Carbon\Carbon::parse($data_fim));
                $total = $dias > 0 ? $dias * ($carro->preco_diario ?? $carro->preco_dia) : 0;
            @endphp
            <p class="mb-1"><strong>Duração:</strong> {{ $dias }} dia(s)</p>
            <p class="mb-1"><strong>Total:</strong> €{{ number_format($total, 2) }}</p>
        @endif
        <p class="mb-4"><strong>Disponível:</strong>
            @if ($data_inicio && $data_fim)
                {{ $disponivel === null ? 'Sim' : ($disponivel ? 'Sim' : 'Não') }}
            @else
                Sim
            @endif
        </p>
        @if ($carro->imagem)
    <img src="{{ asset('images/' . $carro->imagem) }}" alt="Imagem do carro" class="rounded max-w-full h-auto mb-4" />
@endif

    </div>

    <a href="{{ route('carros.index') }}" class="inline-block mt-6 bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 px-4 rounded">Voltar</a>
@if (auth()->check())
  <form action="{{ route('reservas.confirmar') }}" method="GET" class="mt-4">
      @csrf
      <input type="hidden" name="carro_id" value="{{ $carro->id }}">
      <div class="mb-2">
          <label for="data_inicio" class="block font-semibold">Data de Início:</label>
          <input type="date" name="data_inicio" required value="{{ $data_inicio ?? '' }}" class="border px-2 py-1 rounded w-full">
      </div>
      <div class="mb-2">
          <label for="data_fim" class="block font-semibold">Data de Fim:</label>
          <input type="date" name="data_fim" required value="{{ $data_fim ?? '' }}" class="border px-2 py-1 rounded w-full">
      </div>
      <div class="mb-2">
          <label for="local_retirada" class="block font-semibold">Local de Levantamento:</label>
          <select name="local_retirada" required class="border px-2 py-1 rounded w-full">
              <option value="" disabled selected>Selecione o local</option>
              @foreach($locais as $local)
                  <option value="{{ $local }}">{{ $local }}</option>
              @endforeach
          </select>
      </div>
      @if (isset($dias) && isset($total))
        <div class="mb-2">
            <label class="block font-semibold">Total:</label>
            <span class="font-bold">€{{ number_format($total, 2) }}</span>
            <input type="hidden" name="total" value="{{ $total }}">
        </div>
      @endif
      <button type="submit"
          class="bg-white hover:bg-red-100 text-red-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
          Reservar este carro
      </button>
  </form>
@else
  <p class="mt-4 text-sm text-red-600">Precisa de estar autenticado para fazer uma reserva.</p>
@endif

@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $erro)
                <li class="font-semibold">{{ $erro }}</li>
            @endforeach
        </ul>
    </div>
@endif


</div>
@endsection
