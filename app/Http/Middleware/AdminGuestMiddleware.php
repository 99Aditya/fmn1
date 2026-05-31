<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminGuestMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            return $next($request);
        }

        if (auth()->user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        return redirect('/')->with('flash-error', 'You are already logged in as a regular user.');
    }
}
