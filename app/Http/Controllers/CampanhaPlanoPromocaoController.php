<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campanha;
use App\Models\CampanhaPlanoPromocao;

class CampanhaPlanoPromocaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Campanha $campanha)
    {
        $planos = $campanha->planos()->orderBy('created_at', 'desc')->get();
        return view('planos.index', compact('campanha', 'planos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Campanha $campanha)
    {
        return view('planos.create', compact('campanha'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Campanha $campanha)
    {
        $validated = $request->validate([
            'num_rifas' => 'required|integer|min:1',
            'valor_plano' => 'required|numeric|min:0',
        ]);

        $campanha->planos()->create($validated);

        return redirect()->route('campanhas.planos.index', $campanha->id)
            ->with('success', 'Plano de promoção criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(CampanhaPlanoPromocao $plano)
    {
        return view('planos.show', compact('plano'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CampanhaPlanoPromocao $plano)
    {
        return view('planos.edit', compact('plano'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CampanhaPlanoPromocao $plano)
    {
        $validated = $request->validate([
            'num_rifas' => 'required|integer|min:1',
            'valor_plano' => 'required|numeric|min:0',
        ]);

        $plano->update($validated);

        return redirect()->route('campanhas.planos.index', $plano->campanha_id)
            ->with('success', 'Plano de promoção atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CampanhaPlanoPromocao $plano)
    {
        $plano->delete();

        return redirect()->route('campanhas.planos.index', $plano->campanha_id)
            ->with('success', 'Plano de promoção excluído com sucesso!');
    }
}
