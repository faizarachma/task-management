<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Cek sudah login
        if (!auth()->check()) {
            return redirect()->route('filament.admin.auth.login'); // Redirect ke login admin default
        }

        // 2. Cek role sesuai parameter
        if (auth()->user()->role !== $role) {
            abort(403, 'Akses ditolak. Role Anda: '.auth()->user()->role);
        }

        // 3. Redirect ke panel yang sesuai jika mencoba akses panel lain
        $currentPanel = $request->segment(1); // 'admin' atau 'developer'

        if ($currentPanel !== auth()->user()->role) {
            return match(auth()->user()->role) {
                'admin' => redirect()->route('filament.admin.pages.dashboard'),
                'developer' => redirect()->route('filament.developer.pages.dashboard'),
                default => abort(403)
            };
        }

        return $next($request);
    }
}
