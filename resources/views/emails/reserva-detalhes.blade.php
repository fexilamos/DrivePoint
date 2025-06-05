<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Detalhes da sua Reserva</title>
</head>
<body style="background: #f3f4f6; margin:0; padding:0; font-family: 'Segoe UI', Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background: #f3f4f6; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="480" cellpadding="0" cellspacing="0" style="background: #fff; border-radius: 12px; box-shadow: 0 2px 8px #e5e7eb; padding: 32px;">
                    <tr>
                        <td align="center" style="padding-bottom: 24px;">
                            <h2 style="color: #b91c1c; font-size: 28px; margin: 0 0 8px 0; font-weight: bold;">Detalhes da sua Reserva</h2>
                            <div style="height: 3px; width: 60px; background: #b91c1c; border-radius: 2px; margin: 0 auto 16px auto;"></div>
                        </td>
                    </tr>
                    <tr>
                        <td style="color: #1f2937; font-size: 16px;">
                            <p style="margin: 0 0 12px 0;"><strong style="color:#b91c1c;">Reserva Nº:</strong> {{ $reserva->id }}</p>
                            <p style="margin: 0 0 12px 0;"><strong style="color:#b91c1c;">Carro:</strong> {{ $reserva->bemLocavel->marca->nome ?? '' }} {{ $reserva->bemLocavel->modelo ?? '' }}</p>
                            <p style="margin: 0 0 12px 0;"><strong style="color:#b91c1c;">Matrícula:</strong> {{ $reserva->bemLocavel->registo_unico_publico ?? $reserva->bemLocavel->matricula ?? '-' }}</p>
                            <p style="margin: 0 0 12px 0;"><strong style="color:#b91c1c;">Data de Início:</strong> {{ $reserva->data_inicio }}</p>
                            <p style="margin: 0 0 12px 0;"><strong style="color:#b91c1c;">Data de Fim:</strong> {{ $reserva->data_fim }}</p>
                            <p style="margin: 0 0 12px 0;"><strong style="color:#b91c1c;">Duração:</strong> {{ $dias }} dia(s)</p>
                            <p style="margin: 0 0 12px 0;"><strong style="color:#b91c1c;">Local de Levantamento:</strong> {{ $reserva->local_retirada }}</p>
                            <p style="margin: 0 0 12px 0;"><strong style="color:#b91c1c;">Preço Total:</strong> <span style="color:#047857; font-weight:bold;">{{ number_format($reserva->preco_total, 2) }} €</span></p>
                            <p style="margin: 0 0 12px 0;"><strong style="color:#b91c1c;">Estado:</strong> {{ ucfirst($reserva->status) }}</p>
                        </td>

                    </tr>
                    <tr>
                        <td align="center" style="padding-top: 24px;">
                            <span style="display:inline-block; background: #b91c1c; color: #fff; font-weight: bold; padding: 10px 32px; border-radius: 6px; font-size: 18px; letter-spacing: 1px;">Obrigado por reservar connosco!</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
