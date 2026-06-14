<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckEtatCompte
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->etat_compte !== 'actif') {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Votre compte est suspendu. Contactez l\'administration.']);
        }

        return $next($request);
    }
}