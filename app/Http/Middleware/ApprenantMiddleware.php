<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApprenantMiddleware
{
    /**
     * Vérifie que l'utilisateur connecté est un apprenant.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isApprenant()) {
            abort(403, 'Accès réservé aux apprenants.');
        }

        return $next($request);
    }
}
