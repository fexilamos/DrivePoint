<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ReservaController extends Controller
{
   public function store(Request $request)
{
    $request->validate([
        'bem_locavel_id' => 'required|exists:carros,id',
        'data_inicio' => 'required|date',
        'data_fim' => 'required|date|after:data_inicio',
        'local_retirada' => 'required|string|max:255',
    ]);

    $existeReserva = \App\Models\Reserva::where('carro_id', $request->bem_locavel_id)
        ->where(function($query) use ($request) {
            $query->whereBetween('data_inicio', [$request->data_inicio, $request->data_fim])
                  ->orWhereBetween('data_fim', [$request->data_inicio, $request->data_fim])
                  ->orWhere(function($q) use ($request) {
                      $q->where('data_inicio', '<=', $request->data_inicio)
                        ->where('data_fim', '>=', $request->data_fim);
                  });
        })
        ->exists();

    if ($existeReserva) {
        return back()->withErrors(['data_inicio' => 'Este carro já está reservado para as datas selecionadas.']);
    }

    Reserva::create([
        'user_id' => Auth::id(),
        'carro_id' => $request->bem_locavel_id,
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
}
