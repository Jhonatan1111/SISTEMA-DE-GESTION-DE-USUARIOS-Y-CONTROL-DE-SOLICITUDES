<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {

        // si el usuario no está autenticado, redirigir al login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // si el usuario no es administrador, abortar con error 403 y bloquear el acceso
        if ($user->role !== 'admin') {
            abort(403, 'No tienes permisos para acceder a esta sección. Solo administradores pueden ingresar.');
        }

        return $next($request);
    }
}