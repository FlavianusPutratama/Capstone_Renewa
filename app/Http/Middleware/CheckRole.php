<?php
//app/Http/Middleware/CheckRole.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            // Arahkan ke rute login pembeli
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        if ($role == 'buyer' && $user->role !== 'buyer') {
            abort(403, 'Unauthorized action.');
        }
        
        if ($role == 'issuer' && $user->role !== 'issuer') {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}