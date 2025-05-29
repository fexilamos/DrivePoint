<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BemLocavel;

class PesquisaController extends Controller
{
    public function index(Request $request)
    {
        $query = BemLocavel::query();

        if ($request->filled('modelo')) {
            $query->where('modelo', 'like', '%' . $request->modelo . '%');
        }

        if ($request->filled('cor')) {
            $query->where('cor', $request->cor);
        }

        if ($request->filled('transmissao')) {
            $query->where('transmissao', $request->transmissao);
        }

        if ($request->filled('combustivel')) {
            $query->where('combustivel', $request->combustivel);
        }

        if ($request->filled('ano')) {
            $query->where('ano', $request->ano);
        }

        $resultados = $query->get();

        return view('pesquisa.resultados', compact('resultados'));
    }
}
