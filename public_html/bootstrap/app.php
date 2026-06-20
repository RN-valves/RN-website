<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Laravel\Passport\Http\Middleware\CheckClientCredentials;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Allow the PTMT landing page (cross-origin) to POST to /store-popup-form-response
        $middleware->prepend(\Illuminate\Http\Middleware\HandleCors::class);

        $middleware->validateCsrfTokens(except: [
            'store-popup-form-response',
        ]);

        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,

            'client' => CheckClientCredentials::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (Throwable $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => 505,
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                ], 505);
            }
            if (Str::contains(request()->getRequestUri(), '/index.php/')) {

                //$url = str_replace('index.php/', '', request()->getRequestUri());
                $url = url('/');	

                if (strlen($url) > 0) {

                    header("Location: $url", true, 301);
                    //redirect('/');
                    exit;

                }
            }
        });
    })->create();
