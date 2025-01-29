<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica se o usuário está autenticado e se o papel é admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            // Redireciona para a página inicial ou de login
            return redirect('/')->with('error', 'Acesso negado. Você não tem permissão para acessar esta área.');
        }

        return $next($request);
    }
}
