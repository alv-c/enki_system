<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::where('user_id', Auth::id())->with(['campanha', 'rifas'])->get();

        return view('comprador.meus-pedidos', compact('pedidos'));
    }
}
