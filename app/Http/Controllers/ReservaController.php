<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use Illuminate\Support\Facades\Auth;

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

    Reserva::create([
        'user_id' => Auth::id(),
        'carro_id' => $request->bem_locavel_id,
        'data_inicio' => $request->data_inicio,
        'data_fim' => $request->data_fim,
        'local_retirada' => $request->local_retirada,
    ]);

    return redirect()->route('dashboard')->with('success', 'Reserva realizada com sucesso!');
}
}
