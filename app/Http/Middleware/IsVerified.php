<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $status = 1): Response
    {
        if (!$request->user()->is_verified && $status == 1) {
            return redirect()->route('verification.index')->withError('You need to verify your email address.');
        } elseif ($request->user()->is_verified && $status == 0) {
            return redirect()->route('dashboard')->withError('You are already verified.');
        }
        return $next($request);
    }
}
