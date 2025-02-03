<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campanha;

class CampanhaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $campanhas = Campanha::orderBy('created_at', 'desc')->paginate(10);
        return view('campanhas.index', compact('campanhas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('campanhas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'subtitulo' => 'nullable|string|max:255',
            'descricao' => 'nullable|string',
            'status' => 'required|in:ativo,inativo,finalizado,pendente',
            'galeria.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'valor_cota' => 'required|numeric|min:0',
            'num_cotas_disponiveis' => 'required|integer|min:1',
        ]);

        // Upload de imagens (se necessário)
        if ($request->hasFile('galeria')) {
            $validated['galeria'] = array_map(fn($image) => $image->store('galerias', 'public'), $request->file('galeria'));
        }
        $validated['galeria'] = json_encode($validated['galeria'] ?? []);
        // Criar campanha (rifas serão geradas automaticamente)
        Campanha::create($validated);
        return redirect()->route('campanhas.index')->with('success', 'Campanha criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Campanha $campanha)
    {
        $campanha->load('planosPromocao', 'rifas');
        // Debug temporário
        // dd($campanha->rifas);
        return view('campanhas.show', compact('campanha'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campanha $campanha)
    {
        return view('campanhas.edit', compact('campanha'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Campanha $campanha)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'subtitulo' => 'nullable|string|max:255',
            'descricao' => 'nullable|string',
            'status' => 'required|in:ativo,inativo,finalizado,pendente',
            'galeria.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'valor_cota' => 'required|numeric|min:0',
            'num_cotas_disponiveis' => 'required|integer|min:0',
        ]);
        if ($request->hasFile('galeria')) {
            $validated['galeria'] = array_map(function ($image) {
                return $image->store('galerias', 'public');
            }, $request->file('galeria'));
        }
        $validated['galeria'] = json_encode($validated['galeria'] ?? []);
        $campanha->update($validated);
        return redirect()->route('campanhas.index')->with('success', 'Campanha atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campanha $campanha)
    {
        $campanha->delete();
        return redirect()->route('campanhas.index')->with('success', 'Campanha excluída com sucesso!');
    }
}
