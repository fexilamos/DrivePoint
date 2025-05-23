@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Lista de Carros</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('carros.create') }}" class="btn btn-primary mb-3">Adicionar Carro</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Ano</th>
                <th>Matrícula</th>
                <th>Preço/dia</th>
                <th>Disponível</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($carros as $carro)
                <tr>
                    <td>{{ $carro->marca }}</td>
                    <td>{{ $carro->modelo }}</td>
                    <td>{{ $carro->ano }}</td>
                    <td>{{ $carro->matricula }}</td>
                    <td>{{ number_format($carro->preco_dia, 2) }} €</td>
                    <td>{{ $carro->disponivel ? 'Sim' : 'Não' }}</td>
                    <td>
                        <a href="{{ route('carros.show', $carro) }}" class="btn btn-info btn-sm">Ver</a>
                        <a href="{{ route('carros.edit', $carro) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('carros.destroy', $carro) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Tem a certeza que deseja eliminar este carro?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Apagar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
