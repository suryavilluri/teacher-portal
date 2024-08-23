<?php

namespace App\Http\Middleware;

use Closure, Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthTeacher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $guard = null): Response
    {
        if (Auth::guard($guard)->guest()) {dd($guard);
            return redirect('/');
        }
        return $next($request);
    }
}
