<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        // Si no hay usuario autenticado
        if (!$user) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión.');
        }

        // Si el usuario es admin → acceso total
        if ($user->rol === 'admin') {
            return $next($request);
        }

        // Si no se especificaron roles y NO es admin → 403
        if (empty($roles)) {
            abort(403, 'Acceso no autorizado.');
        }

        // Verificar si el rol del usuario está permitido
        if (!in_array($user->rol, $roles)) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        return $next($request);
    }
}
