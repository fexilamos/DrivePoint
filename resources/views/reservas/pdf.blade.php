<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Reserva #{{ $reserva->id }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #1f2937;
            margin: 30px 25px;
            position: relative;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: url('{{ public_path('images/background.jpg') }}') no-repeat center center;
            background-size: cover;
            opacity: 0.05;
            z-index: -1;
        }

        .header {
            text-align: center;
            margin-bottom: 24px;
        }

        .logo {
            height: 80px;
            margin-bottom: 6px;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            color: #b91c1c;
            margin: 0;
        }

        .section {
            margin-bottom: 18px;
            padding: 12px 16px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            background: #ffffff;
        }

        .section-title {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 8px;
            color: #111827;
        }

        .item {
            margin-bottom: 5px;
        }

        .label {
            font-weight: bold;
            color: #374151;
        }

        .vehicle-image {
            float: right;
            width: 160px;
            margin-left: 20px;
        }

        .vehicle-image img {
            width: 100%;
            height: 110px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
        }

        .footer {
            text-align: center;
            font-size: 11px;
            margin-top: 30px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/logo.png') }}" alt="Logotipo" class="logo">
        <div class="title">Comprovativo de Reserva</div>
    </div>

    <div class="section">
        <div class="section-title">Dados do Cliente</div>
        <div class="item"><span class="label">Reserva Nº:</span> {{ $reserva->id }}</div>
        <div class="item"><span class="label">Nome:</span> {{ $reserva->user->name ?? '-' }}</div>
        <div class="item"><span class="label">Email:</span> {{ $reserva->user->email ?? '-' }}</div>
    </div>

    <div class="section">
        <div class="section-title">Detalhes da Reserva</div>

        @if($reserva->bemLocavel->imagem)
            <div class="vehicle-image">
                <img src="{{ public_path('images/' . $reserva->bemLocavel->imagem) }}" alt="Imagem do Veículo">
            </div>
        @endif

        <div class="item"><span class="label">Carro:</span> {{ $reserva->bemLocavel->marca->nome ?? '' }} {{ $reserva->bemLocavel->modelo ?? '' }}</div>
        <div class="item"><span class="label">Matrícula:</span> {{ $reserva->bemLocavel->registo_unico_publico ?? $reserva->bemLocavel->matricula ?? '-' }}</div>
        <div class="item"><span class="label">Preço por Dia:</span> {{ number_format($reserva->bemLocavel->preco_diario ?? $reserva->bemLocavel->preco_dia, 2) }} €</div>
        <div class="item"><span class="label">Duração:</span> {{ $dias }} dia(s)</div>
        <div class="item"><span class="label">Data de Início:</span> {{ $reserva->data_inicio }}</div>
        <div class="item"><span class="label">Data de Fim:</span> {{ $reserva->data_fim }}</div>
        <div class="item"><span class="label">Local de Levantamento:</span> {{ $reserva->local_retirada ?? '-' }}</div>
        <div class="item"><span class="label">Preço Total:</span> {{ number_format($reserva->preco_total, 2) }} €</div>
        <div class="item"><span class="label">Estado:</span> {{ ucfirst($reserva->status) }}</div>
    </div>

    <div class="footer">
        Documento gerado automaticamente em {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
