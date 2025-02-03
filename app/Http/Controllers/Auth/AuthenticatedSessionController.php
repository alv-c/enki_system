<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // Verificar se o usuário 'admin' foi aprovado
            if ($user->role == 'admin' && !$user->is_approved) {
                Auth::logout();
                return redirect()->route('login')->withErrors([
                    'email' => 'Sua conta ainda não foi aprovada. Aguarde aprovação pelo administrador.',
                ]);
            } else if ($user->role == 'admin' && $user->is_approved) {
                $request->session()->regenerate();
                return redirect()->intended('/sistema');
            } else if ($user->role == 'comprador') {
                $request->session()->regenerate();
                return redirect()->intended('/comprador/campanhas');
            }
        }

        throw ValidationException::withMessages([
            'email' => 'As credenciais fornecidas estão incorretas.',
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
