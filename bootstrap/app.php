<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        $middleware->alias([
            'admin.auth'            => \App\Http\Middleware\AdminRedirectIfAuth::class,
            'admin.guest'           => \App\Http\Middleware\AdminRedirectIfNotAuth::class,
            'admin.role'            => \App\Http\Middleware\RedirectIfNotAdmin::class,
            'landing.auth'          => \App\Http\Middleware\LandingRedirectIfNotAuth::class,
            'landing.guest'         => \App\Http\Middleware\LandingRedirectIfAuth::class,
            'landing.auth.optional' => \App\Http\Middleware\LandingOptionalAuth::class,
        ]);

        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        // $exceptions->respond(function (Response $response) {
        //     if ($response->getStatusCode() === 419) {
        //         return back()->with([
        //             'message' => 'The page expired, please try again.',
        //         ]);
        //     }
    
        //     return $response;
        // });
        $exceptions->respond(function (Response $response) {

            if ( in_array($response->getStatusCode(), [404, 403]) ) {
                return Inertia::render(
                    str_contains(request()->path(),'dashboard') ? 'Dashboard/ErrorPage' : 'Landing/ErrorPage', 
                    ['status' => $response->getStatusCode()]
                );
                // ->toResponse($request)->setStatusCode($response->getStatusCode());

            } elseif ($response->getStatusCode() === 419) {

                return back()->with([
                    'message' => 'The page expired, please try again.',
                ]);
                
            }

            return $response;
        });
    })->create();
