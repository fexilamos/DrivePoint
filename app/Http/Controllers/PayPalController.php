<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\PayPalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PayPalController extends Controller
{
    protected $payPalService;

    public function __construct(PayPalService $payPalService)
    {
        $this->payPalService = $payPalService;
    }

    /**
     * Mostra a página de transação
     */
    public function createTransaction(Request $request)
    {
        if ($request->has(['carro_id', 'data_inicio', 'data_fim', 'local_retirada'])) {
            // Validação dos dados
            $request->validate([
                'carro_id' => 'required|exists:bens_locaveis,id',
                'data_inicio' => 'required|date',
                'data_fim' => 'required|date|after_or_equal:data_inicio',
                'local_retirada' => 'required|string',
            ]);

            $carro = \App\Models\BemLocavel::find($request->input('carro_id'));
            $data_inicio = $request->input('data_inicio');
            $data_fim = $request->input('data_fim');
            $local_retirada = $request->input('local_retirada');
            $dias = \Carbon\Carbon::parse($data_inicio)->diffInDays(\Carbon\Carbon::parse($data_fim));
            $preco_dia = $carro->preco_diario ?? $carro->preco_dia ?? 0;
            $total = $dias > 0 ? $dias * $preco_dia : 0;

            session([
                'reserva' => [
                    'carro_id' => $carro->id,
                    'data_inicio' => $data_inicio,
                    'data_fim' => $data_fim,
                    'total' => $total,
                    'local_retirada' => $local_retirada,
                    'user_id' => Auth::id(),
                ]
            ]);

            return view('reservas.confirmar', compact('carro', 'data_inicio', 'data_fim', 'local_retirada', 'total', 'dias'));
        }

        return view('transaction');
    }

    /**
     * Processa a transação
     */
    public function processTransaction(Request $request)
    {
        $request->validate([
            'carro_id' => 'required|exists:bens_locaveis,id',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'local_retirada' => 'required|string',
            'total' => 'required|numeric|min:0.01',
        ]);

        $reserva = [
            'carro_id' => $request->input('carro_id'),
            'data_inicio' => $request->input('data_inicio'),
            'data_fim' => $request->input('data_fim'),
            'local_retirada' => $request->input('local_retirada'),
            'total' => $request->input('total'),
            'user_id' => Auth::id(),
        ];

        session(['reserva' => $reserva]);

        $amount = $reserva['total'];
        $response = $this->payPalService->createOrder(
            route('transaction.success'),
            route('transaction.cancel'),
            $amount,
            'EUR'
        );

        if (isset($response['id']) && $response['id'] !== null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
            logger()->error('Erro ao processar a transação - Links não encontrados ou formato inesperado', ['response' => $response]);
            return redirect()->route('transaction.create')->with('error', 'Algo deu errado.');
        }

        logger()->error('Erro na criação da ordem de pagamento', ['response' => $response]);
        return redirect()->route('transaction.create')->with('error', $response['message'] ?? 'Algo deu errado.');
    }

    /**
     * Sucesso da transação
     */
    public function successTransaction(Request $request)
    {
        $token = $request->input('token');

        if (!$token) {
            return redirect()->route('transaction.cancel')->with('error', 'Token do PayPal não encontrado.');
        }

        $response = $this->payPalService->capturePaymentOrder($token);

        $name_amount = $this->payPalService->payerNameAndAmout($response);
        $payerName = $name_amount['payerName'] ?? 'Desconhecido';
        $amount = $name_amount['amount'] ?? '0.00';

        if (($response['status'] ?? '') === 'COMPLETED') {
            $reserva = session('reserva');
            // Validação reforçada dos campos obrigatórios
            $camposObrigatorios = ['carro_id', 'data_inicio', 'data_fim', 'user_id', 'local_retirada', 'total'];
            $faltamCampos = collect($camposObrigatorios)->filter(fn($campo) => empty($reserva[$campo] ?? null));
            if ($faltamCampos->isNotEmpty()) {
                Log::error('Reserva não criada após pagamento: campos em falta', ['faltam' => $faltamCampos, 'reserva' => $reserva]);
                return redirect()->route('transaction.create')->with('error', 'Não foi possível concluir a reserva. Por favor, tente novamente.');
            }
            \App\Models\Reserva::create([
                'user_id' => $reserva['user_id'],
                'bem_locavel_id' => $reserva['carro_id'],
                'data_inicio' => $reserva['data_inicio'],
                'data_fim' => $reserva['data_fim'],
                'preco_total' => $reserva['total'],
                'status' => 'reservado',
                'local_retirada' => $reserva['local_retirada'],
            ]);
            session()->forget('reserva');

            return redirect()->route('transaction.finish', [
                'amount' => $amount,
                'payer' => $payerName,
            ]);
        }

        return redirect()->route('transaction.create')->with('error', $response['message'] ?? 'Algo deu errado.');
    }

    /**
     * Cancelamento da transação
     */
    public function cancelTransaction(Request $request)
    {
        return redirect()->route('transaction.create')->with('error', 'O utilizador cancelou a operação.');
    }

    /**
     * Conclusão da transação
     */
    public function finishTransaction(Request $request)
    {
        $amount = $request->query('amount') ?? '0.00';
        $payerName = $request->query('payer') ?? 'Desconhecido';
        $success = 'Pagamento e reserva realizados com sucesso!';
        return view('finish-transaction', compact('amount', 'payerName', 'success'));
    }
}
