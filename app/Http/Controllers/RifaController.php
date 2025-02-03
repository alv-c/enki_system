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
     * Display the specified resource.
     */
    public function show(Rifa $rifa)
    {
        return view('rifas.show', compact('rifa'));
    }
}
