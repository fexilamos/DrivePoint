<?php

namespace App\Http\Controllers;

use App\Models\Carro;
use Illuminate\Http\Request;

class CarroController extends Controller
{
    public function index()
    {
        // Listar todos os carros
        $carros = Carro::all();
        return view('carros.index', compact('carros'));
    }

    public function create()
    {
        // Formulário para adicionar novo carro
        return view('carros.create');
    }

    public function store(Request $request)
    {
        // Validar e guardar novo carro
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

        Carro::create($validated);

        return redirect()->route('carros.index')->with('success', 'Carro adicionado com sucesso!');
    }

    public function show(Carro $carro)
    {
        // Mostrar detalhes de um carro
        return view('carros.show', compact('carro'));
    }

    public function edit(Carro $carro)
    {
        // Formulário para editar carro
        return view('carros.edit', compact('carro'));
    }

    public function update(Request $request, Carro $carro)
    {
        // Validar e atualizar carro
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

    public function destroy(Carro $carro)
    {
        // Apagar carro
        $carro->delete();
        return redirect()->route('carros.index')->with('success', 'Carro removido com sucesso!');
    }
}
