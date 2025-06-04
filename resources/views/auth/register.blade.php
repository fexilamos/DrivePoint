<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registar</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        @keyframes kenburns {
            0% { transform: scale(1) translate(0, 0); }
            100% { transform: scale(1.2) translate(-5%, -5%); }
        }
        .kenburns-bg {
            animation: kenburns 20s ease-in-out infinite alternate;
        }
    </style>
</head>
<body class="relative min-h-screen flex items-center justify-center overflow-hidden text-gray-900">
    <!-- Fundo com efeito Ken Burns -->
    <div class="absolute inset-0 z-0 bg-cover bg-center kenburns-bg" style="background-image: url('/images/background.svg');"></div>
    <!-- Formulário de registo -->
    <div class="relative z-10 bg-white shadow rounded-lg p-8 w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6 text-red-600">Criar Conta</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-input-label for="nif" :value="__('NIF')" />
                <x-text-input id="nif" class="block mt-1 w-full" type="text" name="nif" :value="old('nif')" required />
                <x-input-error :messages="$errors->get('nif')" class="mt-2" />
            </div>
            <div class="flex items-center justify-between mt-6">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" href="{{ route('login') }}">
                    {{ __('Já tem conta?') }}
                </a>
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-6 rounded transition">Registar</button>
            </div>
        </form>
    </div>
</body>
</html>
