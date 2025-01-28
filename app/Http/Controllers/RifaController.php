<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campanha;
use App\Models\Rifa;

class RifaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Campanha $campanha)
    {
        $rifas = $campanha->rifas()->orderBy('numero')->get();
        return view('rifas.index', compact('campanha', 'rifas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Campanha $campanha)
    {
        return view('rifas.create', compact('campanha'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Campanha $campanha)
    {
        $validated = $request->validate([
            'numero' => 'required|unique:rifas,numero',
            'status' => 'required|in:disponivel,reservada,vendida',
        ]);
        // Criação da rifa associada à campanha
        $campanha->rifas()->create($validated);
        return redirect()->route('campanhas.rifas.index', $campanha->id)
            ->with('success', 'Rifa criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Rifa $rifa)
    {
        return view('rifas.show', compact('rifa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rifa $rifa)
    {
        return view('rifas.edit', compact('rifa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rifa $rifa)
    {
        $validated = $request->validate([
            'numero' => 'required|unique:rifas,numero,' . $rifa->id,
            'status' => 'required|in:disponivel,reservada,vendida',
        ]);
        $rifa->update($validated);
        return redirect()->route('campanhas.rifas.index', $rifa->campanha_id)
            ->with('success', 'Rifa atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rifa $rifa)
    {
        $rifa->delete();
        return redirect()->route('campanhas.rifas.index', $rifa->campanha_id)
            ->with('success', 'Rifa excluída com sucesso!');
    }
}
