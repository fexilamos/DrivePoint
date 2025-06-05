@extends('layouts.dashboard')
@section('title', 'Confirmação da Reserva')
@section('content')
<div class="container mx-auto px-4 py-6 max-w-lg">
    <h1 class="text-2xl font-bold mb-6">Confirme os dados da sua reserva</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $erro)
                    <li class="font-semibold">{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white shadow rounded p-6 mb-4">
        <p><strong>Carro:</strong> {{ $carro->marca->nome ?? '' }} {{ $carro->modelo }} ({{ $carro->ano }})</p>
        <p><strong>Data de Início:</strong> {{ $data_inicio }}</p>
        <p><strong>Data de Fim:</strong> {{ $data_fim }}</p>
        <p><strong>Número de dias:</strong> {{ $dias }}</p>
        <p><strong>Valor a pagar:</strong> €{{ number_format($total, 2) }}</p>
        <p><strong>Local de levantamento:</strong> {{ $local_retirada }}</p>
    </div>
    <form action="{{ route('reservas.confirmar') }}" method="POST" id="form-confirmar-reserva">
        @csrf
        <input type="hidden" name="carro_id" value="{{ $carro->id }}">
        <input type="hidden" name="data_inicio" value="{{ $data_inicio }}">
        <input type="hidden" name="data_fim" value="{{ $data_fim }}">
        <input type="hidden" name="total" value="{{ $total }}">
        <input type="hidden" name="local_retirada" value="{{ $local_retirada }}">
        <div class="flex flex-col items-center justify-center mt-4">
            <div id="recaptcha-container">
                <div class="g-recaptcha" data-sitekey="{{ config('services.google.recaptcha_site_key') }}" data-callback="onRecaptchaSuccess"></div>
            </div>
            @error('captcha')
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mt-2 text-sm flex items-center" role="alert">
                    <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M10 15a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm0-11a1.5 1.5 0 00-1.5 1.5v5a1.5 1.5 0 003 0v-5A1.5 1.5 0 0010 4z" />
                    </svg>
                    <span>{{ $message }}</span>
                </div>
            @enderror
        </div>
        <button type="submit" id="btn-confirmar" class="bg-white hover:bg-red-100 text-red-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow mt-4" style="display:none;">Confirmar</button>
        <a href="{{ url()->previous() }}" class="inline-block mt-4 bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 px-4 rounded">Voltar</a>
    </form>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        function onRecaptchaSuccess() {
            document.getElementById('btn-confirmar').style.display = 'inline-block';
        }
        window.onload = function() {
            // Se o utilizador voltar atrás e o captcha já estiver preenchido, mostrar o botão
            var recaptchaResponse = document.querySelector('.g-recaptcha-response');
            if (recaptchaResponse && recaptchaResponse.value) {
                document.getElementById('btn-confirmar').style.display = 'inline-block';
            }
        }
    </script>
</div>
@endsection
