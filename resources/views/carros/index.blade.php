@extends('layouts.dashboard')

@section('title', 'Lista de Carros')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10 bg-white/80 rounded-lg shadow-md mt-6">
    <h1 class="text-3xl font-bold mb-6">A nossa gama de carros</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif


    <form method="GET" action="{{ route('carros.index') }}" class="mb-6 flex flex-wrap gap-4 items-end bg-gray-50 p-4 rounded shadow">
        <div>
            <label for="marca" class="block text-gray-700 font-semibold mb-1">Marca</label>
            <select name="marca" id="marca" class="w-40 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                <option value="">Todas</option>
                @foreach ($marcas as $id => $nome)
                    <option value="{{ $nome }}" {{ request('marca') == $nome ? 'selected' : '' }}>{{ $nome }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="cor" class="block text-gray-700 font-semibold mb-1">Cor</label>
            <select name="cor" id="cor" class="w-32 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                <option value="">Todas</option>
                @foreach ($cores as $cor)
                    <option value="{{ $cor }}" {{ request('cor') == $cor ? 'selected' : '' }}>{{ $cor }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="combustivel" class="block text-gray-700 font-semibold mb-1">Combustível</label>
            <select name="combustivel" id="combustivel" class="w-32 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                <option value="">Todos</option>
                <option value="gasolina" {{ request('combustivel') == 'gasolina' ? 'selected' : '' }}>Gasolina</option>
                <option value="diesel" {{ request('combustivel') == 'diesel' ? 'selected' : '' }}>Diesel</option>
                <option value="elétrico" {{ request('combustivel') == 'elétrico' ? 'selected' : '' }}>Elétrico</option>
                <option value="híbrido" {{ request('combustivel') == 'híbrido' ? 'selected' : '' }}>Híbrido</option>
                <option value="outro" {{ request('combustivel') == 'outro' ? 'selected' : '' }}>Outro</option>
            </select>
        </div>
        <div>
            <label for="transmissao" class="block text-gray-700 font-semibold mb-1">Transmissão</label>
            <select name="transmissao" id="transmissao" class="w-32 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                <option value="">Todas</option>
                <option value="manual" {{ request('transmissao') == 'manual' ? 'selected' : '' }}>Manual</option>
                <option value="automática" {{ request('transmissao') == 'automática' ? 'selected' : '' }}>Automática</option>
            </select>
        </div>
        <div>
            <label for="localizacao" class="block text-gray-700 font-semibold mb-1">Localização</label>
            <select name="localizacao" id="localizacao" class="w-40 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                <option value="">Todas</option>
                @foreach ($localizacoes as $local)
                    <option value="{{ $local }}" {{ request('localizacao') == $local ? 'selected' : '' }}>{{ $local }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="preco_min" class="block text-gray-700 font-semibold mb-1">Preço Mín.</label>
            <input type="number" name="preco_min" id="preco_min" value="{{ request('preco_min') }}" class="w-24 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" min="0" step="1">
        </div>
        <div>
            <label for="preco_max" class="block text-gray-700 font-semibold mb-1">Preço Máx.</label>
            <input type="number" name="preco_max" id="preco_max" value="{{ request('preco_max') }}" class="w-24 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" min="0" step="1">
        </div>
        <div>
            <button type="submit" class="bg-white hover:bg-red-100 text-red-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Filtrar</button>
        </div>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-y-10 gap-x-10 mt-10">
    @foreach ($carros as $carro)
        <div class="flex flex-col rounded-2xl w-full bg-white text-[#374151] shadow-xl mx-auto max-w-xs md:max-w-sm xl:max-w-md">
            <figure class="flex justify-center items-center">
                <img src="{{ asset('images/' . $carro->imagem) }}" alt="Imagem do {{ $carro->modelo }}" class="rounded-t-2xl h-48 object-cover w-full">
            </figure>
            <div class="flex flex-col p-6 h-full">
                <div class="text-2xl font-bold pb-2 text-red-700">{{ $carro->marca->nome ?? '' }} {{ $carro->modelo }}</div>
                <div class="text-gray-600 text-sm pb-4 italic">{{ $carro->ano }} - {{ ucfirst($carro->combustivel) }} - {{ ucfirst($carro->transmissao) }}</div>

                <div class="flex flex-col gap-2 text-base text-gray-700">
                    <div><strong>Matrícula:</strong> {{ $carro->matricula ?? $carro->registo_unico_publico ?? '-' }}</div>
                    <div><strong>Cor:</strong> {{ $carro->cor }}</div>
                    <div><strong>Preço/dia:</strong> {{ number_format($carro->preco_diario ?? $carro->preco_dia, 2) }} €</div>
                    <div><strong>Disponível:</strong> @if (isset($carro->disponivel)){{ $carro->disponivel ? 'Sim' : 'Não' }}@else Sim @endif</div>
                </div>

                <div class="flex grow"></div>
                <div class="flex pt-6">
                    <a href="{{ route('carros.show', $carro) }}"
                        class="w-full bg-white text-red-800 font-bold text-base p-3 rounded-lg hover:bg-red-100 border border-gray-400  rounded shadow active:scale-95 transition-transform transform text-center">
                        Ver Detalhes
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
