<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateAdminAccount
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jika user tidak terautentikasi atau role bukan admin
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            auth()->logout();
            return redirect()->route('filament.admin.auth.login')
                ->withErrors(['email' => 'Akun tidak memiliki akses admin.']);
        }

        return $next($request);
    }
}
