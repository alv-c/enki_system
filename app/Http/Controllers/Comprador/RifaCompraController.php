<?php

namespace App\Http\Controllers\Comprador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campanha;
use App\Models\Rifa;

class RifaCompraController extends Controller
{
    // Exibir campanhas disponíveis
    public function index()
    {
        $campanhas = Campanha::where('status', 'ativo')->get();
        return view('comprador.campanhas', compact('campanhas'));
    }

    // Exibir detalhes da campanha e rifas disponíveis
    public function show(Campanha $campanha)
    {
        $rifas = Rifa::where('id_campanha', $campanha->id)
            ->where('status', 'disponivel')
            ->get();
        return view('comprador.rifas', compact('campanha', 'rifas'));
    }
}
