<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->getPathInfo();
        $path = explode('/', $path);
        $path = $path[1];

        if (Auth::user()->role != 'Admin' && $path == 'admin') {
            return redirect()->route('home');
        }
        if (Auth::user()->role != 'Guru' && $path == 'guru') {
            return redirect()->route('home');
        }
        if (Auth::user()->role != 'Siswa' && $path == 'siswa') {
            return redirect()->route('home');
        }
        return $next($request);
    }
}
