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

        // Card de turismo carrossel
        $cardsTurismo = [
            [
                'titulo' => 'Serra da Estrela',
                'descricao' => 'Descobre o ponto mais alto de Portugal Continental, com paisagens deslumbrantes durante todo o ano. Ideal para caminhadas, desportos de inverno e passeios de carro por aldeias históricas e montanhas cobertas de neve. Visita o famoso queijo da serra e prova os sabores únicos da região.',
                'imagem' => 'serradaestrela.webp',
            ],
            [
                'titulo' => 'Sintra - Palácio da Pena',
                'descricao' => 'Um verdadeiro conto de fadas às portas de Lisboa, rodeado de florestas místicas e arquitetura colorida. O Palácio da Pena é um ícone do romantismo europeu e oferece vistas panorâmicas únicas. Perde-te pelos jardins e descobre os segredos da Serra de Sintra..',
                'imagem' => 'palaciopena.webp',
            ],
            [
                'titulo' => 'Costa Vicentina',
                'descricao' => 'Uma das zonas costeiras mais bem preservadas da Europa, ideal para quem procura natureza e tranquilidade. Oferece praias selvagens, trilhos pedestres e aldeias piscatórias autênticas. Perfeita para surf, caminhadas e entardeceres mágicos sobre o Atlântico.',
                'imagem' => 'costavicentina.jpg',
            ],
            [
                'titulo' => 'Rota dos Vinhos do Douro',
                'descricao' => 'Um dos destinos mais emblemáticos de Portugal, onde a tradição vinícola e a beleza natural se unem. Viaja pelas margens do rio em rotas panorâmicas e visita quintas centenárias com provas de vinho. Classificado como Património Mundial, é um destino imperdível para os amantes de paisagens e enoturismo.',
                'imagem' => 'douro.jpg',
            ],
            [
                'titulo' => 'Serra do Gerês',
                'descricao' => 'Um paraíso natural no norte de Portugal, inserido no único Parque Nacional do país – o Parque Nacional da Peneda-Gerês. Ideal para quem procura trilhos, cascatas, miradouros e aldeias preservadas no tempo. Descobre locais mágicos como a Cascata do Arado, a Mata da Albergaria ou os trilhos da Geira Romana.',
                'imagem' => 'geres.jpg',
            ],
        ];
        // Não escolher aleatório, passar todos para o carrossel
        return view('dashboard', [
            'locations' => $locations,
            'availableCars' => $availableCars,
            'selectedCidade' => $request->input('cidade'),
            'selectedFilial' => $request->input('filial'),
            'dataInicio' => $request->input('data_inicio'),
            'dataFim' => $request->input('data_fim'),
            'cardsTurismo' => $cardsTurismo,
        ]);
    }
}
