<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BemLocavel;
use Illuminate\Support\Facades\DB;

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

    public function reservas(Request $request)
    {
        $locations = DB::table('localizacoes')
            ->select('cidade', 'filial')
            ->distinct()
            ->get()
            ->map(fn($item) => (array) $item)
            ->toArray();

        $availableCars = collect();

        $cidade = $request->input('cidade');
        $filial = $request->input('filial');
        $dataInicio = $request->input('data_inicio');
        $dataFim = $request->input('data_fim');

        if ($cidade && $filial && $dataInicio && $dataFim) {
            $carIdsAtLocation = DB::table('localizacoes')
                ->where('cidade', $cidade)
                ->where('filial', $filial)
                ->pluck('bem_locavel_id');

            $reservedCarIds = DB::table('reservas')
                ->whereIn('bem_locavel_id', $carIdsAtLocation)
                ->where(function ($query) use ($dataInicio, $dataFim) {
                    $query->whereBetween('data_inicio', [$dataInicio, $dataFim])
                        ->orWhereBetween('data_fim', [$dataInicio, $dataFim])
                        ->orWhere(function ($q) use ($dataInicio, $dataFim) {
                            $q->where('data_inicio', '<=', $dataInicio)
                              ->where('data_fim', '>=', $dataFim);
                        });
                })
                ->pluck('bem_locavel_id');

            $availableCarIds = $carIdsAtLocation->diff($reservedCarIds);
            $availableCars = \App\Models\BemLocavel::whereIn('id', $availableCarIds)->get();
        }

        return view('pesquisa.reservas', [
            'locations' => $locations,
            'availableCars' => $availableCars,
            'selectedCidade' => $cidade,
            'selectedFilial' => $filial,
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
        ]);
    }
}
