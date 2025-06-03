<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\PayPalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayPalController extends Controller
{
    protected $payPalService;


    public function __construct(PayPalService $payPalService)
    {
        $this->payPalService = $payPalService;
    }

    /**
     * Mostra a página de transaction
     *
     * @return \Illuminate\Http\Response
     */
    public function createTransaction(Request $request)
    {
        // Se vierem dados de reserva, mostrar página de confirmação
        if ($request->has(['carro_id', 'data_inicio', 'data_fim', 'local_retirada'])) {
            $carro = \App\Models\BemLocavel::find($request->input('carro_id'));
            $data_inicio = $request->input('data_inicio');
            $data_fim = $request->input('data_fim');
            $local_retirada = $request->input('local_retirada');
            $total = $request->input('total');
            $dias = \Carbon\Carbon::parse($data_inicio)->diffInDays(\Carbon\Carbon::parse($data_fim));
            return view('reservas.confirmar', compact('carro', 'data_inicio', 'data_fim', 'local_retirada', 'total', 'dias'));
        }
        // Se vierem dados de reserva, guardar na sessão
        if ($request->has(['carro_id', 'data_inicio', 'data_fim'])) {
            session([
                'reserva' => [
                    'carro_id' => $request->input('carro_id'),
                    'data_inicio' => $request->input('data_inicio'),
                    'data_fim' => $request->input('data_fim'),
                    'total' => $request->input('total'),
                    'user_id' => Auth::id(),
                ]
            ]);
        }
        return view('transaction');
    }

    /**
     * Processa a transação
     *
     * @return \Illuminate\Http\Response
     */
    public function processTransaction(Request $request)
    {
        // Recebe dados do form de confirmação
        $reserva = [
            'carro_id' => $request->input('carro_id'),
            'data_inicio' => $request->input('data_inicio'),
            'data_fim' => $request->input('data_fim'),
            'total' => $request->input('total'),
            'local_retirada' => $request->input('local_retirada'),
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
        ];
        session(['reserva' => $reserva]);
        $amount = $reserva['total'] ?? 1.00;
        $response = $this->payPalService->createOrder(
            route('transaction.success'),
            route('transaction.cancel'),
            $amount,
            'EUR'
        );
        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] == 'approve') {
                    return redirect()->away($link['href']);
                }
            }
            logger()->error('Erro ao processar a transação - Links não encontrados ou formato inesperado', ['response' => $response]);
            return redirect()->route('transaction.create')->with('error', 'Algo deu errado.');
        } else {
            logger()->error('Erro na criação da ordem de pagamento', ['response' => $response]);
            return redirect()->route('transaction.create')->with('error', $response['message'] ?? 'Algo deu errado.');
        }
    }
    /**
     * Sucesso da transação.
     *
     * @return \Illuminate\Http\Response
     */
    public function successTransaction(Request $request)
    {

        $token = $request->input('token');
        // Alternativa a linha 63 seria acessar a query string
        //$token = $request['token'];
        if (!$token) {
            return redirect()->route('transaction.cancel')->with('error', 'Token do PayPal não encontrado.');
        }

        $response = $this->payPalService->capturePaymentOrder($token);

        $name_amount = $this->payPalService->payerNameAndAmout($response);
        $payerName = $name_amount['payerName'] ?? 'Unknown Payer';
        $amount = $name_amount['amount'] ?? 'Unknown Amount';

        // Verifica se o pagamento foi completado
        if ($response['status'] ?? '' === 'COMPLETED') {
            // Criar reserva após pagamento
            $reserva = session('reserva');
            if ($reserva && isset($reserva['carro_id'], $reserva['data_inicio'], $reserva['data_fim'], $reserva['user_id'], $reserva['local_retirada'])) {
                \App\Models\Reserva::create([
                    'user_id' => $reserva['user_id'],
                    'bem_locavel_id' => $reserva['carro_id'],
                    'data_inicio' => $reserva['data_inicio'],
                    'data_fim' => $reserva['data_fim'],
                    'preco_total' => $amount,
                    'status' => 'reservado',
                    'local_retirada' => $reserva['local_retirada'],
                ]);
                session()->forget('reserva');
            }
            return redirect()->route('transaction.finish', [
                'amount' => $amount,
                'payer' => $payerName,
            ]);
        } else {
            //diferente de withError que usamos no Recaptcha: $message só existe automaticamente dentro de @error().
            //Para mensagens comuns com with(), você acessa com session('chave'); adicionamos uma mensagem simples à sessão, com a chave 'error'
            return redirect()->route('transaction.create')->with('error', $response['message'] ?? 'Algo deu errado.');
        }
    }

    /**
     * cancela a transação.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelTransaction(Request $request)
    {
        return redirect()
            ->route('transaction.create')
            ->with('error', 'O utilizador cancelou a operação.');
    }

    public function finishTransaction(Request $request)
    {
        $amount = $request->query('amount');
        $payerName = $request->query('payer');
        // Mensagem de sucesso para o utilizador
        $success = 'Pagamento e reserva realizados com sucesso!';
        return view('finish-transaction', compact('amount', 'payerName', 'success'));
    }

}
