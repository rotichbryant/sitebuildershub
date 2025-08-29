<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LandingOptionalAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $guard = 'client'): Response
    {   
        if( Auth::guard($guard)->check() ){
            $request->setUserResolver(function () use ($guard) {
                return Auth::guard($guard)->user();
            });
        }

        return $next($request);
    }
    
}
