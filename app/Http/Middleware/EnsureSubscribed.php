<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSubscribed
{
    /**
     * Gate a route behind a Pro capability.
     * Usage: ->middleware('pro:adaptive')  or just ->middleware('pro')
     */
    public function handle(Request $request, Closure $next, ?string $feature = null): Response
    {
        $user = $request->user();

        $allowed = $user && ($feature ? $user->canUse($feature) : $user->isPro());

        if (!$allowed) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message'  => 'This is a Pro feature. Please upgrade to continue.',
                    'upgrade'  => route('pricing'),
                ], 403);
            }
            return redirect()->route('pricing')
                ->with('status', 'That’s a Pro feature — upgrade to unlock it.');
        }

        return $next($request);
    }
}
