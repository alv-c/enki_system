<?php

namespace App\Http\Controllers\Comprador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardCompradorController extends Controller
{
    public function index()
    {
        return view('comprador.dashboard');
    }
}
