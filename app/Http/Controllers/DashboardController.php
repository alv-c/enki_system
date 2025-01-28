<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campanha;
use App\Models\Rifa;
use App\Models\CampanhaPlanoPromocao;

class DashboardController extends Controller
{
    public function index()
    {
        // Coletando as estatísticas para o dashboard
        $totalCampanhas = Campanha::count();
        $totalRifas = Rifa::count();
        $totalPlanos = CampanhaPlanoPromocao::count();
        $campanhasAtivas = Campanha::where('status', 'ativo')->count();
        $rifasDisponiveis = Rifa::where('status', 'disponivel')->count();

        return view('dashboard', compact(
            'totalCampanhas',
            'totalRifas',
            'totalPlanos',
            'campanhasAtivas',
            'rifasDisponiveis'
        ));
    }
}
