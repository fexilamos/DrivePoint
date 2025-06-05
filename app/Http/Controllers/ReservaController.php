<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservaDetalhesMail;

class ReservaController extends Controller
{
   public function store(Request $request)
{
    $request->validate([
        'bem_locavel_id' => 'required|exists:bens_locaveis,id',
        'data_inicio' => 'required|date',
        'data_fim' => 'required|date|after:data_inicio',
        'local_retirada' => 'required|string|max:255',
    ]);

    // Verifica se já existe reserva para o mesmo carro e datas sobrepostas
    $reservaConflito = \App\Models\Reserva::where('bem_locavel_id', $request->bem_locavel_id)
        ->where(function($query) use ($request) {
            $query->whereBetween('data_inicio', [$request->data_inicio, $request->data_fim])
                  ->orWhereBetween('data_fim', [$request->data_inicio, $request->data_fim])
                  ->orWhere(function($q) use ($request) {
                      $q->where('data_inicio', '<=', $request->data_inicio)
                        ->where('data_fim', '>=', $request->data_fim);
                  });
        })
        ->first();

    if ($reservaConflito) {
        $msg = 'Este carro já está reservado para o período de ' .
            date('d/m/Y', strtotime($reservaConflito->data_inicio)) . ' a ' .
            date('d/m/Y', strtotime($reservaConflito->data_fim)) . '. Por favor, escolha outras datas.';
        return back()->withErrors(['data_inicio' => $msg])->withInput();
    }

    Reserva::create([
        'user_id' => Auth::id(),
        'bem_locavel_id' => $request->bem_locavel_id,
        'data_inicio' => $request->data_inicio,
        'data_fim' => $request->data_fim,
        'local_retirada' => $request->local_retirada,
    ]);

    return redirect()->route('dashboard')->with('success', 'Reserva realizada com sucesso!');
}

public function pdf($id)
{
    $reserva = \App\Models\Reserva::with(['bemLocavel.marca', 'user'])->findOrFail($id);
    $dias = \Carbon\Carbon::parse($reserva->data_inicio)->diffInDays(\Carbon\Carbon::parse($reserva->data_fim));
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reservas.pdf', compact('reserva', 'dias'));
    return $pdf->stream('reserva_'.$reserva->id.'.pdf');
}

public function cancelar($id)
{
    $reserva = \App\Models\Reserva::findOrFail($id);
    // Permitir apenas ao próprio utilizador cancelar a sua reserva
    if ($reserva->user_id !== Auth::id()) {
        return redirect()->back()->withErrors(['error' => 'Não tem permissão para cancelar esta reserva.']);
    }
    $reserva->status = 'cancelado';
    $reserva->save();
    return redirect()->back()->with('success', 'Reserva cancelada com sucesso!');
}

// Exibe a referência Multibanco fictícia
public function showMultibanco(Request $request)
{
    $reserva = session('reserva');
    if (!$reserva) {
        return redirect()->route('dashboard')->with('error', 'Dados da reserva não encontrados.');
    }
    // Gerar referência fictícia
    $ref = rand(100000000, 999999999);
    $reserva['ref'] = $ref;
    session(['reserva' => $reserva]);
    return view('transaction');
}

// Confirma o pagamento Multibanco (simulado)
public function confirmarPagamentoMultibanco(Request $request)
{
    $reserva = session('reserva');
    if (!$reserva) {
        return redirect()->route('dashboard')->with('error', 'Dados da reserva não encontrados.');
    }
    // Verificar conflito de datas antes de criar a reserva
    $conflito = Reserva::where('bem_locavel_id', $reserva['carro_id'])
        ->where(function($query) use ($reserva) {
            $query->whereBetween('data_inicio', [$reserva['data_inicio'], $reserva['data_fim']])
                  ->orWhereBetween('data_fim', [$reserva['data_inicio'], $reserva['data_fim']])
                  ->orWhere(function($q) use ($reserva) {
                      $q->where('data_inicio', '<=', $reserva['data_inicio'])
                        ->where('data_fim', '>=', $reserva['data_fim']);
                  });
        })
        ->where('status', '!=', 'cancelado')
        ->first();
    if ($conflito) {
        $msg = 'Este carro já está reservado para o período de ' .
            date('d/m/Y', strtotime($conflito->data_inicio)) . ' a ' .
            date('d/m/Y', strtotime($conflito->data_fim)) . '. Por favor, escolha outras datas.';
        return redirect()->route('reservas.confirmar', [
            'carro_id' => $reserva['carro_id'],
            'data_inicio' => $reserva['data_inicio'],
            'data_fim' => $reserva['data_fim'],
            'local_retirada' => $reserva['local_retirada'],
        ])->withErrors(['data_inicio' => $msg]);
    }
    // Cria a reserva como paga
    $reservaCriada = Reserva::create([
        'user_id' => $reserva['user_id'],
        'bem_locavel_id' => $reserva['carro_id'],
        'data_inicio' => $reserva['data_inicio'],
        'data_fim' => $reserva['data_fim'],
        'preco_total' => $reserva['total'],
        'status' => 'reservado',
        'local_retirada' => $reserva['local_retirada'],
    ]);
    session()->forget('reserva');
    session(['reserva_id' => $reservaCriada->id]);
    return redirect()->route('multibanco.finish');
}

// Exibe a tela de finalização da reserva
public function finishMultibanco(Request $request)
{
    $reservaId = session('reserva_id');
    if (!$reservaId) {
        return redirect()->route('dashboard')->with('error', 'Reserva não encontrada.');
    }
    $reserva = Reserva::with(['bemLocavel.marca', 'user'])->findOrFail($reservaId);
    return view('finish-transaction', compact('reserva'));
}

// Exibe a tela de confirmação da reserva antes de gerar referência Multibanco
public function confirmar(Request $request)
{
    if ($request->isMethod('get')) {
        // GET: Mostra a view de confirmação com o resumo e o reCAPTCHA
        $carro = \App\Models\BemLocavel::with('marca')->findOrFail($request->carro_id);
        $data_inicio = $request->data_inicio;
        $data_fim = $request->data_fim;
        $local_retirada = $request->local_retirada;
        $dias = \Carbon\Carbon::parse($data_inicio)->diffInDays(\Carbon\Carbon::parse($data_fim));
        $total = $dias > 0 ? $dias * ($carro->preco_diario ?? $carro->preco_dia) : 0;
        // Verificar conflito de datas ANTES de mostrar o resumo
        $conflito = \App\Models\Reserva::where('bem_locavel_id', $carro->id)
            ->where(function($query) use ($data_inicio, $data_fim) {
                $query->whereBetween('data_inicio', [$data_inicio, $data_fim])
                      ->orWhereBetween('data_fim', [$data_inicio, $data_fim])
                      ->orWhere(function($q) use ($data_inicio, $data_fim) {
                          $q->where('data_inicio', '<=', $data_inicio)
                            ->where('data_fim', '>=', $data_fim);
                      });
            })
            ->where('status', '!=', 'cancelado')
            ->first();
        if ($conflito) {
            $msg = 'Este carro já está reservado para o período de ' .
                date('d/m/Y', strtotime($conflito->data_inicio)) . ' a ' .
                date('d/m/Y', strtotime($conflito->data_fim)) . '. Por favor, escolha outras datas.';
            return back()->withErrors(['data_inicio' => $msg])->withInput();
        }
        return view('reservas.confirmar', compact('carro', 'data_inicio', 'data_fim', 'local_retirada', 'dias', 'total'));
    }
    // POST: Processa o reCAPTCHA e avança
    // Validação do reCAPTCHA
    if (!$request->has('g-recaptcha-response') || empty($request->input('g-recaptcha-response'))) {
        Log::warning('reCAPTCHA não marcado', [
            'ip' => $request->ip(),
            'user_id' => Auth::id(),
            'input' => $request->all(),
        ]);
        return back()->withErrors(['captcha' => 'Por favor, confirme que não é um robô.'])->withInput();
    }
    $response = \Illuminate\Support\Facades\Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
        'secret' => config('services.google.recaptcha_secret_key'),
        'response' => $request->input('g-recaptcha-response'),
        'remoteip' => $request->ip(),
    ]);
    $result = $response->json();
    if (!($result['success'] ?? false)) {
        \Illuminate\Support\Facades\Log::warning('Falha na verificação do reCAPTCHA', [
            'ip' => $request->ip(),
            'user_id' => Auth::id(),
            'input' => $request->all(),
            'google_response' => $result,
        ]);
        $msg = 'Falha na verificação do reCAPTCHA.';
        if (!empty($result['error-codes'])) {
            $msg .= ' Erro(s): ' . implode(', ', $result['error-codes']);
        }
        $msg .= ' Se o problema persistir, contacte o suporte ou verifique a consola do browser para erros de JavaScript.';
        return back()->withErrors(['captcha' => $msg])->withInput();
    }
    $carro = \App\Models\BemLocavel::with('marca')->findOrFail($request->carro_id);
    $data_inicio = $request->data_inicio;
    $data_fim = $request->data_fim;
    $local_retirada = $request->local_retirada;
    $dias = \Carbon\Carbon::parse($data_inicio)->diffInDays(\Carbon\Carbon::parse($data_fim));
    $total = $dias > 0 ? $dias * ($carro->preco_diario ?? $carro->preco_dia) : 0;
    // Verificar conflito de datas ANTES de avançar para o Multibanco
    $conflito = \App\Models\Reserva::where('bem_locavel_id', $carro->id)
        ->where(function($query) use ($data_inicio, $data_fim) {
            $query->whereBetween('data_inicio', [$data_inicio, $data_fim])
                  ->orWhereBetween('data_fim', [$data_inicio, $data_fim])
                  ->orWhere(function($q) use ($data_inicio, $data_fim) {
                      $q->where('data_inicio', '<=', $data_inicio)
                        ->where('data_fim', '>=', $data_fim);
                  });
        })
        ->where('status', '!=', 'cancelado')
        ->first();
    if ($conflito) {
        $msg = 'Este carro já está reservado para o período de ' .
            date('d/m/Y', strtotime($conflito->data_inicio)) . ' a ' .
            date('d/m/Y', strtotime($conflito->data_fim)) . '. Por favor, escolha outras datas.';
        return back()->withErrors(['data_inicio' => $msg])->withInput();
    }
    // Guardar dados em sessão para o próximo passo
    session(['reserva' => [
        'carro_id' => $carro->id,
        'data_inicio' => $data_inicio,
        'data_fim' => $data_fim,
        'local_retirada' => $local_retirada,
        'total' => $total,
        'user_id' => Auth::id(),
    ]]);
    // Redirecionar para a referência Multibanco
    return redirect()->route('transaction');
}

public function enviarEmailReserva($id)
{
    $reserva = \App\Models\Reserva::with(['bemLocavel.marca', 'user'])->findOrFail($id);
    $dias = \Carbon\Carbon::parse($reserva->data_inicio)->diffInDays(\Carbon\Carbon::parse($reserva->data_fim));
    $user = Auth::user();
    Mail::to($user->email)->send(new ReservaDetalhesMail($reserva, $dias));
    return back()->with('success', 'Email com os detalhes da reserva enviado com sucesso!');
}

public function show($id)
{
    $reserva = \App\Models\Reserva::with(['bemLocavel.marca', 'user'])->findOrFail($id);
    // Permitir apenas ao próprio utilizador ver a sua reserva
    if ($reserva->user_id !== Auth::id()) {
        abort(403, 'Não autorizado.');
    }
    return view('reservas.show', compact('reserva'));
}
}
