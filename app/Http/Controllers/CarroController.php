<?php

namespace App\Http\Controllers;

use App\Models\BemLocavel;
use Illuminate\Http\Request;

class CarroController extends Controller
{
    public function index()
    {
        // Listar todos os carros
        $carros = BemLocavel::all();
        return view('carros.index', compact('carros'));
    }

    public function create()
    {
        // Formulário para adicionar novo BemLocavel
        return view('carros.create');
    }

    public function store(Request $request)
    {
        // // Validar e guardar novo BemLocavel
        // $validated = $request->validate([
        //     'marca' => 'required|string|max:255',
        //     'modelo' => 'required|string|max:255',
        //     'ano' => 'required|integer|min:1900|max:' . date('Y'),
        //     'matricula' => 'required|string|max:20|unique:carros',
        //     'preco_dia' => 'required|numeric|min:0',
        //     'imagem' => 'nullable|image|max:2048',
        // ]);

        if ($request->hasFile('imagem')) {
            $validated['imagem'] = $request->file('imagem')->store('carros', 'public');
        }

        BemLocavel::create($validated);

        return redirect()->route('carros.index')->with('success', 'BemLocavel adicionado com sucesso!');
    }

    public function show(BemLocavel $BemLocavel)
    {
        // Mostrar detalhes de um BemLocavel
        return view('carros.show', compact('BemLocavel'));
    }

    public function edit(BemLocavel $BemLocavel)
    {
        // Formulário para editar BemLocavel
        return view('carros.edit', compact('BemLocavel'));
    }

    public function update(Request $request, BemLocavel $BemLocavel)
    {
        // Validar e atualizar BemLocavel
        $validated = $request->validate([
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'ano' => 'required|integer|min:1900|max:' . date('Y'),
            'matricula' => 'required|string|max:20|unique:carros,matricula,' . $BemLocavel->id,
            'preco_dia' => 'required|numeric|min:0',
            'imagem' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagem')) {
            $validated['imagem'] = $request->file('imagem')->store('carros', 'public');
        }

        $BemLocavel->update($validated);

        return redirect()->route('carros.index')->with('success', 'BemLocavel atualizado com sucesso!');
    }

    public function destroy(BemLocavel $BemLocavel)
    {
        // Apagar BemLocavel
        $BemLocavel->delete();
        return redirect()->route('carros.index')->with('success', 'BemLocavel removido com sucesso!');
    }
}
