@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Adicionar Novo Carro</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('carros.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="marca" class="form-label">Marca</label>
            <input type="text" name="marca" class="form-control" value="{{ old('marca') }}" required>
        </div>

        <div class="mb-3">
            <label for="modelo" class="form-label">Modelo</label>
            <input type="text" name="modelo" class="form-control" value="{{ old('modelo') }}" required>
        </div>

        <div class="mb-3">
            <label for="ano" class="form-label">Ano</label>
            <input type="number" name="ano" class="form-control" value="{{ old('ano') }}" required>
        </div>

        <div class="mb-3">
            <label for="matricula" class="form-label">Matrícula</label>
            <input type="text" name="matricula" class="form-control" value="{{ old('matricula') }}" required>
        </div>

        <div class="mb-3">
            <label for="preco_dia" class="form-label">Preço por Dia (€)</label>
            <input type="number" step="0.01" name="preco_dia" class="form-control" value="{{ old('preco_dia') }}" required>
        </div>

        <div class="mb-3">
            <label for="imagem" class="form-label">Imagem do Carro</label>
            <input type="file" name="imagem" class="form-control">
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="disponivel" class="form-check-input" id="disponivel" checked>
            <label class="form-check-label" for="disponivel">Disponível</label>
        </div>

        <button type="submit" class="btn btn-success">Guardar Carro</button>
        <a href="{{ route('carros.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
