<!DOCTYPE html>
<html>
<head>
    <title>PayPal Checkout - Laravel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 40px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            color: white;
        }

        .alert-success {
            background-color: #4CAF50;
        }

        .alert-error {
            background-color: #f44336;
        }

        button {
            padding: 12px 20px;
            background-color: #0070ba;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #005c99;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Iniciar Pagamento com PayPal</h2>

        {{-- Mensagens de Sucesso / Erro --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('transaction.process') }}" method="GET">
            <button type="submit">Pagar com PayPal</button>
        </form>
    </div>
</body>
</html>

    <!-- SDK do PayPal com sua Client ID e moeda EUR -->
<script
    src="https://www.sandbox.paypal.com/sdk/js?client-id={{ config('paypal.sandbox.client_id') }}&currency=EUR&intent=capture">
</script>
