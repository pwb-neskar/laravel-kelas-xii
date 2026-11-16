<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Pemakaian di route: ->middleware('role:admin') atau 'role:admin,user'
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        // Belum login: arahkan ke beranda dengan modal login terbuka
        if (! $user) {
            return redirect()->route('login');
        }

        // Sudah login tetapi role tidak sesuai: tolak dengan 403
        if (! in_array($user->role?->name, $roles, true)) {
            abort(403, 'Anda tidak punya hak akses ke halaman ini.');
        }

        return $next($request);
    }
}