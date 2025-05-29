@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Resultados da Pesquisa</h1>

    @if($resultados->isEmpty())
        <p>Nenhum resultado encontrado.</p>
    @else
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Modelo</th>
                    <th class="py-2 px-4 border-b">Cor</th>
                    <th class="py-2 px-4 border-b">Transmissão</th>
                    <th class="py-2 px-4 border-b">Combustível</th>
                    <th class="py-2 px-4 border-b">Ano</th>
                </tr>
            </thead>
            <tbody>
                @foreach($resultados as $bem)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $bem->modelo }}</td>
                    <td class="py-2 px-4 border-b">{{ $bem->cor }}</td>
                    <td class="py-2 px-4 border-b">{{ $bem->transmissao }}</td>
                    <td class="py-2 px-4 border-b">{{ $bem->combustivel }}</td>
                    <td class="py-2 px-4 border-b">{{ $bem->ano }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
