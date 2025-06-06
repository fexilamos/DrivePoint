<?php

namespace App\Http\Controllers;

use App\Models\BemLocavel;
use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarroController extends Controller
{
    public function index(Request $request)
    {
        $marcas = Marca::orderBy('nome')->pluck('nome', 'id');
        $allCores = BemLocavel::pluck('cor')->unique()->sort();
        $query = BemLocavel::query();

        if ($request->filled('marca')) {
            $marcaId = Marca::where('nome', $request->marca)->value('id');
            if ($marcaId) {
                $query->where('marca_id', $marcaId);
            }
        }
        if ($request->filled('cor')) {
            $query->where('cor', $request->cor);
        }
        if ($request->filled('disponivel') && $request->disponivel !== '') {
            $query->where('disponivel', $request->disponivel);
        }

        $carros = $query->with('marca')->get();
        $cores = $allCores;
        return view('carros.index', compact('carros', 'marcas', 'cores'));
    }

    public function create()
    {
        return view('carros.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'ano' => 'required|integer|min:1900|max:' . date('Y'),
            'matricula' => 'required|string|max:20|unique:carros',
            'preco_dia' => 'required|numeric|min:0',
            'imagem' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagem')) {
            $validated['imagem'] = $request->file('imagem')->store('carros', 'public');
        }

        BemLocavel::create($validated);

        return redirect()->route('carros.index')->with('success', 'Carro adicionado com sucesso!');
    }

    public function show(BemLocavel $carro, Request $request)
    {
        $data_inicio = $request->query('data_inicio');
        $data_fim = $request->query('data_fim');

        $disponivel = $data_inicio && $data_fim
            ? $carro->estaDisponivel($data_inicio, $data_fim)
            : null;

        $locais = DB::table('localizacoes')
            ->where('bem_locavel_id', $carro->id)
            ->pluck('filial');

        $dias = null;
        $total = null;
        if ($data_inicio && $data_fim) {
            $dias = \Carbon\Carbon::parse($data_inicio)->diffInDays(\Carbon\Carbon::parse($data_fim));
            $total = $dias > 0 ? $dias * ($carro->preco_diario ?? $carro->preco_dia) : 0;
        }

        return view('carros.show', compact('carro', 'data_inicio', 'data_fim', 'disponivel', 'locais', 'dias', 'total'));
    }

    public function edit(BemLocavel $carro)
    {
        return view('carros.edit', compact('carro'));
    }

    public function update(Request $request, BemLocavel $carro)
    {
        $validated = $request->validate([
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'ano' => 'required|integer|min:1900|max:' . date('Y'),
            'matricula' => 'required|string|max:20|unique:carros,matricula,' . $carro->id,
            'preco_dia' => 'required|numeric|min:0',
            'imagem' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagem')) {
            $validated['imagem'] = $request->file('imagem')->store('carros', 'public');
        }

        $carro->update($validated);

        return redirect()->route('carros.index')->with('success', 'Carro atualizado com sucesso!');
    }

    public function destroy(BemLocavel $carro)
    {
        $carro->delete();
        return redirect()->route('carros.index')->with('success', 'Carro removido com sucesso!');
    }
}
