<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $roleName): Response
    {
        $userRole = $request->session()->get('role'); // Ambil peran dari session

        if ($userRole === $roleName) {
            return $next($request);
        }
        return redirect()->back();
    }
}
