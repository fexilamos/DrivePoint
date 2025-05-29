<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BemLocavel;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
       $locations = DB::table('localizacoes')
    ->select('cidade', 'filial')
    ->distinct()
    ->get()
    ->map(fn($item) => (array) $item)
    ->toArray();

        $availableCars = collect();

        if ($request->has(['cidade', 'filial', 'data_inicio', 'data_fim'])) {
            $cidade = $request->input('cidade');
            $filial = $request->input('filial');
            $dataInicio = $request->input('data_inicio');
            $dataFim = $request->input('data_fim');

            // Get bem_locavel_ids for the selected location
            $carIdsAtLocation = DB::table('localizacoes')
                ->where('cidade', $cidade)
                ->where('filial', $filial)
                ->pluck('bem_locavel_id');

            // Get cars at location that are NOT reserved in the selected date range
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

            $availableCars = BemLocavel::whereIn('id', $availableCarIds)->get();
        }
// dd($locations);
        return view('dashboard', [
            'locations' => $locations,
            'availableCars' => $availableCars,
            'selectedCidade' => $request->input('cidade'),
            'selectedFilial' => $request->input('filial'),
            'dataInicio' => $request->input('data_inicio'),
            'dataFim' => $request->input('data_fim'),
        ]);
    }
}
